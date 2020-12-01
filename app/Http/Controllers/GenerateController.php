<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
<<<<<<< HEAD

class GenerateController extends Controller
{
    public function  index(){
        return view('generate');
    }
=======
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

    public function generateDusk()
    {
        $generateDusk = new GenerateDuskController();
        
        $namaFile = 'login'; //$argv[1];
        $header = $generateDusk->bacaFileHeader($namaFile);
        // // cara panggil : php tests/Generator/generatorUnitTesting.php login
        
        // $words = preg_split('/\s+/', fgets($fileReader), -1, PREG_SPLIT_NO_EMPTY);
        // $folderName = $words[1];
        // $newFileName = $words[2];

        $fileReader=$header[0];
        $folderName=$header[1];
        $newFileName=$header[1];

        $generateDusk->buatFolder($folderName,$newFileName);

        // // membuat file
        $fileWriter = $generateDusk->getFileWriter();

        

        // tulis ke file
        fwrite($fileWriter, "<?php\n");
        fwrite($fileWriter, "namespace Tests\Browser;\n \n");

        

        fwrite($fileWriter, "use Tests\DuskTestCase;\n");
        fwrite($fileWriter, "use Laravel\Dusk\Browser;\n");
        fwrite($fileWriter, "use Illuminate\Foundation\Testing\DatabaseMigrations;\n \n");

        fwrite($fileWriter, "class " . $newFileName . "Test" . " extends DuskTestCase { \n \n");

        $keys = ["Scenario:", "Given", "When", "And", "Then"];


        $banyakTest = 1;
        $status = "";


        if ($fileReader) {
            while (($line = fgets($fileReader)) !== false) {
                $words = preg_split('/\s+/', $line, -1, PREG_SPLIT_NO_EMPTY);
                // system("echo ".$words[0]);

                // idx untuk words
                for ($i = 0; $i < sizeof($words); $i++) {
                    if ($words[$i] == $keys[0]) { // Scenario:
                        fwrite($fileWriter, "public function testUnit" . $banyakTest . "(){\n \t");
                        fwrite($fileWriter, '$this->browse(function (Browser $browser)' . "{\n \t");
                        $banyakTest = $banyakTest + 1;
                        $status = $words[$i + 2];
                    } else if ($words[$i] == $keys[1]) { // Given
                        for ($j = 0; $j < sizeof($words); $j++) {
                            if ($words[$j] == "halaman") {
                                fwrite($fileWriter, '$browser->visit(' . "'/" . $words[$j + 1] . "') \n \t");
                            }
                        }
                    } else if ($words[$i] == $keys[2]) { // When
                        for ($j = 0; $j < sizeof($words); $j++) {
                            if ($words[$j] == "username") {
                                fwrite($fileWriter, "->type('email','" . $words[$j + 2] . "') \n \t");
                            }
                        }
                    } else if ($words[$i] == $keys[3]) { //And
                        for ($j = 0; $j < sizeof($words); $j++) {
                            if ($words[$j] == "password") {
                                fwrite($fileWriter, "->type('" . $words[$j] . "', '" . $words[$j + 2] . "') \n \t");
                            } else if ($words[$j] == "tombol") {
                                fwrite($fileWriter, "->press('Login')\n \t");
                            }
                        }
                    } else if ($words[$i] == $keys[4]) { //Then
                        for ($j = 0; $j < sizeof($words); $j++) {
                            if ($words[$j] == "berhasil") {
                                fwrite($fileWriter, "->assertPathIs('/home'); \n \t}); \n} \n \n");
                            } else if ($words[$j] == "tulisan") {
                                fwrite($fileWriter, "->assertPathIs('/login'); \n \t}); \n} \n \n");
                            }
                        }
                    }
                }
            }
        }

        fwrite($fileWriter, "}");

        return view("generate", ["dir" => $fileReader]);
    }
>>>>>>> 5e25bcafc78be4f00b50db6ab148406814913adf
}
