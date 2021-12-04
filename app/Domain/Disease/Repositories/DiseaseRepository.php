<?php

namespace App\Domain\Disease\Repositories;
use App\Domain\Disease\Contracts\IDiseaseRepository;
use App\Domain\Disease\Models\Disease;
use App\Domain\Disease\Collections\DiseaseCollection;

class DiseaseRepository implements IDiseaseRepository
{
    /**
     * Creates new disease with specified name and RNA.
     * The difficulty is configurable via environment config file.
     *
     * Returns newly created disease.
     *
     * @param string $name
     * @param string $RNA
     * @return Disease
     */
    public function createDisease(string $name, string $RNA) : Disease
    {
        $minDifficulty = config('infecta.minimum_difficulty');
        $maxDifficulty = config('infecta.maximum_difficulty');

        $disease = new Disease();
        $disease->name = $name;
        $disease->rna = $RNA;
        $disease->difficulty = rand($minDifficulty, $maxDifficulty);
        $disease->solved = false;
        $disease->has_vaccine = false;
        $disease->save();

        return $disease;
    }

    /**
     * Returns disease with specified ID or null if the disease
     * is not present in the database.
     * @param int $id
     * @return Disease|null
     */
    public function findDisease(int $id) : ?Disease
    {
        return Disease::find($id);
    }

    /**
     * Finds multiple diseases based on parameters specified in the array.
     *
     * Returns DiseaseCollection or null if there are no diseases to output.
     * @param array $parameters
     * @param string $orderBy
     * @param string $order
     * @return DiseaseCollection|null
     */
    public function findDiseases(array $parameters, string $orderBy = 'has_vaccine', string $order = 'ASC') : ?DiseaseCollection
    {
        $diseases = Disease::where($parameters)->orderBy($orderBy, $order)->get();

        return new DiseaseCollection($diseases);
    }

    /**
     * Returns current number of diseases plaguing the world.
     * @return int
     */
    public function count() : int
    {
        return Disease::all()->count();
    }

    /**
     * Updates the disease model based on the ID.
     *
     * @param int $id
     * @param Disease $updatedDisease
     * @return Disease|null
     */
    public function update(int $id, Disease $updatedDisease) : ?Disease
    {
        $disease = Disease::find($id);

        if($disease)
        {
            $disease->solved = $updatedDisease->solved;
            $disease->has_vaccine = $updatedDisease->has_vaccine;
            $disease->save();
        }

        return $disease;
    }
}
