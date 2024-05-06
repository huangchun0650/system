<?php

namespace YFDev\System\App\Http\Transforms\Models;

use HuangChun\TransformApi\Resources;
use HuangChun\TransformApi\Transform;

class RuleTransform extends Transform
{
    public function default(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
        ];
    }

    public function __ruleList(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'methodName' => $this->whenRelationMethod($resource),
        ];
    }

    public function __ruleDetail(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'method' => $this->whenRelationMethod($resource),
            'permissions' => $this->whenRelationPermission($resource),
        ];
    }

    public function __ruleOptions(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
        ];
    }

    public function __permissions(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'methodId' => $resource->method_id,
            'name' => $resource->name,
            'permissions' => json_decode($resource->permissions),
        ];
    }

    public function __methods(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'methodName' => $this->whenRelationMethod($resource),
        ];
    }

    public function __methodAndPermissions(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'methodName' => $resource->methodName,
            'selected' => $resource->selected,
            'permissions' => $resource->permissions,
        ];
    }

    /**
     * whenRelationMethod
     */
    protected function whenRelationMethod(Resources $resource): mixed
    {
        return $this->when(
            $resource->get()->relationLoaded('methods'),
            fn () => MethodTransform::quote(['methods' => $resource->methods])['name']
        );
    }

    /**
     * whenRelationPermission
     */
    protected function whenRelationPermission(Resources $resource): mixed
    {
        return $this->when(
            ! $resource->get()->permissions()->isEmpty(),
            fn () => PermissionTransform::quote(['permissions' => $resource->get()->permissions()])
        );
    }
}
