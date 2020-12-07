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

    private function write($text)
    {
        fwrite($this->fileWriter, $text);
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
        $keys = ["Scenario:", "Given", "When", "And", "Then", "halaman", "tombol", "berhasil", "tulisan"];

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
                        }
                    } else if ($words[$i] == $keys[2] || $words[$i] == $keys[3]) { // When
                        for ($j = 0; $j < sizeof($words); $j++) {
                            foreach ($fillable as $atr) {
                                if ($words[$j] == $atr) {
                                    if (in_array($words[$j], $used) == false) {
                                        $this->write("->type('" . $words[$j] . "', '" . $words[$j + 2] . "') \n \t");
                                        array_push($used, $words[$j]);
                                    }
                                }
                            }
                            if ($words[$j] == $keys[6]) { //tombol
                                $this->write("->press('Login')\n \t");
                            }
                        }
                    } else if ($words[$i] == $keys[4]) { //Then
                        for ($j = 0; $j < sizeof($words); $j++) {
                            if ($words[$j] == $keys[7]) { //berhasil
                                $this->write("->assertPathIs('/home'); \n \t}); \n} \n \n");
                            } else if ($words[$j] == $keys[8]) { //tulisan
                                $this->write("->assertPathIs('/login'); \n \t}); \n} \n \n");
                            }
                        }
                    }
                }
            }
        }
        $this->write("}");
    }
}
