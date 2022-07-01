<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'orderName'             => $this->orderName,
            'orderNumber'           => $this->orderNumber,
            'orderItems'            => $this->orderItems,
            'orderContents'         => $this->orderContents,
            'orderProgress'         => $this->orderProgress,
            'orderAdminFileName'    => $this->orderAdminFileName,
            'orderAdminFilePath'    => $this->orderAdminFilePath,
            'orderInvoice'          => $this->orderInvoice,
            'orderPrice'            => $this->orderPrice,


            // Eloquent: Relationships

            'created_at'    => $this->created_at->format('d/m/Y'),
            'updated_at'    => $this->updated_at->format('d/m/Y'),
        ];
    }
}
