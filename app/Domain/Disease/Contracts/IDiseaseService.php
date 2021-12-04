<?php

namespace App\Domain\Disease\Contracts;
use App\Domain\Disease\Models\Disease;
use App\Domain\Disease\Collections\DiseaseCollection;

interface IDiseaseService
{
    function randomDiseaseName() : string;
    function randomRNA() : string;
    function shouldCreateDisease() : bool;
}
