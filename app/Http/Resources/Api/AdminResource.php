<?php

namespace App\Http\Resources\Api;

use App\Enums\AdminStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        switch ($this->status) {
            case -1:
                $this->status = '已删除';
                break;
            case 0:
                $this->status = '正常';
                break;
            case 1:
                $this->status = '冻结';
                break;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => AdminStatus::getStatusName($this->status),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
