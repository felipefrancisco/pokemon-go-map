<?php

namespace App;


use Illuminate\Database\Eloquent\Model;


class ApiKey extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'api_key';

    protected static $unguarded = true;

    public $timestamps = false;

    public function user() {

        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }
}
