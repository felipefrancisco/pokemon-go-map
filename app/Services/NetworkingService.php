<?php
/**
 * Created by PhpStorm.
 * User: Felipe Francisco
 * Date: 07/21/2016
 * Time: 12:24 AM
 */

namespace App\Services;

use App\IpCountry;
use App\IpLock;
use Geocoder\Model\Country;

class NetworkingService
{
    public function isIpBlocked($ip) {

        # verify if ip was marked as blocked
        return (bool)(IpLock::where('ip', $ip)->count());
    }

    public function fetchLatLngByIp($ip = null, $deep_detect = true) {

        # try to find ip location on local database
        if($ipCountry = IpCountry::where('ip', $ip)->first()) {

            # ok, ip location was found, but does it have the output?
            # this is here 'cause in the first version the code wasn't storing
            # the complete output, this will force the code to store the ouput
            # even if the ip was detected before.
            if($ipCountry->output) {

                # if ip location was detected but lat or lng are null, return the lat and lng for the country
                if(!$ipCountry->lat || !$ipCountry->lng) {

                    # get the country attached to the ip
                    $country = $ipCountry->country();

                    # if country exists
                    if($country) {

                        # and has lat and lng
                        if($country->lng && $country->lng) {

                            # then return country's location
                            return [
                                'lat' => (float)$country->lat,
                                'lng' => (float)$country->lng
                            ];
                        }
                    }
                }

                # if lat and lng are ok, return the EXACT location
                return [
                    'lat' => (float)$ipCountry->lat,
                    'lng' => (float)$ipCountry->lng
                ];
            }
        }

        # output defaults to null
        $output = null;

        # filter ip received
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {

            # get ip from request
            $ip = request()->ip();

            # if deep detect is active, try to find ip from other sources.
            if ($deep_detect) {

                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }

        # validate the ip address
        if (filter_var($ip, FILTER_VALIDATE_IP)) {

            # get data from geoplygin
            $response = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

            # check if countrycode received is valid. If so, set the output.
            if (@strlen(trim($response->geoplugin_countryCode)) == 2)
                $output = $response;
        }

        # if output is ok
        if($output) {

            # check if ipCountry wasn't detected already
            if(!$ipCountry) {

                # if not, get the country's data
                $country = Country::where('country_code',$output->geoplugin_countryCode)->first();

                # create the ip location object
                $ipCountry = new IpCountry();

                # if this is a insert, we set the ip and country. On further updates this won't be necessary.
                $ipCountry->ip = $ip;
                $ipCountry->country_code = $country->country_code;
            }

            # fill ip location object
            $ipCountry->lng = $output->geoplugin_longitude;
            $ipCountry->lat = $output->geoplugin_latitude;

            # store the full output for quick-access on revisit
            $ipCountry->output = json_encode($output);

            # send it to the database
            $ipCountry->save();

            # if lat and lng are not ok
            if(!$ipCountry->lat || !$ipCountry->lng) {

                # return country's location
                return [
                    'lat' => (float)$country->lat,
                    'lng' => (float)$country->lng
                ];
            }

            # if everything is ok with the lat and lng, return the EXACT location
            return [
                'lat' => (float)$ipCountry->lat,
                'lng' => (float)$ipCountry->lng
            ];
        }

        return null;
    }
}