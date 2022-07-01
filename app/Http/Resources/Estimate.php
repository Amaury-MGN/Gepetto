<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Estimate extends JsonResource
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
            'id'                    => $this->id,
            'user_id'               => $this->user_id,
            'estimateNumber'        => $this->estimateNumber,
            'estimateName'          => $this->estimateName,
            'estimateContents'      => $this->estimateContents,
            'estimateUserFile'      => $this->estimateUserFile,
            'estimateItemNumber'    => $this->estimateItemNumber,
            'paymentValidation'     => $this->paymentValidation,


            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
