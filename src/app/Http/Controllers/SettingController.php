<?php

namespace YFDev\System\App\Http\Controllers;

use YFDev\System\App\Http\Requests\Menu\UpdateRulesRequest;
use YFDev\System\App\Http\Requests\Setting\Rule\CreateRequest as RuleCreateRequest;
use YFDev\System\App\Http\Requests\Setting\Rule\ListRequest as RuleListRequest;
use YFDev\System\App\Http\Requests\Setting\Rule\UpdateRequest as RuleUpdateRequest;
use YFDev\System\App\Models\Menu;
use YFDev\System\App\Models\Rule;
use YFDev\System\App\Services\Menu\MenuService;
use YFDev\System\App\Services\Setting\MethodService;
use YFDev\System\App\Services\Setting\PermissionService;
use YFDev\System\App\Services\Setting\RuleService;

class SettingController extends BaseController
{
    protected $ruleService;

    protected $methodService;

    protected $permissionService;

    protected $menuService;

    public function __construct(
        RuleService $ruleService,
        MethodService $methodService,
        PermissionService $permissionService,
        MenuService $menuService
    ) {
        $this->ruleService = $ruleService;
        $this->methodService = $methodService;
        $this->permissionService = $permissionService;
        $this->menuService = $menuService;
    }

    public function createRule(RuleCreateRequest $request)
    {
        return $this->ruleService->store();
    }

    public function ruleList(RuleListRequest $request)
    {
        return $this->ruleService->list();
    }

    public function ruleDetail(Rule $rule)
    {
        return $this->ruleService->detail($rule);
    }

    public function updateRule(Rule $rule, RuleUpdateRequest $request)
    {
        return $this->ruleService->update($rule);
    }

    public function deleteRule(Rule $rule)
    {
        return $this->ruleService->destroy($rule);
    }

    public function menuRules()
    {
        return $this->menuService->menuRules();
    }

    public function updateMenuRules(Menu $menu, UpdateRulesRequest $request)
    {
        return $this->menuService->menuUpdateRules($menu);
    }

    public function methodOptions()
    {
        return $this->methodService->options();
    }

    public function permissionOptions()
    {
        return $this->permissionService->selfPermissions();
    }

    public function ruleOptions()
    {
        return $this->ruleService->options();
    }
}
