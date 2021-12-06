<?php
namespace App\Domain\Disease\Services;
use App\Domain\Disease\Contracts\IDiseaseRepository;
use App\Domain\Disease\Contracts\IDiseaseService;

class DiseaseService implements IDiseaseService
{
    private IDiseaseRepository $diseaseRepository;

    function __construct(IDiseaseRepository $diseaseRepository)
    {
        $this->diseaseRepository = $diseaseRepository;
    }
    /**
     * Generates random disease name.
     *
     * @return string
     */
    public function randomDiseaseName() : string
    {
        $characters = "BCDFGHIJKLMNPRSTVWXYZ";
        $randomNumber = rand(10, 999);

        $diseaseName = str_shuffle($characters);
        $diseaseName = $diseaseName[0] . "OVID-" . $randomNumber;

        return $diseaseName;
    }

    /**
     * Generates random 12 characters long RNA sequence based on the ACGU nucleotides.
     *
     * @return string
     */
    public function randomRNA() : string
    {
        $nucleotides = "ACGU";
        $RNA = "";

        for($i = 0; $i < 12; $i++)
        {
            $randomNucleotide = str_shuffle($nucleotides);
            $RNA .= $randomNucleotide[0];
        }

        return $RNA;
    }

    /**
     * Returns whether a new disease should be created based on a random chance.
     *
     * The disease spawn chance and maximum disease count
     * are configurable via environment config file.
     * @return bool
     */
    public function shouldCreateDisease() : bool
    {
        $diseaseSpawnChance = config('infecta.disease_spawn_chance');
        $maximumDiseases = config('infecta.maximum_diseases');
        $unsolvedDiseaseCount = $this->diseaseRepository->findDiseases(['solved' => false])->count();

        if($unsolvedDiseaseCount >= $maximumDiseases)
            return false;

        $chance = rand(0, 100);

        if($chance <= $diseaseSpawnChance)
            return true;
        else
            return false;
    }
}
