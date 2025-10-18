<?php

namespace Modules\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;

class AuthTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'access_token' => $this->resource->token,
            'token_type'   => 'Bearer',
            'expires_in'   => $this->resource->expiresAt->diffInSeconds(now()),
        ];
    }
}
