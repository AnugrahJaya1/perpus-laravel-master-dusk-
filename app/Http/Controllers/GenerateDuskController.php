<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenerateDuskController extends Controller
{
    private $dir, $newDir, $fileWriter;

    public function __construct()
    {
        $this->dir="../Gherkin/";
        $this->newDir ='../../../tests/Browser/';
    }

    public function bacaFileHeader($namaFile){
        $header=[];
        if (is_dir($this->dir)) {
            if ($dh = opendir($this->dir)) {
                while (($file = readdir($dh)) !== false) {
                    $str = "filename: $file : filetype: " . filetype($this->dir . $file) . "\n";

                    // cek kesamaan kata dari argumen dan nama file
                    // bisa engga perlu dicek kesamaan, kalau ada langsung baca filenya dan buat -> menghilangkan param namaFile
                    if (similar_text($file, $namaFile) >= 5) {
                        $fileReader = fopen($this->dir . $file, 'r');
                        array_push($header, $fileReader);
                        break;
                    }
                }
                closedir($dh);
            }
        }

        $words = preg_split('/\s+/', fgets($fileReader), -1, PREG_SPLIT_NO_EMPTY);
        $folderName = $words[1];
        array_push($header, $folderName);
        $newFileName = $words[2];
        array_push($header, $newFileName);

        return $header;
    }

    public function buatFolder($folderName, $fileName){
        $dir = dirname(__DIR__) . $this->newDir . $folderName;

        if (is_dir($dir) === false) {
            mkdir($dir);
        }

        $this->fileWriter = fopen($dir . '/' . $fileName . 'Test.php', 'w');
    }

    public function getFileWriter(){
        return $this->fileWriter;
    }
}
