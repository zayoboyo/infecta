<?php

namespace App\Domain\Vaccine\Controllers;

use App\Domain\Vaccine\Models\Vaccine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Vaccine\Contracts\IVaccineRepository;
use App\Domain\Disease\Contracts\IDiseaseRepository;

/**
 * Controller that handles Vaccine http requests.
 */
class VaccineController extends Controller
{
    private IDiseaseRepository $diseaseRepository;
    private IVaccineRepository $vaccineRepository;

    function __construct(IDiseaseRepository $diseaseRepository, IVaccineRepository $vaccineRepository)
    {
        $this->diseaseRepository = $diseaseRepository;
        $this->vaccineRepository = $vaccineRepository;
    }

    /**
     * Creates new vaccine for the specified disease.
     * The RNA of the disease needs to be solved and there cannot
     * be any vaccine tied to the disease.
     *
     * @param Request $request
     * @return Vaccine|null
     */
    public function store(Request $request) : ?Vaccine
    {
        $disease = $this->diseaseRepository->findDisease($request->disease_id);
        $vaccine = null;

        if($disease && $disease->solved && !$disease->has_vaccine)
        {
            $vaccine = $this->vaccineRepository->createVaccine($disease);
        }

        return $vaccine;
    }
}
