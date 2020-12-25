<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use SebastianBergmann\Environment\Console;
use Svg\Tag\Rect;

class GenerateController extends Controller
{
    private $readerWriter;
    private $input;

    public function __construct(Request $request)
    {
        $this->readerWriter = new ReaderWriterController();
        $this->input = $request->input();
    }

    // public function  index()
    // {
    //     // $model = "App\\" . "User";
    //     // $m = new $model;
    //     // $fillable = $m->getFillable();
    //     // return view("generate");
    //     return view('generate', ["dir" => "test"]);
    // }

    public function generateDusk()
    {
        $namaFile = $this->readerWriter->bacaNamaFile();

        $generateDusk = new GenerateDuskController();

        // loop untuk semua nama file
        for ($i = 2; $i < sizeof($namaFile); $i++) {
            $file = $namaFile[$i];

            // set file reader
            $this->readerWriter->setFileReader($file);
            // get file reader
            $fileReader = $this->readerWriter->getFileReader();


            // membaca header
            $header = $this->readerWriter->bacaFileHeader();

            $folderName = $header[0];
            $newFileName = $header[1];
            $namaModel = $header[2];

            // buat folder + set file writer di readerWriter
            $newDir = $generateDusk->getNewDir();
            $this->readerWriter->buatFolder($newDir, $folderName, $newFileName);

            $fileWriter = $this->readerWriter->getFileWriter();
            $generateDusk->setFileWriter($fileWriter);



            // bikin body
            $generateDusk->writeBody($newFileName, $fileReader, $namaModel);
        }


        // $namaFile = 'tambah_user.txt'; //$argv[1];
        // // baca folder gerkin
        // // masukan semua nama file
        // // nanti di loop
        // $header = $generateDusk->bacaFileHeader($namaFile);
        // // // cara panggil : php tests/Generator/generatorUnitTesting.php login

        // // $words = preg_split('/\s+/', fgets($fileReader), -1, PREG_SPLIT_NO_EMPTY);
        // // $folderName = $words[1];
        // // $newFileName = $words[2];

        // $fileReader = $header[0];
        // $folderName = $header[1];
        // $newFileName = $header[2];
        // $namaModel = $header[3];

        // $generateDusk->buatFolder($folderName, $newFileName);

        // // // membuat file
        // // $fileWriter = $generateDusk->getFileWriter();

        // // tulis ke file
        // $generateDusk->writeBody($newFileName, $fileReader, $namaModel);

        // $model = "App\\" . $namaModel;
        // $m = new $model;
        // $fillable = $m->getFillable();
        return view("generate", ["dir" => $namaFile]);
    }

    public function generatePHPUnit()
    {
        $generatePHPUnit = new GeneratePHPUnitController();
        $namaFile = 'transaksi.txt'; //$argv[1];
        // baca folder gerkin
        // masukan semua nama file
        // nanti di loop
        // set file reader
        $this->readerWriter->setFileReader($namaFile);
        // get file reader
        $fileReader = $this->readerWriter->getFileReader();


        // membaca header
        $header = $this->readerWriter->bacaFileHeader();

        $folderName = $header[0];
        $newFileName = $header[1];
        $namaModel = $header[2];

        // buat folder + set file writer di readerWriter
        $newDir = $generatePHPUnit->getNewDir();
        $this->readerWriter->buatFolder($newDir, $folderName, $newFileName);

        $fileWriter = $this->readerWriter->getFileWriter();
        $generatePHPUnit->setFileWriter($fileWriter);



        // bikin body
        $generatePHPUnit->writeBody($newFileName, $fileReader, $namaModel, $folderName);
        return view("generate", ["dir" => $namaFile]);
    }

    public function mode(Request $request)
    {
        $btn = $request['btn'];
        if ($btn == 'dusk') {
            $this->generateDusk();
        } else {
            $this->generatePHPUnit();
        }
        return view("generate", ["dir" => $request['btn']]);
    }
}
