<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response=parent::toArray($request);
        $message=array_key_exists('message', $response) ? $response['message']:"Successful!";
        $data=array_key_exists("data", $response) ? $response["data"]:[];

        return [
            'success'=>true,
            'message'=>$message,
            'data'=>$data
        ];
    }
}
