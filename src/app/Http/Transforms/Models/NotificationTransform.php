<?php

namespace YFDev\System\App\Http\Transforms\Models;

use HuangChun\TransformApi\Resources;
use HuangChun\TransformApi\Transform;

class NotificationTransform extends Transform
{
    public function default(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'event' => $resource->event,
            'isRead' => $resource->isRead,
        ];
    }

    public function __list(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'event' => $resource->event,
            'message' => $resource->message,
            'class' => $resource->model_type,
            'classId' => $resource->model_id,
            'isRead' => $resource->isRead,
            'at' => $resource->created_at->toDateTimeString(),
        ];
    }
}
