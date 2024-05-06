<?php

namespace YFDev\System\App\Extension;

use Jenssegers\Agent\Agent;
use JetBrains\PhpStorm\ArrayShape;

class Device extends Agent
{
    #[ArrayShape(['type'     => "bool|string",
                  'platform' => "array",
                  'browser'  => "array",
                  'agent'    => "array|null|string"
    ])] public function get(): array
    {
        $browser = $this->browser();
        $platform = $this->platform();
        return [
            'type'     => $this->device(),
            'platform' => [
                'name'    => $platform,
                'version' => $this->version($platform)
            ],
            'browser' => [
                'name'    => $browser,
                'version' => $this->version($browser)
            ],
            'agent' => request()->server('HTTP_USER_AGENT'),
        ];
    }
}
