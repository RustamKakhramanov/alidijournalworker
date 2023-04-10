<?php

namespace Fayrest\Journalworker;

use Exception;

class FileService
{

    private  $path = __DIR__ . '/data.json';

    public  function writeData($data = null)
    {
        return (file_put_contents($this->path, json_encode($data)));
    }

    public  function getData()
    {
        return  $this->parseFile(@file_get_contents($this->path, true));
    }



    public function writeAndGetData($data)
    {
        if ($this->writeData($data)) {
            return $data;
        }

        throw new Exception('File writing error', 500);
    }


    public function parseForFile($data)
    {
        return $this->writeData($data);
    }

    public function parseFile($json)
    {
        if (!$json) {
            return null;
        }

        $data = json_decode($json, true);

        return $data['end_time'] <= time() ? null : $data;
    }
}
