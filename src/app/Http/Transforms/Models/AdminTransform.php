<?php

namespace YFDev\System\App\Http\Transforms\Models;

use HuangChun\TransformApi\Resources;
use HuangChun\TransformApi\Transform;

class AdminTransform extends Transform
{
    public function default(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
        ];
    }

    public function __adminList(Resources $resource)
    {
        return [
            'id' => $resource->id,
            'account' => $resource->account,
            'name' => $resource->name,
            'email' => $resource->email,
        ];
    }

    public function __adminDetail(Resources $resource)
    {
        return [
            'id' => $resource->id,
            'account' => $resource->account,
            'name' => $resource->name,
            'email' => $resource->email,
            'createdAt' => $resource->created_at,
            'updatedAt' => $resource->updated_at,
            'roles' => $this->whenRelationRegion($resource),
        ];
    }

    public function __name(Resources $resource)
    {
        return $resource->name;
    }

    /**
     * @param  $key
     */
    protected function whenRelationRegion(Resources $resource): mixed
    {
        return $this->when(
            $resource->get()->relationLoaded('roles'),
            fn () => RoleTransform::quote(['roles' => $resource->roles])
        );
    }
}
