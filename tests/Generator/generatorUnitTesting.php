<?php

$dir="./Gherkin/";
$namaFile = $argv[1];
// cara panggil : php tests/Generator/generatorUnitTesting.php login
// untuk membaca file
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            $str = "filename: $file : filetype: " . filetype($dir . $file) . "\n";
            
            // cek kesamaan kata dari argumen dan nama file
            if(similar_text($file,$namaFile)>=5){
                $fileReader = fopen($dir.$file,'r');
                system("echo ".$file);
                break;
            }
        }
        closedir($dh);
    }
}

// system("echo ".fgets($fileReader));


// membuat file baru file generator

// $currPath ="../Browser";
$words = preg_split('/\s+/',fgets($fileReader),-1,PREG_SPLIT_NO_EMPTY);
$folderName = $words[1];
$newFileName = $words[2];

//dir untuk folder
$dir =dirname(__DIR__).'/Browser/'.$folderName;

if( is_dir($dir) === false )
{
    mkdir($dir);
}

// membuat file
$fileWriter = fopen($dir.'/'.$newFileName.'Test.php','w');


// tulis ke file
fwrite($fileWriter,"<?php\n");
fwrite($fileWriter,"namespace Tests\Browser;\n \n");

fwrite($fileWriter,"use Tests\DuskTestCase;\n");
fwrite($fileWriter,"use Laravel\Dusk\Browser;\n");
fwrite($fileWriter,"use Illuminate\Foundation\Testing\DatabaseMigrations;\n \n");

fwrite($fileWriter,"class ".$newFileName."Test"." extends DuskTestCase { \n \n");

$keys =["Scenario:", "Given", "When", "And", "Then"];


$banyakTest=1;
$status="";


if($fileReader){
    while (($line = fgets($fileReader)) !== false) {
        $words = preg_split('/\s+/',$line,-1,PREG_SPLIT_NO_EMPTY);
        // system("echo ".$words[0]);
        
        // idx untuk words
        for($i = 0; $i < sizeof($words); $i++){
            if($words[$i]==$keys[0]){ // Scenario:
                fwrite($fileWriter,"public function testUnit".$banyakTest."(){\n \t");
                fwrite($fileWriter, '$this->browse(function (Browser $browser)'. "{\n \t");
                $banyakTest=$banyakTest+1;
                $status=$words[$i+2];

            } else if($words[$i]==$keys[1]){ // Given
                for($j = 0; $j<sizeof($words); $j++){
                    if($words[$j]=="halaman"){
                        fwrite($fileWriter, '$browser->visit('."'/".$words[$j+1]."') \n \t");
                    }
                }
            } else if($words[$i]==$keys[2]){ // When
                for($j = 0; $j<sizeof($words); $j++){
                    if($words[$j]=="username"){
                        fwrite($fileWriter, "->type('email','".$words[$j+2]."') \n \t");
                    }
                }
            } else if($words[$i]==$keys[3]){ //And
                for($j = 0; $j<sizeof($words); $j++){
                    if($words[$j]=="password"){
                        fwrite($fileWriter, "->type('".$words[$j]."', '".$words[$j+2]."') \n \t");
                    } else if($words[$j]=="tombol"){
                        fwrite($fileWriter, "->press('Login')\n \t");
                    }
                }
            } else if($words[$i]==$keys[4]){ //Then
                for($j = 0; $j<sizeof($words); $j++){
                    if($words[$j]=="berhasil"){
                        fwrite($fileWriter, "->assertPathIs('/home'); \n \t}); \n} \n \n");
                    }else if($words[$j]=="tulisan"){
                        fwrite($fileWriter, "->assertPathIs('/login'); \n \t}); \n} \n \n");
                    }
                }
            }

        }
    }
}

fwrite($fileWriter,"}");
?>