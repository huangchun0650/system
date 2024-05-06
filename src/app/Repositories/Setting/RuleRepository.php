<?php

namespace YFDev\System\App\Repositories\Setting;

use YFDev\System\App\Models\Rule;
use YFDev\System\App\Repositories\BaseRepository;

class RuleRepository extends BaseRepository implements RuleRepositoryInterface
{
    protected $model = Rule::class;

    public function getRuleWithMethods($ruleId = null)
    {
        $role = $this->with('methods')
            ->when(filled($ruleId), fn ($query) => $query->where('id', $ruleId));

        return $role;
    }
}
