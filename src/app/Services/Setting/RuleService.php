<?php

namespace YFDev\System\App\Services\Setting;

use Symfony\Component\HttpFoundation\JsonResponse;
use YFDev\System\App\Http\Transforms\Models\RuleTransform;
use YFDev\System\App\Repositories\Setting\RuleRepositoryInterface;
use YFDev\System\App\Services\BaseService;

class RuleService extends BaseService
{
    protected $ruleRepository;

    public function __construct(RuleRepositoryInterface $ruleRepository)
    {
        $this->ruleRepository = $ruleRepository;
    }

    /**
     * list
     */
    public function list(): JsonResponse
    {
        $ruleList = $this->ruleRepository->paginate(
            $this->ruleRepository->getRuleWithMethods()->get(),
            request()->input('prePage'),
            request()->input('sortBy'),
            request()->input('orderBy')
        );

        return RuleTransform::response(compact('ruleList'));
    }

    /**
     * detail
     *
     * @param  Model  $rule
     */
    public function detail($rule): JsonResponse
    {
        $ruleDetail = $this->ruleRepository->getRuleWithMethods($rule->id)->first();

        return RuleTransform::response(compact('ruleDetail'));
    }

    /**
     * store
     */
    public function store(): \Illuminate\Http\JsonResponse
    {
        $fields = $this->ruleRepository->getConstants('FIELDS');
        $params = $this->transformRequestParameters(request(), $fields);

        $this->ruleRepository->createOrUpdateFromArray($params);

        return json_response()->success([
            'message' => 'Rule Created Successfully',
        ]);
    }

    /**
     * update
     *
     * @param  Model  $rule
     */
    public function update($rule): \Illuminate\Http\JsonResponse
    {
        $fields = $this->ruleRepository->getConstants('FIELDS');
        $params = $this->transformRequestParameters(request(), $fields);

        $rule->fill($params)->save();

        return json_response()->success([
            'message' => 'Rule Update Successfully',
        ]);
    }

    /**
     * destroy
     *
     * @param  Model  $rule
     */
    public function destroy($rule): \Illuminate\Http\JsonResponse
    {
        // TODO 檢測可否刪除
        $rule->delete();

        return json_response()->success([
            'message' => 'Rule Delete Successfully',
        ]);
    }

    /**
     * options
     */
    public function options(): JsonResponse
    {
        $ruleOptions = $this->ruleRepository->getAll(['id', 'name']);

        return RuleTransform::response(compact('ruleOptions'));
    }
}
