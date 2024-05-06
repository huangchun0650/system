<?php

namespace YFDev\System\App\Repositories\Admin;

use YFDev\System\App\Models\Admin;
use YFDev\System\App\Repositories\BaseRepository;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    protected $model = Admin::class;
}
