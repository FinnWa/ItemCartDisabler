<?php

namespace ItemCartDisabler\Weather;

use ItemCartDisabler\ItemCartDisablerConfig;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetWeatherDataAPI
{

    private HttpClientInterface $httpClient;
    private ItemCartDisablerConfig $config;

    public function __construct(HttpClientInterface $httpClient, ItemCartDisablerConfig $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    public function getWeatherData(): array
    {
        $request = $this->httpClient->request(
            'GET',
            sprintf('https://%s/current.json?q=%s', $this->config->getApiHost(), $this->config->getLocation()),
            ['headers' =>
                [   'X-RapidAPI-Host' => $this->config->getApiHost(),
                    'X-RapidAPI-Key' => $this->config->getApiKey(),
                    'content-type' => 'application/octet-stream'
                ]
            ]
        );

        return $request->toArray();
    }

    public function getTemperature(): float
    {
        $content = $this->getWeatherData();
        return $content['current']['temp_c'];
    }

}

