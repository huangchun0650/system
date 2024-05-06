<?php

namespace YFDev\System\App\Http\Transforms\Models;

use HuangChun\TransformApi\Resources;
use HuangChun\TransformApi\Transform;

class RoleTransform extends Transform
{
    public function default(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
        ];
    }

    public function __roleOptions(Resources $resource)
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
        ];
    }

    public function __roleMenus(Resources $resource)
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'menus' => $this->getMenus($resource),
        ];
    }

    /**
     * @param  $key
     */
    protected function getMenus(Resources $resource): mixed
    {
        return $this->when(
            ! is_null($resource->menus),
            fn () => MenuTransform::quote(['menuRulesWithMethods' => $resource->menus])
        );
    }
}
