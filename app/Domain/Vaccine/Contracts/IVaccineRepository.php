<?php

namespace App\Domain\Vaccine\Contracts;
use App\Domain\Disease\Models\Disease;
use App\Domain\Vaccine\Models\Vaccine;

interface IVaccineRepository
{
    public function createVaccine(Disease $disease) : Vaccine;
}