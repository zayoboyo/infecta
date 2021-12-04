<?php
namespace App\Domain\Vaccine\Observers;
use App\Domain\Vaccine\Models\Vaccine;
use App\Domain\Disease\Contracts\IDiseaseRepository;

class VaccineObserver
{
    private IDiseaseRepository $diseaseRepository;

    function __construct(IDiseaseRepository $diseaseRepository)
    {
        $this->diseaseRepository = $diseaseRepository;
    }

    function created(Vaccine $vaccine)
    {
        // After vaccine has been created, we can mark the disease
        // as vaccine-ready, since it is now curable by vaccine.
        $vaccine->disease->has_vaccine = true;

        // Persist the changes in the database via repository
        $this->diseaseRepository->update($vaccine->disease->disease_id, $vaccine->disease);
    }
}
