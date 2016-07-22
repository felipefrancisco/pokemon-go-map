<?php

namespace App\Http\Controllers;

use App\ApiLog;
use App\Exceptions\BlockedIpAddressException;
use App\Location;
use App\Marker;
use App\Services\AuthService;
use App\Services\CacheService;
use App\Services\LocationService;
use App\Services\LoggerService;
use App\Services\MapService;
use App\Services\MarkerService;
use App\Services\NetworkingService;
use App\Services\PokemonService;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Ramsey\Uuid\Uuid;

class ApiController extends Controller
{
    /**
     * @var NetworkingService
     */
    protected $networkingService;

    /**
     * @var MarkerService
     */
    protected $markerService;

    /**
     * @var PokemonService
     */
    protected $pokemonService;

    /**
     * @var MapService
     */
    protected $mapService;

    /**
     * @var LoggerService
     */
    protected $loggerService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var CacheService
     */
    protected $cacheService;

    /**
     * @var AuthService
     */
    protected $authService;

    /**
     * @var LocationService
     */
    protected $locationService;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        # christ, too many injections.
        $this->networkingService = app(NetworkingService::class);
        $this->markerService     = app(MarkerService::class);
        $this->pokemonService    = app(PokemonService::class);
        $this->mapService        = app(MapService::class);
        $this->loggerService     = app(LoggerService::class);
        $this->userService       = app(UserService::class);
        $this->cacheService      = app(CacheService::class);
        $this->authService       = app(AuthService::class);
        $this->locationService   = app(LocationService::class);
    }

    /**
     * Add/update marker
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function marker(Request $request)
    {
        $log = null;

        try {

            # check if IP is blocked.
            if($this->networkingService->isIpBlocked($request->ip()))
                throw new BlockedIpAddressException();

            # get auth data from request.
            list($user, $log, $api) = $this->authService->fetchAuthDataFromRequest($request);

            # if user wasnt found
            if(!$user)
                throw new \Exception('user not found');

            # check if latitude is being provided by consumer
            if(!$lat = $request->get('lat'))
                throw new \Exception('missing lat');

            # check if longitude is being provided by consumer
            if(!$lng = $request->get('lng'))
                throw new \Exception('missing lng');

            # check if pokemon number is being provided by consumer
            if(!$number = $request->get('number'))
                throw new \Exception('missing number');

            # check if it's elligible for placement.
            if($this->pokemonService->isValid($number))
                throw new \Exception('you cant add this pokemon');

            $uuid = $request->get('uuid');

            # if received uuid, find the marker on the database
            if($uuid) {

                # find marker by identifier
                $marker = $this->markerService->findByUuid($uuid);

                # if marker wasnt found
                if(!$marker)
                    throw new \Exception('invalid uuid');
            }
            else {

                # if no uuid was received
                $marker = new Marker();
                $marker->uuid = Uuid::uuid4();
            }

            # populate the marker object
            $marker->lat = $lat;
            $marker->lng = $lng;
            $marker->number = $number;
            $marker->ip = $request->ip();
            $marker->user_id = $user->id;

            # save it on the database
            $marker->save();

            # if it's a insert, register first sight.
            if(!$uuid)
                $this->markerService->registerSight($user, $marker);

            # invalidate storage cache
            $this->cacheService->set('pkm.storage', null);

            # create response for marker
            $response = $this->markerService->response($marker);

            # if this is is an api request, generate the response without the encrypted location
            if($api) {

                # create response for marker
                $response = $this->markerService->response($marker, false);

                # log response
                $this->loggerService->logResponse($log, $response);
            }

            return response()->json( $response );
        }
        catch(\Exception $e) {;

            # create error response
            $response = [
                'error' => $e->getMessage()
            ];

            # log error response
            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
    }

    /**
     * Retrieve all markers
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markers(Request $request)
    {
        $log = null;

        try {

            # get auth data
            list($user, $log, $api) = $this->authService->fetchAuthDataFromRequest($request, true);

            $response = $this->markerService->all($user, $api);

            # log response
            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, 'too long...success');

            # gzip response
            ob_start('ob_gzhandler');

            return response()->json($response);
        }
        catch(\Exception $e) {

            # create error response
            $response = [
                'error' => $e->getMessage()
            ];

            # log response on error
            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }

    }

    /**
     * Retrieve user data when accessing the index page.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function start(Request $request)
    {
        # get location by ip
        $latLng = $this->networkingService->fetchLatLngByIp($request->ip());

        # get pokeon for selection
        $pokemon = $this->pokemonService->getForSelection();

        # retrieve latest added markers
        $latest = $this->markerService->latest();

        foreach($latest as $k => $row)
            $latest->offsetSet($k, $this->markerService->response($row));

        $token = null;
        $locations = [];

        # since we have no token on this call, try to find user on session.
        if($user = $request->session()->get('user')) {

            # if user id was found, load object
            if($user = User::find($user)) {

                # generate token for this user, so it can be used on next requests
                $token = $this->authService->jwt($user->id);

                # get user saved locations
                $locations = $this->locationService->findByUser($user);
            }
        }

        $result = [
            'pokemons' => $pokemon,
            'latest' => $latest,
            'token' => $token,
            'focus' => $latLng,
            'locations' => $locations
        ];

        return response()->json($result);
    }

    /**
     * Remove marker
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Request $request)
    {
        $log = null;

        try {

            if($this->networkingService->isIpBlocked($request->ip()))
                throw new BlockedIpAddressException();

            # get data from request
            list($user, $log) = $this->authService->fetchAuthDataFromRequest($request);

            # if user is not valid
            if(!$user)
                throw new \Exception('invalid user');

            # try to get uuid
            $uuid = $request->get('uuid');

            # get marker by uuid
            $marker = Marker::where('uuid', $uuid)->first();

            # if invalid
            if(!$marker)
                throw new \Exception('invalid marker');

            # delete marker
            $marker->delete();

            # invalidate storage cache
            $this->cacheService->forget('pkm.storage');

            # generate response
            $response = [
                'result' => true
            ];

            # log response
            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
        catch(\Exception $e) {

            # generate error response
            $response = [
                'error' => $e->getMessage()
            ];

            # if logging is active, log error
            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
    }

    /**
     * Report a marker
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function report(Request $request)
    {
        $log = null;

        try {

            if($this->networkingService->isIpBlocked($request->ip()))
                throw new BlockedIpAddressException();

            list($user, $log) = $this->authService->fetchAuthDataFromRequest($request);

            # get uuid from request
            $uuid = $request->get('uuid');

            # try to find marker
            $marker = Marker::where('uuid', $uuid)->first();

            # if marker is invalid
            if(!$marker)
                throw new \Exception('marker not found');

            # report marker
            $this->markerService->registerReport($user, $marker);

            # invalidate pokemon storage cache
            $this->cacheService->forget('pkm.storage');
            # @todo invalidate user.id.reports cache

            $response = [
                'result' => true
            ];

            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
        catch(\Exception $e) {

            $response = [
                'error' => $e->getMessage()
            ];

            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
    }

    /**
     * Register sight for marker
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sight(Request $request)
    {
        $log = null;

        try {

            if($this->networkingService->isIpBlocked($request->ip()))
                throw new BlockedIpAddressException();

            # get auth data
            list($user, $log) = $this->authService->fetchAuthDataFromRequest($request);

            # try to get uuid
            $uuid = $request->get('uuid');

            # retrieve marker
            $marker = Marker::where('uuid', $uuid)->first();

            # if invalid
            if(!$marker)
                throw new \Exception('marker not found');

            # register sight
            $this->markerService->registerSight($user, $marker);

            # invalidate storage cache
            $this->cacheService->forget('pkm.storage');

            # generate response
            $response = [
                'result' => true
            ];

            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
        catch(\Exception $e) {

            $response = [
                'error' => $e->getMessage()
            ];

            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Exception
     */
    public function auth(Request $request) {

        $log = null;

        try {

            # validating parameter "network"
            if (!$network = $request->get('network'))
                throw new \Exception('network is missing');

            # validating parameter "id"
            if (!$social_id = $request->get('id'))
                throw new \Exception('id is missing');

            # validating parameter "email"
            if (!$email = $request->get('email'))
                throw new \Exception('email is missing');

            # validating parameter "name"
            if (!$name = $request->get('name'))
                throw new \Exception('name is missing');

            # validating parameter "accessToken"
            if (!$accessToken = $request->get('accessToken'))
                throw new \Exception('accessToken is missing');

            # check if user id exists on session
            if ($user = $request->session()->get('user')) {

                # try ro find user on database
                if (!$user = User::find($user)) {

                    $request->session()->put('user', null);
                    $user = null;
                }
            }

            # if user wasnt found on session
            if (!$user) {

                # if registering network is facebook
                if ($network === 'facebook') {

                    $url = 'https://graph.facebook.com/' . $social_id . '?access_token=' . $accessToken;

                    # query facebook graph api to check for accessToken identity
                    $client = new \GuzzleHttp\Client();
                    $response = $client->request('GET', $url);

                    # verify if response is valid
                    $response = $response->getBody();

                    if (!strstr($response, $social_id))
                        throw new \Exception('invalid facebook id');
                }

                # @todo validate telegram
                # @todo validate google+

                # try to find user by network
                $user = $this->userService->findByNetwork($network, $social_id);

                # if user wasn't found, create one.
                if (!$user) {

                    # create user object
                    $user = new User();

                    # fill object with data provided by parameters
                    $user->name = $name;
                    $user->email = $email;
                    $user->social_id = $social_id;
                    $user->network = $network;

                    # send to database
                    $user->save();
                }


                # set user session
                $request->session()->put('user', $user->id);
            }

            # create json token
            $token = $this->authService->jwt($user->id);

            return response()->json([
                'token' => $token
            ]);

        }
        catch(\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Retrieve all locations registered by user
     * @return \Illuminate\Http\JsonResponse
     */
    public function locations(Request $request)
    {
        $log = null;

        try {

            if($this->networkingService->isIpBlocked($request->ip()))
                throw new BlockedIpAddressException();

            list($user, $log) = $this->authService->fetchAuthDataFromRequest($request);

            $locations = $this->locationService->findByUser($user);

            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $locations);

            return response()->json($locations);
        }
        catch(\Exception $e) {

            $response = [
                'error' => $e->getMessage()
            ];

            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $locations);

            return response()->json($response);
        }
    }

    /**
     * Add a new user location
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function location(Request $request)
    {
        $log = null;

        try {

            if($this->networkingService->isIpBlocked($request->ip()))
                throw new BlockedIpAddressException();

            list($user, $log) = $this->authService->fetchAuthDataFromRequest($request);

            # validating parameter "lat"
            if(!$lat = $request->get('lat'))
                throw new \Exception('lat is missing');

            # validating parameter "lng"
            if(!$lng = $request->get('lng'))
                throw new \Exception('lng is missing');

            # validating parameter "name"
            if(!$name = $request->get('name'))
                throw new \Exception('name is missing');

            # create location object
            $location = new Location();

            # fill object
            $location->user_id = $user->id;
            $location->lat = $lat;
            $location->lng = $lng;
            $location->name = $name;
            $location->uuid = Uuid::uuid4();

            # send to database
            $location->save();

            # @todo invalidate cache user.id.locations

            $response = [
                'lat' => $location->lat,
                'lng' => $location->lng,
                'name' => $location->name,
                'uuid' => $location->uuid,
            ];

            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
        catch(\Exception $e) {

            $response = [
                'error' => $e->getMessage()
            ];

            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
    }

    /**
     * Remove user location
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeLocation(Request $request)
    {
        $log = null;

        try {

            if($this->networkingService->isIpBlocked($request->ip()))
                throw new BlockedIpAddressException();

            list($user, $log) = $this->authService->fetchAuthDataFromRequest($request);

            # validate parameter uuid
            if(!$uuid = $request->get('uuid'))
                throw new \Exception('uuid is missing');

            # retrieve location from db
            $location = Location::where('uuid', $uuid)->first();

            # if location was not found
            if(!$location)
                throw new \Exception('location not found');

            # if location was not registered by this user
            if($location->user_id != $user->id)
                throw new \Exception('you cant perform this action');

            # delete
            $location->delete();

            # @todo invalidate cache user.id.location

            $response = [
                'result' => true
            ];

            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
        catch(\Exception $e) {

            $response = [
                'error' => $e->getMessage()
            ];

            if($log instanceof ApiLog)
                $this->loggerService->logResponse($log, $response);

            return response()->json($response);
        }
    }
}