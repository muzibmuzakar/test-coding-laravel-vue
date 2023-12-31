<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'coa' => [
                'id' => $this->coa_id,
                'code' => $this->coa_code,
                'name' => $this->coa_name,
                'category' => [
                    'id' => $this->category_id,
                    'name' => $this->category_name,
                    'type' => $this->category_type,
                ],
            ],
            'desc' => $this->desc,
            'debit' => $this->debit,
            'credit' => $this->credit,
        ];
    }
}
