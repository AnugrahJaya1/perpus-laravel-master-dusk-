<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class GenerateController extends Controller
{
    private $model;

    public function  index()
    {
        // $this->model = new User();
        // $fill = $this->model->getFillable();
        return view('generate');
    }

    private function readAllScenarioName(){

    }

    public function generateDusk()
    {
        $generateDusk = new GenerateDuskController();
        
        $namaFile = 'login'; //$argv[1];
        // baca folder gerkin
        // masukan semua nama file
        // nanti di loop
        $header = $generateDusk->bacaFileHeader($namaFile);
        // // cara panggil : php tests/Generator/generatorUnitTesting.php login
        
        // $words = preg_split('/\s+/', fgets($fileReader), -1, PREG_SPLIT_NO_EMPTY);
        // $folderName = $words[1];
        // $newFileName = $words[2];

        $fileReader=$header[0];
        $folderName=$header[1];
        $newFileName=$header[1];
        $namaModel = $header[3];

        $generateDusk->buatFolder($folderName,$newFileName);

        // // membuat file
        $fileWriter = $generateDusk->getFileWriter();

        // tulis ke file
        $generateDusk->writeBody($fileWriter, $newFileName, $fileReader, $namaModel);

        return view("generate", ["dir" => $namaModel]);
    }
}
