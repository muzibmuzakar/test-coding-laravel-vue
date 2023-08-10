<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
                'id' => $this->coa->id,
                'code' => $this->coa->code,
                'name' => $this->coa->name,
                'category' => [
                    'id' => $this->coa->category->id,
                    'name' => $this->coa->category->name,
                ],
            ],
            'desc' => $this->desc,
            'debit' => $this->debit,
            'credit' => $this->credit,
            'type' => $this->category_type
        ];
    }
}
