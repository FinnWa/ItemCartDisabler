<?php

declare(strict_types=1);

namespace ItemCartDisabler;

use Shopware\Core\System\SystemConfig\SystemConfigService;

class ItemCartDisablerConfigFactory
{

    private SystemConfigService $systemConfig;
    private string $apiKey;
    private string $apiHost;

    public function __construct(SystemConfigService $systemConfig, string $apiHost, string $apiKey)
    {
        $this->systemConfig = $systemConfig;
        $this->apiHost = $apiHost;
        $this->apiKey = $apiKey;
    }

    public function create(): ItemCartDisablerConfig
    {
        $location = $this->systemConfig->get('ItemCartDisabler.config.weatherLocation');

        $ItemCartDisabler = new ItemCartDisablerConfig($location, $this->apiHost, $this->apiKey);

        return $ItemCartDisabler;
    }

}