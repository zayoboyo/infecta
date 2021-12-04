<?php

namespace App\Domain\Disease\Controllers;

use App\Domain\Disease\Models\Disease;
use App\Http\Requests\DiseaseRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Disease\Contracts\IDiseaseRepository;
use App\Domain\Disease\Contracts\IDiseaseService;
use App\Domain\Disease\Resources\DiseaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

/** Controller that handles incoming Disease http requests. */
class DiseaseController extends Controller
{
    private IDiseaseRepository $diseaseRepository;
    private IDiseaseService $diseaseService;

    function __construct(IDiseaseRepository $diseaseRepository, IDiseaseService $diseaseService)
    {
        $this->diseaseRepository = $diseaseRepository;
        $this->diseaseService = $diseaseService;
    }

    /**
     * Filters the diseases based on the get parameters.
     * @param Request $request
     * @return JsonResource
     */
    public function index(DiseaseRequest $request) : ?JsonResource
    {
        $safeInput = $request->safe()->only(['has_vaccine', 'solved', 'rna']);
        $diseases = $this->diseaseRepository->findDiseases($safeInput);

        return DiseaseResource::collection($diseases);
    }

    /**
     * Based on a chance, it either creates a disease
     * with random name and random RNA or doesn't.
     *
     * @return DiseaseResource|null
     */
    public function store() : ?DiseaseResource
    {
        if($this->diseaseService->shouldCreateDisease())
        {
            $name = $this->diseaseService->randomDiseaseName();
            $RNA = $this->diseaseService->randomRNA();

            $newDisease = $this->diseaseRepository->createDisease($name, $RNA);

            return new DiseaseResource($newDisease);
        }

        return null;
    }

    /**
     * Updates the disease based on ID.
     *
     * @param int $id
     * @param Request $request
     * @return Disease|null
     */
    public function update(int $id, DiseaseRequest $request) : ?Disease
    {
        $disease = $this->diseaseRepository->findDisease($id);

        if($disease)
        {
            $disease->forceFill($request->safe()->all());
            $disease = $this->diseaseRepository->update($id, $disease);
        }

        return $disease;
    }
}
