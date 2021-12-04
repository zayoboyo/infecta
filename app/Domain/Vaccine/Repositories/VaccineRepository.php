<?php

namespace App\Domain\Vaccine\Repositories;
use App\Domain\Disease\Models\Disease;
use Illuminate\Pipeline\Pipeline;
use App\Domain\Vaccine\Contracts\IVaccineRepository;
use App\Domain\Vaccine\Models\Vaccine;

class VaccineRepository implements IVaccineRepository
{
    /** Creates new vaccine based on the the Disease parameter.
     *
     * @param Disease $disease
     * @return Vaccine
     */
    public function createVaccine(Disease $disease) : Vaccine
    {
        $vaccine = new Vaccine();
        $vaccine->name = $disease->name . " Vaccine";
        $vaccine->disease_id = $disease->disease_id;
        $vaccine->save();

        return $vaccine;
    }
}
