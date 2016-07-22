<?php

namespace App\Services;

use App\Services\Service;
use App\Repositories\UserRepository;

class MapService extends Service
{
    public function getMarkers() {


    }

    public function create($data) {

        return $this->userRepository->create($data);
    }
}
