<?php

namespace ItemCartDisabler\Weather;




use Shopware\Core\System\SystemConfig\SystemConfigService;

class GetWeatherDataAPI
{

    public function __construct(SystemConfigService $systemConfig)
    {
        $this->systemConfig = $systemConfig;
    }

    public function getWeatherData($state)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://weatherapi-com.p.rapidapi.com/current.json?q=$state",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: weatherapi-com.p.rapidapi.com",
                "X-RapidAPI-Key: 83a73761f4msha41a29985073a3ep1eee52jsned4847050889",
                "content-type: application/octet-stream"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        }
            return $response;
    }

    public function getLocation(){
        return $this->systemConfig->get('ItemCartDisabler.config.weatherLocation');
    }

    public function getTemperature($dataJson){

        $data = json_decode($dataJson, true);

        return $data['current']['temp_c'];
    }

}

