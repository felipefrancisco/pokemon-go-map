<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/21/2016
 * Time: 12:36 AM
 */

namespace App\Services;

use App\ApiLog;
use App\Library\Hashing\GibberishAES;
use App\Marker;
use App\Report;
use App\Sight;
use App\User;

class MarkerService
{
    /**
     * @var BucketService
     */
    protected $bucketService;

    /**
     * @var PokemonService
     */
    protected $pokemonService;

    /**
     * @var string
     */
    protected static $aeskey;

    /**
     * MarkerService constructor.
     * @param BucketService $bucketService
     * @param PokemonService $pokemonService
     * @param CacheService $cacheService
     */
    public function __construct(BucketService $bucketService, PokemonService $pokemonService, CacheService $cacheService)
    {
        $this->bucketService = $bucketService;
        $this->pokemonService = $pokemonService;
        $this->cacheService = $cacheService;

        if(!self::$aeskey)
            self::$aeskey = getenv('GIB_AES_KEY');
    }

    /**
     * @param $marker
     * @param bool $encrypt
     * @return array
     */
    public function response($marker, $encrypt = true) {

        if(!($marker instanceof Marker))
            $marker = new Marker((array)$marker);

        $r = [
            'location' => $marker->location(),
            'number' => (int)$marker->number,
            'uuid' => $marker->uuid,
            'src' => $marker->url(),
            'formated_number' =>  $marker->formattedNumber(),
            'date' => $marker->formattedDate(),
            'reports' => $marker->reports ?: 0,
            'sights' => $marker->sights ?: 1
        ];

        if($encrypt)
            $r['location'] = $this->encrypt($r['location'], $r['uuid']);

        unset($marker);

        return $r;
    }

    /**
     * @param $location
     * @param $uuid
     * @return mixed
     */
    public function encrypt($location, $uuid) {

        GibberishAES::size(256);

        return GibberishAES::enc(json_encode($location), $uuid . self::$aeskey);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function findByUuid($uuid) {

        return Marker::where('uuid', $uuid)->first();
    }

    /**
     * @param User $user
     * @param Marker $marker
     * @return Marker
     */
    public function registerSight(User $user, Marker $marker) {

        # create sight object
        $sight = new Sight();

        # fill instance
        $sight->user_id = $user->id;
        $sight->marker_id = $marker->id;
        $sight->save();

        # sum sight total
        $marker->sights = $marker->sights+1;
        $marker->save();

        # @todo invalidate user sight caching
        # @todo invalidate marker storage caching

        return $marker;
    }

    public function registerReport(User $user, Marker $marker) {

        # create report object
        $report = new Report();

        # fill instance
        $report->user_id = $user->id;
        $report->marker_id = $marker->id;
        $report->save();

        # sum report total
        $marker->reports = $marker->reports+1;
        $marker->save();

        # @todo invalidate user report caching
        # @todo invalidate marker storage caching


        return $marker;
    }

    /**
     * @return mixed
     */
    public function get() {

        return \DB::table('markers')->whereNotIn('number', $this->pokemonService->legendaries())->get();
    }

    /**
     * @return array
     */
    public function generateDefaultOwnedMarkerResponse() {

        return [
            'report' => false,
            'owner'  => true,
            'seen'  => false,
        ];
    }

    /**
     * @return array
     */
    public function generateDefaultReportedMarkerResponse() {

        return [
            'report' => true,
            'owner'  => false,
            'seen'  => false
        ];;
    }

    /**
     * @return array
     */
    public function generateDefaultSpottedMarkerResponse() {

        return [
            'report' => false,
            'owner'  => false,
            'seen'  => true,
        ];
    }

    /**
     * @return mixed
     */
    public function latest() {

        return Marker::whereNotIn('number', $this->pokemonService->legendaries())->orderBy('id', 'desc')->limit(4)->get();
    }

    public function all($user, $api) {

        # if markers result is cached, retrieve from storage.
        if(!$result = $this->cacheService->get('pkm.storage')) {

            # if no cached result was found, perform the search on the database.
            $result = $this->get();

            # generate response for each marker
            foreach($result as $k => &$row)
                $row = $this->response($row, !$api);

            # set cache if is production
            if(getenv('APP_ENV') != 'local')
                $this->cacheService->set('pkm.storage', $result, 3600);
        }

        $data = [];

        # if user was found on first request
        if($user) {

            # get markers which are owned by the user.
            # @todo add caching for user.id.markers
            $x = \DB::table('markers')
                ->where('markers.user_id', $user->id)
                ->get();

            # genera response
            foreach($x as &$row)
                $data[$row->uuid] = $this->generateDefaultOwnedMarkerResponse();

            # get reported markers
            # @todo add caching for user.id.reports
            $x = \DB::table('reports')
                ->join('markers', 'markers.id', '=', 'reports.marker_id')
                ->where('reports.user_id', $user->id)
                ->select(['markers.uuid'])
                ->get();

            foreach($x as &$row) {

                # if marker was already retrieved, update its values
                if(isset($data[$row->uuid])) {

                    $data[$row->uuid]['report'] = true;
                    continue;
                }

                # if not, generate default response
                $data[$row->uuid] = $this->generateDefaultReportedMarkerResponse();
            }

            # get spotted markers
            # @todo add caching for user.id.sights
            $x = \DB::table('sights')
                ->join('markers', 'markers.id', '=', 'sights.marker_id')
                ->where('sights.user_id', $user->id)
                ->select(['markers.uuid'])
                ->get();

            foreach($x as &$row) {

                # if marker was already retrieved, update its values
                if(isset($data[$row->uuid])) {

                    $data[$row->uuid]['seen'] = true;
                    continue;
                }

                # if not, generate default response
                $data[$row->uuid] = $this->generateDefaultSpottedMarkerResponse();
            }
        }

        # create response
        $response = [
            'markers' => $result,
            'data' => $data
        ];

        return $response;
    }
}