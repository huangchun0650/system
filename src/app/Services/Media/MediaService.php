<?php

namespace YFDev\System\App\Services\Media;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use YFDev\System\App\Services\BaseService;

class MediaService extends BaseService
{
    /**
     * handleUploadedFiles
     *
     * @param  string|null  $model
     * @param  int|null  $id
     */
    public function handleUploadedFiles(string $type): array
    {
        return collect(request()->allFiles())
            ->filter(fn ($file, $key) => $this->isValidMediaKey($type, $key))
            ->mapWithKeys(fn ($files, $key) => [$key => $this->processFiles($files, $type, $key)])
            ->toArray();
    }

    /**
     * isValidMediaKey
     */
    private function isValidMediaKey(string $type, string $key): bool
    {
        return isset(config('media-type-mapping')[$type][$key]);
    }

    /**
     * processFiles
     *
     * @param  string|null  $model
     * @param  int|null  $id
     */
    private function processFiles(mixed $files, string $type, string $key): array
    {
        $config = config("media-type-mapping.{$type}.{$key}");
        $filesArray = is_array($files) ? $files : [$files];

        return collect($filesArray)
            ->map(fn ($file) => $this->storeMedia($file, $config))
            ->toArray();
    }

    /**
     * storeMedia
     *
     * @param  string|null  $model
     * @param  int|null  $id
     */
    private function storeMedia(mixed $file, array $config): int
    {
        $attributes = $this->getMediaAttributes($file, $config);
        $mediaItem = Media::create($attributes);

        $driver = $config['isPrivate'] ? 'private' : 'public';

        $file->storeAs($config['directory'], $attributes['file_name'], $driver);

        return $mediaItem->id;
    }

    /**
     * getMediaAttributes
     *
     * @param  string|null  $model
     * @param  int|null  $id
     */
    private function getMediaAttributes(mixed $file, array $config): array
    {
        return [
            'name' => $file->getClientOriginalName(),
            'file_name' => time().'_'.$file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'custom_properties' => $config['directory'],
            'manipulations' => json_encode($config['manipulations']),
            'collection_name' => $config['collection'],
            'generated_conversions' => ['thumbnail'],
            'responsive_images' => json_encode([]),
            'disk' => $config['isPrivate'] ? 'private' : 'public',
            'model_type' => 'temp',
            'model_id' => 0,
        ];
    }
}
