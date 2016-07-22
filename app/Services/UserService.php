<?php

namespace App\Services;

use App\Services\Service;
use App\Repositories\UserRepository;
use App\User;

/**
 * Class UserService
 * @package App\Services
 * @author Felipe Francisco <felipefrancisco@outlook.com>
 */
class UserService extends Service
{
    /**
     * @param $id
     * @return User
     * @author Felipe Francisco <felipefrancisco@outlook.com>
     */
    public function findOrCreateByTelegramId($id) {

        # find user by telegram id
        $user = User::where('network', User::NETWORK_TELEGRAM)
                    ->where('social_id', $id)
                    ->first();

        # if user was found, return.
        if($user)
            return $user;

        # if not, create a new user
        return $this->createByTelegramId($id);
    }

    /**
     * @param $id
     * @return User
     * @author Felipe Francisco <felipefrancisco@outlook.com>
     */
    public function createByTelegramId($id) {

        # new instance of user object
        $user =  new User();

        # fill user object
        $user->social_id = $id;
        $user->network = User::NETWORK_TELEGRAM;

        # send user to database
        $user->save();

        return $user;
    }

    /**
     * @param $network
     * @param $social_id
     * @return mixed
     */
    public function findByNetwork($network, $social_id) {

        # find by social media network
        return User::where('social_id', $social_id)
                   ->where('network', $network)->get()->first();
    }
}
