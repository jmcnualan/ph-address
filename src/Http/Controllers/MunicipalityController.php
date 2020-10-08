<?php

namespace Dmn\PhAddress\Http\Controllers;

use Dmn\PhAddress\Http\Controllers\Controller;
use Dmn\PhAddress\Http\Resources\Municipality as ResourcesMunicipality;
use Dmn\PhAddress\Models\Municipality;
use Illuminate\Http\Resources\Json\JsonResource;

class MunicipalityController extends Controller
{
    /**
     * List
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $q = $this->getQuery();

        $regions = Municipality::name($q)
            ->paginate($this->getPerPage());

        return ResourcesMunicipality::collection($regions);
    }

    /**
     * Barangays
     *
     * @param string $municipalityCode
     *
     * @return JsonResource
     */
    public function barangay(string $municipalityCode): JsonResource
    {
        $q = $this->getQuery();

        $barangays = Municipality::findOrFail($municipalityCode)
            ->barangays()
            ->name($q)
            ->paginate($this->getPerPage());

        return ResourcesMunicipality::collection($barangays);
    }
}
