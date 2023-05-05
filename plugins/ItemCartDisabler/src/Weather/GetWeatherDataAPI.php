<?php

namespace ItemCartDisabler\Weather;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetWeatherDataAPI
{
    private SystemConfigService $systemConfig;
    private HttpClientInterface $httpClient;

    public function __construct(SystemConfigService $systemConfig, HttpClientInterface $httpClient)
    {
        $this->systemConfig = $systemConfig;
        $this->httpClient = $httpClient;
    }

    public function getWeatherData($state): array
    {
        $request = $this->httpClient->request(
            'GET',
            "https://weatherapi-com.p.rapidapi.com/current.json?q=$state",
            ['headers' =>
                [   'X-RapidAPI-Host' => " weatherapi-com.p.rapidapi.com",
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

    public function getTemperature($content): float
    {
        return $content['current']['temp_c'];
    }

}

