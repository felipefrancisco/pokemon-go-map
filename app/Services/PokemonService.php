<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/21/2016
 * Time: 12:54 AM
 */

namespace App\Services;
use App\Pokemon;

/**
 * Class PokemonService
 * @package App\Services
 */
class PokemonService
{
    /**
     * @var array
     */
    protected static $legendaries = [
        150, # Mewtwo
        151, # Mew
        146, # Articuno
        145, # Moltres
        144  # Zapdos
    ];

    /**
     * @var BucketService
     */
    protected $bucketService;

    /**
     * PokemonService constructor.
     * @param BucketService $bucketService
     */
    public function __construct(BucketService $bucketService)
    {
        $this->bucketService = $bucketService;
    }

    /**
     * @param $number
     * @return bool
     */
    public function isLegendary($number) {

        return in_array($number, $this->legendaries());
    }

    /**
     * @param $number
     * @return bool
     */
    public function isValid($number) {

        return $this->isNumberValid($number) && $this->isLegendary($number);
    }

    /**
     * @param $number
     * @return bool
     */
    public function isNumberValid($number) {

        return ($number <= 151);
    }

    /**
     * @return array
     */
    public function legendaries() {

        return self::$legendaries;
    }

    /**
     * @return mixed
     */
    public function get() {

        # find all elligbile pokemon
        return Pokemon::whereNotIn('number', $this->legendaries())->get();
    }

    /**
     * @return mixed
     */
    public function getForSelection() {

        $pokemon = \DB::table('pokemons')->whereNotIn('number', $this->legendaries())->select(['name','number'])->get();

        foreach($pokemon as &$row) {

            $row->src = $this->bucketService->bucket() . '/pokemon/'. $row->number .'.png';
        }

        return $pokemon;
    }
}