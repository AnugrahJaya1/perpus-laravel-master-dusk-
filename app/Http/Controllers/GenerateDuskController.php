<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use Illuminate\Support\Facades\App as FacadesApp;

class GenerateDuskController extends Controller
{
    private $dir, $newDir, $fileWriter;

    public function __construct()
    {
        $this->dir = "..\\Gherkin\\";
        $this->newDir = '..\\..\\..\\tests/Browser\\';
    }

    public function bacaFileHeader($namaFile)
    {
        $header = [];
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
        $namaModel = $words[3];
        array_push($header, $namaModel);

        return $header;
    }

    public function buatFolder($folderName, $fileName)
    {
        $dir = dirname(__DIR__) . $this->newDir . $folderName;

        if (is_dir($dir) === false) {
            mkdir($dir);
        }

        $this->fileWriter = fopen($dir . '/' . $fileName . 'Test.php', 'w');
    }

    public function getFileWriter()
    {
        return $this->fileWriter;
    }

    public function writeBody($fileWriter, $newFileName, $fileReader, $namaModel)
    {
        //header body
        fwrite($fileWriter, "<?php\n");
        fwrite($fileWriter, "namespace Tests\Browser;\n \n");

        fwrite($fileWriter, "use Tests\DuskTestCase;\n");
        fwrite($fileWriter, "use Laravel\Dusk\Browser;\n");
        fwrite($fileWriter, "use Illuminate\Foundation\Testing\DatabaseMigrations;\n \n");

        fwrite($fileWriter, "class " . $newFileName . "Test" . " extends DuskTestCase { \n \n");

        // atribut bantuan
        $keys = ["Scenario:", "Given", "When", "And", "Then"];

        $class = "Class".$namaModel;
        

        $model = "App\\".$namaModel;
        $m = new $model;
        $fillable = $m->getFillable();
        
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
        
    }
}
