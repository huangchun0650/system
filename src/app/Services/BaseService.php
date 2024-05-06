<?php

namespace YFDev\System\App\Services;

use YFDev\System\App\Constants\ErrorCode;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/** 抽象類 Services*/
abstract class BaseService
{
    /**
     * errorCode
     *
     * @param String $errorCode
     * @return int
     */
    protected function errorCode(String $errorCode): Int
    {
        return constant(ErrorCode::class . '::' . $errorCode);
    }

    /**
     * arrayChanges
     *
     * @param Array $originalData
     * @param Array $newData
     * @return Array
     */
    protected function arrayChanges(array $originalData, array $newData): array
    {
        $toAdd = array_diff($newData, $originalData);
        $toDelete = array_diff($originalData, $newData);

        return [
            'toAdd'    => $toAdd,
            'toDelete' => $toDelete
        ];
    }

    protected function relationDataChange($model, array $newData)
    {
        $diff = $this->arrayChanges($model->pluck('id')->all(), $newData);

        if (!empty($diff['toAdd'])) {
            $model->attach($diff['toAdd']);
        }

        if (!empty($diff['toDelete'])) {
            $model->detach($diff['toDelete']);
        }
    }

    /**
     * buildTree
     *
     * @param array $categories
     * @param [type] $parentId
     * @return array $tree
     */
    protected function buildTree(array $categories, $parentId = NULL)
    {
        $tree = [];

        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $children = $this->buildTree($categories, $category['id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $tree[] = $category;
            }
        }

        // 根據 $sort 欄位進行排序
        usort($tree, function ($a, $b) {
            return $a['sort_order'] <=> $b['sort_order'];
        });

        return $tree;
    }

    /**
     * Optimize an image by reducing its width by half, preserving the aspect ratio
     *
     * @param string $imagePath
     * @return void
     */
    protected function optimizeImage(string $imagePath): void
    {
        try {
            // 使用 Intervention Image 進行優化
            $image = Image::make($imagePath);

            $newWidth = round($image->width() / 2);

            // 等比例縮小圖片
            $image->widen($newWidth, function ($constraint) {
                $constraint->upsize();
            });

            // 儲存優化後的圖片並覆蓋原有檔案
            $image->save($imagePath);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * storeImage
     *
     * @param mixed   $image
     * @param string  $pathDir
     * @param string  $imageName
     * @param boolean $preservingOriginal
     * @return string
     */
    protected function storeImage(mixed $image, string $pathDir, string $imageName, bool $preservingOriginal = FALSE): string
    {
        try {
            // 將文件存儲到指定路徑
            $imagePath = $image->storeAs($pathDir, $imageName, 'public');

            // 優化圖片
            if (!$preservingOriginal) {
                $this->optimizeImage(storage_path('app/public/' . $imagePath));
            }

            return $imagePath;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * associateMediaToModel
     *
     * @param Model $model
     * @param array $mediaIds
     * @return void
     */
    protected function associateMediaToModel($model, array $mediaIds): void
    {
        try {
            foreach ($mediaIds as $collectionName => $ids) {
                /** 已鏈接的資料 **/
                $files = $model->getMedia($collectionName);

                $action = $this->arrayChanges($files->pluck('id')->all(), $ids);

                if (!empty($action['toAdd'])) {
                    collect($action['toAdd'])->map(function ($id) use ($model, $collectionName) {
                        $mediaItem = Media::find($id);
                        /** 鏈接 **/
                        $mediaItem->model_type = get_class($model);
                        $mediaItem->model_id = $model->id;
                        $mediaItem->collection_name = $collectionName;

                        $mediaItem->save();
                    });
                }

                if (!empty($action['toDelete'])) {
                    collect($action['toDelete'])->map(function ($id) {
                        $mediaItem = Media::find($id);
                        /** 移除鏈接 **/
                        $mediaItem->model_type = 'temp';
                        $mediaItem->model_id = 0;

                        $mediaItem->save();
                    });
                }
            }
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            throw $th;
        }
    }

    /**
     * 使用請求更新模型的key。
     *
     * @param Request $request 包含更新數據的請求
     * @param array $fields 要更新的key
     * @param array $forbiddenFields 禁止更新的key
     * @return Array 要更新的 params
     */
    protected function transformRequestParameters(Request $request, array $fields, array $forbiddenFields = []): array
    {
        $dataToUpdate = [];

        foreach ($fields as $modelKey => $requestKey) {
            if (is_numeric($modelKey)) {
                $modelKey = $requestKey;
            }

            if (!in_array($modelKey, $forbiddenFields)) {
                if ($request->has($requestKey)) {
                    if (is_array($request->input($requestKey))) {
                        $dataToUpdate[$modelKey] = json_encode($request->input($requestKey));
                    } elseif (stripos($requestKey, 'password') !== FALSE) {
                        $dataToUpdate[$modelKey] = Hash::make($request->input($requestKey));
                    } else {
                        $dataToUpdate[$modelKey] = $request->input($requestKey);
                    }
                }
            }
        }

        return $dataToUpdate;
    }
}
