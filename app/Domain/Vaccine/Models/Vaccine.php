<?php

namespace App\Domain\Vaccine\Models;

use App\Domain\Disease\Models\Disease;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Vaccines cure diseases. There can only be one mRNA Vaccine cures one disease.
 */
class Vaccine extends Model
{
    use HasFactory;

    protected $table = "vaccine";
    protected $primaryKey = "vaccine_id";

    public function disease()
    {
        return $this->belongsTo(Disease::class, 'disease_id', 'disease_id');
    }
}
