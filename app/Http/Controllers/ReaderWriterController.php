<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReaderWriterController extends Controller
{
    private $dir, $fileReader,  $fileWriter;

    public function __construct()
    {
        $this->dir = "..\\Gherkin\\";
        $this->fileReader = null;
        $this->fileWritter = null;
    }

    // ambil dari index 2
    public function bacaNamaFile()
    {
        $namaFile = [];
        if (is_dir($this->dir)) {
            if ($dh = opendir($this->dir)) {
                while (($file = readdir($dh)) !== false) {
                    array_push($namaFile, $file);
                }
                closedir($dh);
            }
        }
        // return view('test', ["temp" => $temp]);
        return $namaFile;
    }

    public function bacaFileHeader($file)
    {
        $header = [];
        $words = preg_split('/\s+/', fgets($file), -1, PREG_SPLIT_NO_EMPTY);
        $folderName = $words[1];
        array_push($header, $folderName);
        $newFileName = $words[2];
        array_push($header, $newFileName);
        $namaModel = $words[3];
        array_push($header, $namaModel);

        return $header;
    }

    public function setFileReader($namaFile)
    {
        $this->fileReader = fopen($this->dir . $namaFile, 'r');
    }

    public function getFileReader()
    {
        return $this->fileReader;
    }
}
