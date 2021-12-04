<?php

namespace App\Domain\Disease\Contracts;
use App\Domain\Disease\Models\Disease;
use App\Domain\Disease\Collections\DiseaseCollection;

interface IDiseaseRepository
{
    public function createDisease(string $name, string $RNA) : Disease;
    public function findDisease(int $id) : ?Disease;
    public function findDiseases(array $ids, string $orderBy, string $order) : ?DiseaseCollection;
    public function count() : int;
    public function update(int $id, Disease $disease) : ?Disease;
}
