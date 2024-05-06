<?php

namespace YFDev\System\App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use YFDev\System\App\Constants\ErrorCode;
use YFDev\System\App\Services\Media\MediaService;

class MediaController extends BaseController
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function show($filePath)
    {
        $path = 'private/'.decrypt($filePath);
        if (! Storage::exists($path)) {
            abort(404);
        }

        $filePath = storage_path("app/{$path}");

        return response()->file($filePath);
    }

    public function upload($type)
    {
        if (! array_key_exists($type, config('media-type-mapping'))) {
            return json_response()->failed(ErrorCode::SYSTEM_ERROR, 'Invalid type provided.');
        }

        // 使用 Laravel 的 DI 來動態注入對應的 Request
        app(config('media-type-mapping')[$type]['verify']);

        $mediaIds = $this->mediaService->handleUploadedFiles($type);

        return response()->json(['mediaIds' => $mediaIds]);
    }
}
