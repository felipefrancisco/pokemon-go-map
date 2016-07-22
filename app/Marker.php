<?php

namespace App;

use App\Services\BucketService;
use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'markers';

    protected static $unguarded = true;

    protected $dates = [];

    public function formattedDate() {

        return ( new \DateTime($this->created_at) )->format('M d, H:i:s');
    }

    public function formattedNumber() {

        return str_pad($this->number, 3, '0', STR_PAD_LEFT);
    }

    public function url() {

        $bucketService = app(BucketService::class);

        return $bucketService->bucket() . '/pokemon/'. $this->number .'.png';
    }

    public function location() {

        return [
            'lat' => (float)$this->lat,
            'lng' => (float)$this->lng
        ];
    }
}
