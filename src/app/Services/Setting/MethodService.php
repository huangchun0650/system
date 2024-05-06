<?php

namespace YFDev\System\App\Services\Setting;

use Symfony\Component\HttpFoundation\JsonResponse;
use YFDev\System\App\Http\Transforms\Models\MethodTransform;
use YFDev\System\App\Repositories\Setting\MethodRepositoryInterface;
use YFDev\System\App\Services\BaseService;

class MethodService extends BaseService
{
    protected $methodRepository;

    protected $container;

    public function __construct(MethodRepositoryInterface $methodRepository)
    {
        $this->methodRepository = $methodRepository;
    }

    /**
     * options
     */
    public function options(): JsonResponse
    {
        $methodOptions = $this->methodRepository->getAll(['id', 'name']);

        return MethodTransform::response(compact('methodOptions'));
    }

    /**
     * list
     */
    public function list(): JsonResponse
    {
        $methodList = $this->methodRepository->paginate(
            $this->methodRepository->getAll(),
            request()->input('prePage'),
            request()->input('sortBy'),
            request()->input('orderBy')
        );

        return MethodTransform::response(compact('methodList'));
    }

    /**
     * store
     */
    public function store(): \Illuminate\Http\JsonResponse
    {
        $this->methodRepository->createOrUpdateFromArray([
            'name' => request()->input('name'),
        ]);

        return json_response()->success([
            'message' => 'Method Created Successfully',
        ]);
    }

    /**
     * update
     *
     * @param  Model  $method
     */
    public function update($method): \Illuminate\Http\JsonResponse
    {
        $params = $this->transformRequestParameters(request(), ['name']);
        $method->fill($params)->save();

        return json_response()->success([
            'message' => 'Method Update Successfully',
        ]);
    }

    /**
     * destroy
     *
     * @param  Model  $method
     */
    public function destroy($method): \Illuminate\Http\JsonResponse
    {
        // TODO 檢測可否刪除
        $method->delete();

        return json_response()->success([
            'message' => 'Method Delete Successfully',
        ]);
    }
}
