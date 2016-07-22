<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Database\Eloquent\SoftDeletes;

class IpCountry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ip_countries';

    protected static $unguarded = true;

    public function country() {

        return $this->hasOne(Country::class, 'country_code', 'country_code')->first();
    }
}
