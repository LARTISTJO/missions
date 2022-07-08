<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;
    private MySlugger $mySlugger;

    public function __construct($targetDirectory, MySlugger $mySlugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->mySlugger = $mySlugger;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->mySlugger->slugify($originalFilename);
        $fileName = $safeFilename . '.' . $file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            echo $e->getMessage();
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}