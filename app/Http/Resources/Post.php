<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
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
            'id'             => $this->id,
            'webPage'        => $this->webPage,
            'firstPost'      => $this->firstPost,
            'secondPost'     => $this->secondPost,
            'thirdPost'      => $this->thirdPost,
            'fourthPost'     => $this->fourthPost,

            'created_at'     => $this->created_at->format('d/m/Y'),
            'updated_at'     => $this->updated_at->format('d/m/Y'),
        ];
    }
}
