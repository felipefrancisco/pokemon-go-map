<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/21/2016
 * Time: 1:03 AM
 */

namespace App\Services;


use App\ApiKey;
use App\User;
use Firebase\JWT\JWT;

/**
 * Class AuthService
 * @package App\Services
 * @author Felipe Francisco <felipefrancisco@outlook.com>
 */
class AuthService
{
    /**
     * @var UserService
     * @author Felipe Francisco
     */
    protected $userService;

    /**
     * @var LoggerService
     */
    protected $loggerService;

    /**
     * @var SessionService
     */
    protected $sessionService;

    /**
     * @var string
     */
    protected static $key = '';

    /**
     * AuthService constructor.
     * @param UserService $userService
     * @param LoggerService $loggerService
     * @param SessionService $sessionService
     * @author Felipe Francisco
     */
    public function __construct(UserService $userService, LoggerService $loggerService, SessionService $sessionService)
    {
        $this->userService = $userService;
        $this->loggerService = $loggerService;
        $this->sessionService = $sessionService;

        if(!self::$key)
            self::$key = getenv('JWT_KEY');
    }


    /**
     * @param $key
     * @return mixed
     * @author Felipe Francisco <felipefrancisco@outlook.com>
     */
    public function isValidKey($key) {

        return ApiKey::where('key', $key)->first();
    }

    /**
     * @param $request
     * @param bool $skipTokenValidation
     * @return array
     * @throws \Exception
     * @author Felipe Francisco <felipefrancisco@outlook.com>
     */
    public function fetchAuthDataFromRequest($request, $skipTokenValidation = false) {

        $log = null;

        # if this is a API consumer request, get the user from the api_key.
        if($key = $request->get('api_key')) {

            # check if api key is valid
            $apiKey = $this->isValidKey($key);

            # get linked user
            $user = $apiKey->user();

            # if the api call is comming from telegram, replace the user from apiKey with the actual user perfoming the action
            if($telegram_id = $request->get('telegram_id'))
                $user = $this->userService->findOrCreateByTelegramId($telegram_id);

            # get the api log instance.
            $log = $this->loggerService->logRequest($request, $apiKey);

            # set api detection to true
            $api = true;
        }
        else {

            try {

                $token = $request->get('token');

                # if no api call was detected, validates the token
                $user_id = $this->validateToken($token);

                # find user associated with token
                $user = User::findOrFail($user_id);
            }
            catch(\Exception $e) {

                # if user is found on session, go ahead.
                if(!$user = $this->sessionService->get('user')) {

                    # if validation is active, throw the exception. If not, just continue.
                    if(!$skipTokenValidation)
                        throw $e;
                }
            }
            finally {

                # set api detection to false
                $api = false;
            }

        }

        # return user object, log object and api identifier
        return [$user, $log, $api];
    }

    /**
     * @param $token
     * @return int
     * @throws \Exception
     * @author Felipe Francisco <felipefrancisco@outlook.com>
     */
    public function validateToken($token) {

        # check token existence
        if(!$token)
            throw new \Exception('token required');

        # try to decode token
        $token = JWT::decode($token, self::$key, ['HS256']);

        # if token is invalid
        if(!$token)
            throw new \Exception('invalid token');

        # return user ide
        return $token->user;
    }

    /**
     * @param $id
     * @return string
     */
    public function jwt($id) {

        return JWT::encode([
            'user' => $id
        ], self::$key);
    }
}