<?php

namespace YFDev\System\App\Repositories\Notification;

use YFDev\System\App\Models\Notification;
use YFDev\System\App\Repositories\BaseRepository;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    protected $model = Notification::class;
}
