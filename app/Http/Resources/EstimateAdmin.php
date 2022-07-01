<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EstimateAdmin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'estimate_id'               => $this->estimate_id,
            'estimateAdminContents'     => $this->estimateAdminContents,
            'estimateAdminFile'         => $this->estimateAdminFile,
            'estimateAdminFileName'     => $this->estimateAdminFileName,
            'estimateAdminPrice'        => $this->estimateAdminPrice,


            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
