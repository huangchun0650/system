<?php

namespace YFDev\System\App\Http\Transforms\Models;

use HuangChun\TransformApi\Resources;
use HuangChun\TransformApi\Transform;

class MethodTransform extends Transform
{
    public function default(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
        ];
    }
}
