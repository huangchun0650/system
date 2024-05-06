<?php

namespace YFDev\System\App\Http\Requests\Setting;

use Illuminate\Validation\Rule;
use YFDev\System\App\Http\Requests\BaseRequest;

class CreateMethodRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('methods', 'name'),
            ],
        ];
    }
}
