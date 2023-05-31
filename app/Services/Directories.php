<?php

namespace App\Services;

class Directories
{
    /**
     * @return bool
     */
    public function ifBaseDirExistAtRoot()
    {
        if (file_exists(self::getBaseDir())) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getBaseDir()
    {
        return getenv('HOME') . DIRECTORY_SEPARATOR . '.gh_shift';
    }

    /**
     * @return string
     */
    public function getGhConfigDir()
    {
        return getenv('HOME') . DIRECTORY_SEPARATOR . '.config' . DIRECTORY_SEPARATOR . 'gh';
    }

    /**
     * @return void
     */
    public function createBaseDir()
    {
        mkdir(self::getBaseDir());
    }
}
