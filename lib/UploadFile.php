<?php

namespace lib;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * @author John Doe <john.doe@example.com>
 */
class UploadFile
{

    public $baseUrl = BASE_URL;

    public function deleteFile($url)
    {
        if (file_exists($url) && !is_dir($url)) {
            unlink($url);
        }
    }

    public function addDir($url)
    {
        if (!file_exists($url)) {
            mkdir($url);
        }
    }

}
