<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'identify' => $this->uuid,
            'name' => $this->name,
            'category' => new CategoryResource($this->category),
            'url' => $this->url,
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
            'image' => url("storage/{$this->image}"),
        ];
    }
}
