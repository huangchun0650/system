<?php

namespace YFDev\System\App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ValidMediaIds implements Rule
{
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function passes($attribute, $value)
    {
        if (! is_array($value)) {
            return false;
        }

        foreach ($value as $ids) {
            if (! is_array($ids)) {
                return false;
            }

            // 首先檢查所有ID是否為整數
            if (array_filter($ids, fn ($id) => ! is_int($id))) {
                return false;
            }

            // 使用whereIn來確認所有的ID都存在於Media中
            $existingMediaIds = Media::whereIn('id', $ids)->pluck('id')->all();
            if (count($ids) !== count($existingMediaIds)) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute id is invalid.';
    }
}
