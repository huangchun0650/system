<?php

namespace YFDev\System\App\Http\Transforms\Models;

use HuangChun\TransformApi\Resources;
use HuangChun\TransformApi\Transform;

class MenuTransform extends Transform
{
    public function default(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'sortOrder' => $resource->sort_order,
            'name' => $resource->name,
            'code' => $resource->code,
            'parentId' => $resource->parent_id,
            'children' => $this->getChildren($resource),
        ];
    }

    public function __options(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'code' => $resource->code,
            'parentId' => $resource->parent_id,
            'children' => $this->getOptionsChildren($resource),
            'rules' => $this->whenRelationRuleWithMethods($resource),
        ];
    }

    public function __menuWithRules(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'code' => $resource->code,
            'parentId' => $resource->parent_id,
            'children' => $this->getChildrenWithRules($resource),
            'rules' => $this->whenRelationRule($resource),
        ];
    }

    public function __menuWithPermissions(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'code' => $resource->code,
            'parentId' => $resource->parent_id,
            'children' => $this->getChildrenPermissions($resource),
            'permissions' => $this->whenRelationPermissions($resource),
        ];
    }

    public function __menuRulesWithMethods(Resources $resource): array
    {
        return [
            'id' => $resource->id,
            'sortOrder' => $resource->sort_order,
            'name' => $resource->name,
            'code' => $resource->code,
            'parentId' => $resource->parent_id,
            'children' => $this->getMethodChildren($resource),
            'rules' => $this->whenRelationRuleWithMethods($resource),
        ];
    }

    protected function getChildren(Resources $resource): mixed
    {
        return $this->when(
            ! is_null($resource->children),
            fn () => MenuTransform::quote(['default' => $resource->children])
        );
    }

    protected function getChildrenWithRules(Resources $resource): mixed
    {
        return $this->when(
            ! is_null($resource->children),
            fn () => MenuTransform::quote(['menuWithRules' => $resource->children])
        );
    }

    protected function getChildrenPermissions(Resources $resource): mixed
    {
        return $this->when(
            ! is_null($resource->children),
            fn () => MenuTransform::quote(['menuWithPermissions' => $resource->children])
        );
    }

    protected function getOptionsChildren(Resources $resource): mixed
    {
        return $this->when(
            ! is_null($resource->children),
            fn () => MenuTransform::quote(['options' => $resource->children])
        );
    }

    protected function getMethodChildren(Resources $resource): mixed
    {
        return $this->when(
            ! is_null($resource->children),
            fn () => MenuTransform::quote(['menuRulesWithMethods' => $resource->children])
        );
    }

    /**
     * @param  $key
     */
    protected function whenRelationRule(Resources $resource): mixed
    {
        return $this->when(
            $resource->get()->relationLoaded('rules'),
            fn () => RuleTransform::quote(['methods' => $resource->rules])
        );
    }

    /**
     * @param  $key
     */
    protected function whenRelationPermissions(Resources $resource): mixed
    {
        return $this->when(
            $resource->get()->relationLoaded('permissions'),
            fn () => PermissionTransform::quote(['permissions' => $resource->permissions])
        );
    }

    /**
     * @param  $key
     */
    protected function whenRelationRuleWithMethods(Resources $resource): mixed
    {
        return $this->when(
            ! is_null($resource->rules),
            fn () => RuleTransform::quote(['methodAndPermissions' => $resource->rules])
        );
    }
}
