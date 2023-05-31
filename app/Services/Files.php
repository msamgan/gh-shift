<?php

namespace App\Services;

use Exception;

class Files
{
    const dbFile = 'config.json';
    const DB_SKELETON = [
        'current' => null,
        'markers' => []
    ];
    private $directories;

    public function __construct()
    {
        $this->directories = app(Directories::class);
    }

    /**
     * @return false|string
     */
    public function readFromFile()
    {
        try {
            $file = fopen($this->directories->getBaseDir() . DIRECTORY_SEPARATOR . self::dbFile, 'r');
            $jsonPayload = fread($file, filesize($this->directories->getBaseDir() . DIRECTORY_SEPARATOR . self::dbFile));
            fclose($file);

            return $jsonPayload;
        } catch (Exception $e) {
            $this->writeInFile(json_encode(self::DB_SKELETON));
            return $this->readFromFile();
        }
    }

    /**
     * @param $jsonPayload
     * @return void
     */
    public function writeInFile($jsonPayload)
    {
        $file = fopen($this->directories->getBaseDir() . DIRECTORY_SEPARATOR . self::dbFile, 'w');
        fwrite($file, $jsonPayload);
        fclose($file);
    }
}
