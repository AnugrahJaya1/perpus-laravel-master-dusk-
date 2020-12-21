<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use Illuminate\Support\Facades\App as FacadesApp;
use OutOfBoundsException;

class GenerateDuskController extends Controller
{
    private $dir, $newDir, $fileWriter;

    public function __construct()
    {
        $this->dir = "..\\Gherkin\\";
        $this->newDir = '..\\..\\..\\tests\\Browser\\';
    }

    // public function bacaFileHeader($namaFile)
    // {
    //     $header = [];
    //     if (is_dir($this->dir)) {
    //         if ($dh = opendir($this->dir)) {
    //             while (($file = readdir($dh)) !== false) {
    //                 $str = "filename: $file : filetype: " . filetype($this->dir . $file) . "\n";

    //                 // cek kesamaan kata dari argumen dan nama file
    //                 // bisa engga perlu dicek kesamaan, kalau ada langsung baca filenya dan buat -> menghilangkan param namaFile
    //                 // if (similar_text($file, $namaFile) >= 5) {
    //                 //     $fileReader = fopen($this->dir . $file, 'r');
    //                 //     array_push($header, $fileReader);
    //                 //     break;
    //                 // }

    //                 if ($file == $namaFile) {
    //                     $fileReader = fopen($this->dir . $file, 'r');
    //                     array_push($header, $fileReader);
    //                     break;
    //                 }
    //             }
    //             closedir($dh);
    //         }
    //     }

    //     $words = preg_split('/\s+/', fgets($fileReader), -1, PREG_SPLIT_NO_EMPTY);
    //     $folderName = $words[1];
    //     array_push($header, $folderName);
    //     $newFileName = $words[2];
    //     array_push($header, $newFileName);
    //     $namaModel = $words[3];
    //     array_push($header, $namaModel);

    //     return $header;
    // }

    // public function buatFolder($folderName, $fileName)
    // {
    //     $dir = dirname(__DIR__) . $this->newDir . $folderName;

    //     if (is_dir($dir) === false) {
    //         mkdir($dir);
    //     }

    //     $this->fileWriter = fopen($dir . '/' . $fileName . 'Test.php', 'w');
    // }

    // public function getFileWriter()
    // {
    //     return $this->fileWriter;
    // }

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

    public function writeBody($newFileName, $fileReader, $namaModel)
    {
        //header body
        $this->write("<?php\n");
        $this->write("namespace Tests\Browser;\n \n");

        $this->write("use Tests\DuskTestCase;\n");
        $this->write("use Laravel\Dusk\Browser;\n");
        $this->write("use Illuminate\Foundation\Testing\DatabaseMigrations;\n \n");

        $this->write("class " . $newFileName . "Test" . " extends DuskTestCase { \n \n");


        // atribut bantuan
        $keys = [
            "Scenario:", "Given", "When", "And", "Then", "halaman", "tombol", "berhasil", "tulisan", "login", "menggunakan", "link",
            "opsi", "atribut", "melampirkan", "memilih", "email", "password", "password_confirmation", "User", "sudah login", "jenis_kelamin", "menunggu",
            "klik", "keterangan"
        ];


        $pathModel = "App\\" . $namaModel;
        $model = new $pathModel;
        $fillable = $model->getFillable();

        $banyakTest = 1;
        $status = "";

        $used = [];

        if ($fileReader) {
            while (($line = fgets($fileReader)) !== false) {
                $words = preg_split('/\s+/', $line, -1, PREG_SPLIT_NO_EMPTY);
                // system("echo ".$words[0]);

                // idx untuk words
                for ($i = 0; $i < sizeof($words); $i++) {
                    if ($words[$i] == $keys[0]) { // Scenario:
                        $this->write("public function testUnit" . $banyakTest . "(){\n \t");
                        $this->write('$this->browse(function (Browser $browser)' . "{\n \t");

                        $banyakTest = $banyakTest + 1;
                        $status = $words[$i + 2];
                        $used = [];
                    } else if ($words[$i] == $keys[1]) { // Given
                        for ($j = 0; $j < sizeof($words); $j++) {
                            if ($words[$j] == $keys[5]) { // halaman
                                $this->write('$browser->visit(' . "'/" . $words[$j + 1] . "') \n \t");
                            }
                            // else if ($words[$j] == $keys[9]) { //login
                            //     if (isset($words[$j + 1])) {
                            //         if ($words[$j + 1] == $keys[10]) { //menggunakan
                            //             $this->write('$browser->loginAs(' . "'" . $words[sizeof($words) - 1] . "') \n \t");
                            //             break;
                            //         }
                            //     }
                            // }
                        }
                    } else if ($words[$i] == $keys[2] || $words[$i] == $keys[3]) { // When & And
                        for ($j = 0; $j < sizeof($words); $j++) {
                            foreach ($fillable as $atr) {
                                if ($words[$j] == $atr) {
                                    if (in_array($words[$j], $used) == false) {
                                        // $this->write("->type('" . $words[$j] . "', '" . $words[$j + 2] . "') \n \t");
                                        // $this->write($words[$j+2]);
                                        if ($words[$j - 1] == $keys[12]) { //opsi
                                            $this->write("->select('" . $words[$j] . "','" . $words[$j + 1] . "')\n \t");
                                        } else if ($words[$j - 1] == $keys[14]) { //melampirkan
                                            $this->write("->attach('" . $words[$j] . "',base_path('public/images/" . strtolower($namaModel) . "/" . $words[sizeof($words) - 1] . "png'))\n \t");
                                        } else {
                                            $this->write("->type('" . $words[$j] . "', '" . $words[$j + 2] . "') \n \t");
                                        }
                                        array_push($used, $words[$j]);
                                    }
                                }
                            }

                            if (in_array($keys[16], $used) && in_array($keys[17], $used)) {
                                if (in_array($keys[20], $used)) {
                                    if ($namaModel == $keys[19]) { //User dan sudah login
                                        if ($words[$j] == $keys[16] || $words[$j] == $keys[17]) { // email, password, 
                                            $this->write("->type('" . $words[$j] . "', '" . $words[$j + 2] . "') \n \t");
                                        }
                                    }
                                }
                                array_push($used, $keys[20]);
                            }

                            if (in_array($words[$j], $used) == false) { //untuk email dan password jika tidak ada di model
                                if ($words[$j] == $keys[16] || $words[$j] == $keys[17]) { //16 email //17 password
                                    $this->write("->type('" . $words[$j] . "', '" . $words[$j + 2] . "') \n \t");
                                    array_push($used, $words[$j]);
                                }
                            }

                            if ($words[$j] == $keys[6]) { //tombol
                                if (isset($words[$j + 2])) {
                                    $this->write("->press('" . $words[$j + 1] . " " . $words[$j + 2] . "')\n \t");
                                } else {
                                    $this->write("->press('" . $words[$j + 1] . "')\n \t");
                                }
                            } else if ($words[$j] == $keys[11]) { //link
                                $this->write("->clickLink('" . $words[$j + 1] . " " . $words[$j + 2] . "')\n \t");
                            } else if ($words[$j] == $keys[15]) { //mengisi
                                $this->write("->keys('#" . $words[$j + 1] . "','" . $words[$j + 3] . "')\n \t");
                            } else if ($words[$j] == $keys[12]) { //opsi
                                // $this->write("->select('" . $words[$j + 1] . "','" . $words[$j + 2] . "')\n \t");
                            } else if ($words[$j] == $keys[14]) { //melampirkan
                                // $this->write("->attach('" . $words[$j + 1] . "',base_path('public/images/" . strtolower($namaModel) . "/" . $words[sizeof($words) - 1] . "png'))\n \t");
                            } else if ($words[$j] == $keys[18]) { //password_confirmation
                                $this->write("->type('" . $words[$j] . "', '" . $words[$j + 2] . "') \n \t");
                            } else if ($words[$j] == $keys[21]) { //jenis kelamin
                                $this->write("->select('" . $words[$j] . "','" . $words[$j + 2] . "')\n \t");
                            } else if ($words[$j] == $keys[22]) { //menunggu
                                $this->write("->waitForText('" . $words[$j + 3] . " " . $words[$j + 4] . "')\n \t");
                            } else if ($words[$j] == $keys[23]) { //klik
                                $this->write('->click("tr[data-' . $words[$j + 2] . '_' . $words[$j + 1] . "='".$words[$j+3]." ".$words[$j+4]."']".'")'."\n\t");
                            }else if($words[$j] == $keys[24]){ //keterangan
                                $this->write("->type('" . $words[$j] . "', '" . $words[$j + 1] . "') \n \t");
                            }
                        }
                    } else if ($words[$i] == $keys[4]) { //Then
                        for ($j = 0; $j < sizeof($words); $j++) {
                            if ($words[$j] == $keys[7]) { //berhasil
                                $this->write("->assertPathIs('/" . $words[sizeof($words) - 1] . "'); \n \t}); \n} \n \n");
                            } else if ($words[$j] == $keys[8]) { //tulisan
                                $this->write("->assertPathIs('/login'); \n \t}); \n} \n \n");
                            } else if ($words[$j] == $keys[13]) { //atribut
                                $this->write(";});\n \t");
                                $this->write('$this' . "->assertDatabaseHas('" . $words[sizeof($words) - 1] . "',[ \n \t");
                                $this->write("'" . $words[$j + 1] . "' => " . "'" . $words[$j + 2] . "'\n\t");
                                $this->write("]);\n \t \n} \n \n");
                            }
                        }
                    }
                }
            }
        }
        $this->write("}");
    }
}
