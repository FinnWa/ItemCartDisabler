<?php

namespace ItemCartDisabler\Weather;

use ItemCartDisabler\ItemCartDisablerConfig;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetWeatherDataAPI
{
    private SystemConfigService $systemConfig;
    private HttpClientInterface $httpClient;
    private ItemCartDisablerConfig $config;

    public function __construct(SystemConfigService $systemConfig, HttpClientInterface $httpClient, ItemCartDisablerConfig $config)
    {
        $this->systemConfig = $systemConfig;
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    public function getWeatherData($state): array
    {
        $request = $this->httpClient->request(
            'GET',
            "https://weatherapi-com.p.rapidapi.com/current.json?q=$state",
            ['headers' =>
                [   'X-RapidAPI-Host' => $this->config->getApiHost(),
                    'X-RapidAPI-Key' => "83a73761f4msha41a29985073a3ep1eee52jsned4847050889",
                    'content-type' => 'application/octet-stream'
                ]
            ]
        );

        return $request->toArray();
    }

    public function getLocation(): string
    {
        return $this->systemConfig->get('ItemCartDisabler.config.weatherLocation');
    }

    public function getTemperature(): float
    {
        $content = $this->getWeatherData($this->getLocation());
        return $content['current']['temp_c'];
    }

}

