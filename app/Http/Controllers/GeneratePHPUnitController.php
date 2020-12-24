<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneratePHPUnitController extends Controller
{
    private $dir, $newDir, $fileWriter;

    public function __construct()
    {
        $this->dir = "..\\Gherkin\\";
        $this->newDir = '..\\..\\..\\tests\\Feature\\';
    }

    public function setFileWriter($fileWriter)
    {
        $this->fileWriter = $fileWriter;
    }

    private function write($text)
    {
        fwrite($this->fileWriter, $text);
    }

    public function getNewDir()
    {
        return $this->newDir;
    }

    public function writeBody($newFileName, $fileReader, $namaModel, $namaFolder)
    {

        $this->write("<?php\n");
        $this->write("namespace Tests\\Feature\\" . $namaFolder . ";\n \n");

        $this->write("use Tests\TestCase;\n");
        $this->write("use Illuminate\Foundation\Testing\WithFaker;\n");
        $this->write("use Illuminate\Foundation\Testing\RefreshDatabase;\n \n");

        $this->write("class " . $newFileName . "Test" . " extends TestCase { \n \n");

        // atribut bantuan
        $keys = [
            "Scenario:", "Given", "When", "And", "Then", "halaman", "Login",
            "berhasil", "tulisan", "Sign", "kembali"
        ];


        $pathModel = "App\\" . $namaModel;
        $model = new $pathModel;
        $fillable = $model->getFillable();

        $banyakTest = 1;
        $status = "";

        $used = [];
        $array = [];
        $logout = false;

        if ($fileReader) {
            while (($line = fgets($fileReader)) !== false) {
                $words = preg_split('/\s+/', $line, -1, PREG_SPLIT_NO_EMPTY);
                // system("echo ".$words[0]);

                // idx untuk words
                for ($i = 0; $i < sizeof($words); $i++) {

                    if ($words[$i] == $keys[0]) { // Scenario:
                        $this->write("public function testUnit" . $banyakTest . "(){\n \t");
                        $banyakTest++;
                    } else if ($words[$i] == $keys[1]) { // Given
                        for ($j = 0; $j < sizeof($words); $j++) {
                            if ($words[$j] == $keys[5]) { //halaman
                                $this->write('$response = $this->post(' . "'/" . $words[$j + 1] . "',[\n\t");
                            }
                        }
                    } else if ($words[$i] == $keys[2] || $words[$i] == $keys[3]) { // When & And
                        for ($j = 0; $j < sizeof($words); $j++) {
                            foreach ($fillable as $atr) {
                                if ($words[$j] == $atr) {
                                    if (in_array($words[$j], $used) == false) {
                                        $key = $words[$j];
                                        $array[$key] = [];

                                        array_push($used, $words[$j]);
                                        array_push($array[$key], $words[$j + 2]);
                                    }
                                }
                            }
                            if ($words[$j] == $keys[6]) { //login
                                // $this->write("\n\t");
                                foreach ($array as $key => $value) {
                                    $this->write("'" . $key . "'=>'" . $value[0] . "',\n\t");
                                }
                                $this->write("]);\n\t");
                            } else if ($words[$j] == $keys[9]) { // Sign -> Signout
                                $this->write('$response = $this->post(' . "'/logout');\n\t");
                                $logout = true;
                            }
                        }
                    } else if ($words[$i] == $keys[4]) { //Then
                        for ($j = 0; $j < sizeof($words); $j++) {
                            if ($words[$j] == $keys[7]) { // berhasil
                                if ($logout) {
                                    $this->write('$response->assertRedirect(' . "''" . "); \n\t} \n\t \n\t");
                                } else {
                                    $this->write('$response->assertRedirect(' . "'/" . $words[sizeof($words) - 1] . "'" . "); \n\t} \n\t \n\t");
                                }
                            } else if ($words[$j] == $keys[10]) { // kembali
                                $this->write('$response->assertRedirect(' . "''" . "); \n\t} \n\t \n\t");
                            }
                        }
                        $array = [];
                        $used = [];
                    }
                }
            }
        }

        $this->write("}");
    }
}
