<?php

namespace YFDev\System\App\Services\Menu;

use Symfony\Component\HttpFoundation\JsonResponse;
use YFDev\System\App\Exceptions\Request\NotAllowDeleteException;
use YFDev\System\App\Http\Transforms\Models\MenuTransform;
use YFDev\System\App\Repositories\Menu\MenuRepositoryInterface;
use YFDev\System\App\Services\BaseService;

class MenuService extends BaseService
{
    protected $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * tree
     */
    public function tree(): JsonResponse
    {
        $selfPermissions = $this->getAdminPermissions()->pluck('name')->all();
        $tree = $this->buildTree($this->menuRepository->getMenus($selfPermissions)->get()->toArray());

        return MenuTransform::response(compact('tree'));
    }

    /**
     * store
     */
    public function store(): \Illuminate\Http\JsonResponse
    {
        $fields = $this->menuRepository->getConstants('FIELDS');
        $params = $this->transformRequestParameters(request(), $fields);

        $this->menuRepository->createOrUpdateFromArray($params);

        return json_response()->success([
            'message' => 'Menu Created Successfully',
        ]);
    }

    /**
     * update
     *
     * @param  Model  $menu
     */
    public function update($menu): \Illuminate\Http\JsonResponse
    {
        $fields = $this->menuRepository->getConstants('FIELDS');
        $params = $this->transformRequestParameters(request(), $fields);

        $menu->fill($params)->save();

        return json_response()->success([
            'message' => 'Menu Update Successfully',
        ]);
    }

    /**
     * destroy
     *
     * @param  Model  $menu
     *
     * @throws \Throwable
     */
    public function destroy($menu): \Illuminate\Http\JsonResponse
    {
        // 不能刪除有子類的選單
        if ($menu->where('parent_id', $menu->id)->count()) {
            throw new NotAllowDeleteException('Can not delete menu with child level');
        }

        $menu->delete();

        return json_response()->success([
            'message' => 'Menu Delete Successfully',
        ]);
    }

    /**
     * menuRules
     */
    public function menuRules(): JsonResponse
    {
        $menuWithRules = collect($this->buildTree($this->menuRepository->getMenusWithRules()->all()));

        return MenuTransform::response(compact('menuWithRules'));
    }

    /**
     * menuUpdateRules
     *
     * @param  Model  $menu
     */
    public function menuUpdateRules($menu): \Illuminate\Http\JsonResponse
    {
        if (request()->has('rules')) {
            $this->relationDataChange($menu->rules(), request()->input('rules'));
            $permissions = $menu->rules->map(fn ($rule) => json_decode($rule->permissions))
                ->flatten()
                ->unique()
                ->values()
                ->all();

            $this->relationDataChange($menu->permissions(), $permissions);
        }

        return json_response()->success([
            'message' => 'Menu rules Update Successfully',
        ]);
    }

    /**
     * options
     */
    public function options(): JsonResponse
    {
        $permissions = $this->getAdminPermissions();
        $options = $this->buildTree($this->menuRepository->permissionGetMenuRoleOption($permissions)->all());

        return MenuTransform::response(compact('options'));
    }
}
