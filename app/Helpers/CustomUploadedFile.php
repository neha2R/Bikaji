<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

class CustomUploadedFile extends UploadedFile
{
    protected $desiredSize;

    public function setDesiredSize($size)
    {
        $this->desiredSize = $size;
    }

    public function getSize()
    {
        return $this->desiredSize;
    }
}
