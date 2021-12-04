<?php

namespace App\Domain\Disease\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Disease\Collections\DiseaseCollection;
use App\Domain\Vaccine\Models\Vaccine;

/**
 * Every disease has unique RNA which needs to be solved before mRNA vaccine can be developed.
 * If RNA of the virus is solved, player will have the ability to make new mRNA vaccine.
 *
 * @package App\Domain\Disease\Models
 */
class Disease extends Model
{
    use HasFactory;

    protected $table = "disease";
    protected $primaryKey = "disease_id";

    public function vaccine() : Vaccine
    {
        return $this->hasOne(Vaccine::class, 'vaccine_id', 'vaccine_id');
    }
}
