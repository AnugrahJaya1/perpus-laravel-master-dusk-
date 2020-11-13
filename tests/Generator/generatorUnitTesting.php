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
$currPath = __DIR__;
$words = preg_split('/\s+/',fgets($fileReader),-1,PREG_SPLIT_NO_EMPTY);
$newFileName = $words[1];
$fileWriter = fopen($currPath.'/'.$newFileName.'Test.php','w');
?>