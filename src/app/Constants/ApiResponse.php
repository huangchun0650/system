<?php

namespace YFDev\System\App\Constants;

/**
 * ApiResponse
 */
class ApiResponse
{
    private $code = 1;

    private $meta = [];

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setMeta(array $meta)
    {
        $this->meta = $meta;
        return $this;
    }

    public function toArray(array $data = [])
    {
        return [
            'code' => $this->code,
            'data' => $data,
            'time' => time(),
        ];
    }

    public function toJson(array $data = [], $response_code = 200)
    {
        $response = [
            'code' => $this->code,
            'data' => $data,
            'time' => time(),
        ];

        if (filled($this->meta)) {
            $response['meta'] = $this->meta;
        }
        return response()->json($response, $response_code);
    }
}
