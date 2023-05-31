<?php

namespace App\Commands;

use App\Services\Directories;
use App\Services\Files;
use LaravelZero\Framework\Commands\Command;

abstract class BaseCommand extends Command
{
    protected $directories;
    protected $files;

    public function __construct()
    {
        parent::__construct();
        $this->directories = app(Directories::class);
        $this->files = app(Files::class);
    }

    protected function checkBase()
    {
        if (!$this->directories->ifBaseDirExistAtRoot()) {
            $this->directories->createBaseDir();
        }
    }

    /**
     * @return mixed
     */
    protected function getDb()
    {
        return json_decode($this->files->readFromFile(), true);
    }
}
