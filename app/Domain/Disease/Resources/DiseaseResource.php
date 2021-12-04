<?php

namespace App\Domain\Disease\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiseaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'disease_id'    =>      $this->disease_id,
            'name'          =>      $this->name,
            'rna'           =>      $this->rna,
            'difficulty'    =>      $this->difficulty,
            'solved'        =>      boolval($this->solved),
            'has_vaccine'   =>      boolval($this->has_vaccine),
        ];
    }
}
