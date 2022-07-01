<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImagesWebsite extends JsonResource
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
            'id'           => $this->id,
            'webPage'      => $this->webPage,
            'firstImage'   => $this->firstImage,
            'secondImage'  => $this->secondImage,
            'thirdImage'   => $this->thirdImage,
            'fourthImage'  => $this->fourthImage,
        ];
    }
}
