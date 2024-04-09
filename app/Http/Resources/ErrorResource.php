<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    static $wrap = "errors";
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response=parent::toArray($request);
        $message=array_key_exists("message", $response) ? $response["message"] :"Error";
        $data=array_key_exists("data", $response) ? $response["data"] :[];
        return [
            "success"=>false,
            "message"=>$message,
            "data"=>$data,
        ];
    }
}
