<?php

namespace YFDev\System\App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use ReflectionClass;

class BaseRequest extends FormRequest
{
    protected function rules()
    {
        return [
            'page' => [
                'sometimes',
                'integer',
                'min:1',
            ],
            'prePage' => [
                'sometimes',
                'integer',
                'min:1',
                'max:100',
            ],
            'orderBy' => [
                'sometimes',
                'string',
                Rule::in(['desc', 'asc', 'DESC', 'ASC']),
            ],
            'sortBy' => [
                'sometimes',
                'string',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->getMessageBag();

        if (class_exists($error->first())) {
            $key = Arr::first($error->keys());
            throw new ($error->first())($key);
        }

        return throw new ValidationException($validator);
    }

    /**
     * getConstantsByPrefix
     */
    protected function getConstantsByPrefix(string $className, string $prefix): array
    {
        $constants = (new ReflectionClass($className))->getConstants();

        return array_filter($constants, function ($key) use ($prefix) {
            return strpos($key, $prefix) === 0;
        }, ARRAY_FILTER_USE_KEY);
    }
}
