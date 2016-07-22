<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/21/2016
 * Time: 12:24 AM
 */

namespace App\Services;

use App\Location;
use App\User;

class LocationService
{
    /**
     * @param User $user
     * @return mixed
     */
    public function findByUser(User $user)  {

        $locations = Location::where('user_id', $user->id)->select(['uuid', 'lat','lng','name'])->get();
        # @todo cache user.id.locations

        return $locations;
    }
}