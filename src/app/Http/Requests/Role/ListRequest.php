<?php

namespace YFDev\System\App\Http\Requests\Role;

use YFDev\System\App\Http\Requests\BaseRequest;

class ListRequest extends BaseRequest
{
    public function rules()
    {
        $baseRules = parent::rules();

        $selfRules = [];

        return array_merge($baseRules, $selfRules);
    }
}
