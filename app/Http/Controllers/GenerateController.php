<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class GenerateController extends Controller
{
    private $readerWriter;

    public function __construct()
    {
        $this->readerWriter = new ReaderWriterController();
    }

    public function  index()
    {
        $model = "App\\" . "User";
        $m = new $model;
        $fillable = $m->getFillable();
        return view("generate");
        // return view('generate', ["dir" => "test"]);
    }

    public function generateDusk()
    {
        $generateDusk = new GenerateDuskController();

        // $namaFile = $this->readerWriter->bacaNamaFile();

        // for ($i = 2; $i < sizeof($namaFile); $i++) {
        //     $temp = $namaFile[$i]; // nama file
        //     $this->readerWriter->setFileReader($temp);
        //     $fileReader = $this->readerWriter->getFileReader();

        //     $header = $this->readerWriter->bacaFileHeader($fileReader);

        //     $folderName = $header[0];
        //     $newFileName = $header[1];
        //     $namaModel = $header[2];

        //     $generateDusk->buatFolder($folderName, $newFileName);

        //     $generateDusk->writeBody($newFileName, $fileReader, $namaModel);

        //     $model = "App\\" . $namaModel;
        //     $m = new $model;
        //     $fillable = $m->getFillable();
        // }



        $namaFile = 'logout'; //$argv[1];
        // baca folder gerkin
        // masukan semua nama file
        // nanti di loop
        $header = $generateDusk->bacaFileHeader($namaFile);
        // // cara panggil : php tests/Generator/generatorUnitTesting.php login

        // $words = preg_split('/\s+/', fgets($fileReader), -1, PREG_SPLIT_NO_EMPTY);
        // $folderName = $words[1];
        // $newFileName = $words[2];

        $fileReader = $header[0];
        $folderName = $header[1];
        $newFileName = $header[2];
        $namaModel = $header[3];

        $generateDusk->buatFolder($folderName, $newFileName);

        // // membuat file
        // $fileWriter = $generateDusk->getFileWriter();

        // tulis ke file
        $generateDusk->writeBody($newFileName, $fileReader, $namaModel);

        $model = "App\\" . $namaModel;
        $m = new $model;
        $fillable = $m->getFillable();
        return view("generate", ["dir" => $fillable]);
    }
}
