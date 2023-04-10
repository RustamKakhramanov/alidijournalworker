<?php

namespace Fayrest\Journalworker;

class Client
{

    private $url;
    private $params;

    public function __construct($url = null, $params = null)
    {
        $this->url = $url;
        $this->params = $params;
    }
    public function prepareUrl()
    {
        return $this->url . '?' . http_build_query($this->params);
    }

    public function requestAndGetData($theme = 'LOGISTIC')
    {
        $cURLConnection = curl_init();
        curl_setopt(
            $cURLConnection,
            CURLOPT_URL,
            $this->prepareUrl()
        );

        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($cURLConnection);

        curl_close($cURLConnection);
        
        return json_decode($data, true)['content'] ?? null;
    }
}
