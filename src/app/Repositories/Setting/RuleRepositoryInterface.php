<?php

namespace YFDev\System\App\Repositories\Setting;

use YFDev\System\App\Repositories\BaseRepositoryInterface;

interface RuleRepositoryInterface extends BaseRepositoryInterface
{
    public function getRuleWithMethods($ruleId = null);
}
