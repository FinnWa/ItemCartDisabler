<?php

namespace ItemCartDisabler;

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

    public static function create(string $location, string $apiHost, string $apiKey): self{
        $config = new self($location,  $apiHost, $apiKey);
        $config->apiHost = $apiHost;
        $config->apiKey =$apiKey;
        $config->location = $location;

        return $config;
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