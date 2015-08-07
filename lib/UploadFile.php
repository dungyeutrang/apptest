<?php

namespace lib;

/**
 * @author John Doe <john.doe@example.com>
 */
class UploadFile
{

    public $baseUrl = BASE_URL;

    public function deleteFile($url)
    {
        if (file_exists($this->baseUrl.$url) && !is_dir($this->baseUrl.$url)) {
            unlink($this->baseUrl.$url);
        }
    }

    public function addDir($url)
    {
//        var_dump(file_exists($url));die;
        if (!file_exists($this->baseUrl.$url)&& !is_dir($this->baseUrl.$url)) {
            mkdir($this->baseUrl.$url);
        }
    }
    

}