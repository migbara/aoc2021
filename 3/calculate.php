<?php

//AOC - Day 2
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\2\calculate.php"

//input data
$url = "https://adventofcode.com/2021/day/3/input";

//enable these sentences in php.ini
//  extension_dir = ext
//  extension=openssl

//This is a helpful code for checking wrappers and openssl extension
$w = stream_get_wrappers();
echo 'openssl: ',  extension_loaded  ('openssl') ? 'yes':'no', "\n";
echo 'http wrapper: ', in_array('http', $w) ? 'yes':'no', "\n";
echo 'https wrapper: ', in_array('https', $w) ? 'yes':'no', "\n";
echo 'wrappers: ', var_dump($w);

function calculate_part1(){

    //1 - Read from a file
    $file = "C:\\Miguel Barahona\\Personal\\aoc_2021\\3\\input.txt";
    $f = fopen($file,"r");

    //2 - Read from remote url
    //$f = file_get_contents($url);

    $counter = 0;
    $columns = array();

    //while(!feof($f)){ // FOR TEST && $counter<10){
    while(!feof($f) && $counter<100000){
        $counter++;
        $line = fgets($f);
        $data = str_split(rtrim($line));

        // print_r($data);

        //for each column, we must known if has more 1 than 0
        for ($i=0; $i < count($data) ; $i++) {
            if($counter==1)
                $columns[$i] = array("0"=>0,"1"=>0);
            if($data[$i]==0)
                $columns[$i]["0"]++;
            if($data[$i]==1)
                $columns[$i]["1"]++;    
            //array_push($columns[$i],$data[$i]);

        }
    }

    print_r($columns);

    $gamma = '';
    $epsilon = '';

    foreach($columns as $key => $value){
        if($value["0"] > $value["1"]){
            $gamma .= "0";
            $epsilon .= "1";
        }
        else{
            $gamma .= "1";
            $epsilon .= "0";
        }

    }

    $gamma_dec = bindec($gamma);
    $epsilon_dec = bindec($epsilon);

    echo "GAMMA ".$gamma."\r\n";
    echo "EPSILON ".$epsilon."\r\n";
    echo "GAMMA DEC ".$gamma_dec."\r\n";
    echo "EPSILON DEC ".$epsilon_dec."\r\n";
    echo "POWER CONSUMPTION ".$gamma_dec * $epsilon_dec."\r\n";
}



calculate_part1();
//calculate_part2();

