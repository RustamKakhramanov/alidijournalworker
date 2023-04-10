<?php

namespace Fayrest\Journalworker;

class Service
{

    private Client $client;
    private FileService $fileService;

    private $config = [
        'api_url' => 'https://alidi.ru/api/articles',
        'api_params' => [
            'type' => 'Blog',
        ]
    ];

    public  function setConfig($config)
    {
        $this->config = array_replace_recursive($this->config, $config);

        $this->client = new Client(
            $this->config['api_url'],
            $this->config['api_params']
        );

    }

    public function __construct($theme, $type = 'BLOG')
    {
        if ($theme) {
            $this->config['api_params']['theme'] = $theme;
        }

        if ($type) {
            $this->config['api_params']['type'] = $type;
        }

        $this->fileService = new FileService();

        $this->client = new Client(
            $this->config['api_url'],
            $this->config['api_params']
        );
    }

    public function getPosts($theme = null)
    {
        if ($theme) {
            $this->config['api_params']['theme'] = $theme;
        }
        if (!$data = $this->fileService->getData()) {
            $data = $this->fileService->writeAndGetData(
                Adapter::adaptee(
                    $this->client->requestAndGetData()
                )
            );
        }

        return $data['data'];
    }

    public static function getPostsWithTeme($theme)
    {
        return (new static($theme))->getPosts();
    }
}
