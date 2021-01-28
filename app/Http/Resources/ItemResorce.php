<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResorce extends JsonResource
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
            'ID' => $this->ID,
            'Description' => $this->Description,
            'ItemLookupCode' => $this->ItemLookupCode,
            'Price' => $this->Price,
            'PriceA' => $this->PriceA,
            'PriceB' => $this->PriceB,
            'PriceC' => $this->PriceC,
            'Taxable' => $this->Taxable,
            'TaxDescription' => $this->tax ? $this->tax->Description: "No Aplica",
            'TaxPorcentage' => $this->tax ? $this->tax->Percentage/100+1 : 1,
            'Quantity' => $this->Quantity
        ];
    }
}
