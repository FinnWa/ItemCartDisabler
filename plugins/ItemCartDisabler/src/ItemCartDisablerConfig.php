<?php

declare(strict_types=1);

namespace ItemCartDisabler;

use Shopware\Core\System\SystemConfig\SystemConfigService;

class ItemCartDisablerConfig
{
    private string $location;
    private string $apiHost;
    private string $apiKey;


    public function __construct(string $location, string $apiHost, string $apiKey)
    {
        $this->location = $location;
        $this->apiHost = $apiHost;
        $this->apiKey = $apiKey;
    }


    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getApiHost(): string
    {
        return $this->apiHost;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

}