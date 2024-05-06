<?php

namespace YFDev\System\App\Repositories\Setting;

use YFDev\System\App\Models\Method;
use YFDev\System\App\Repositories\BaseRepository;

class MethodRepository extends BaseRepository implements MethodRepositoryInterface
{
    protected $model = Method::class;
}
