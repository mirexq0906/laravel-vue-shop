<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    protected $error;
    protected $statusCode;

    public function __construct(string $error = '', int $statusCode = 400)
    {
        $this->error = $error;
        $this->statusCode = $statusCode;
    }

    public function toArray(Request $request): array
    {
        return [
            'message' => $this->error
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this->statusCode);
    }
}
