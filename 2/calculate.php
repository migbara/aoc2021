<?php

//AOC - Day 2
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\2\calculate.php"

//input data
$url = "https://adventofcode.com/2021/day/2/input";

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
    $file = "C:\\Miguel Barahona\\Personal\\aoc_2021\\2\\input.txt";
    $f = fopen($file,"r");

    //2 - Read from remote url
    //$f = file_get_contents($url);

    $counter = 0;
    $horizontal = 0;
    $depth = 0;

    while(!feof($f)){ // FOR TEST && $counter<10){
        $counter++;
        $line = fgets($f);
        $data = rtrim($line);
        $data = explode(" ",$data);

        switch ($data[0]) {
            case 'forward':
                $horizontal += $data[1];
                break;
            case 'down':
                $depth += $data[1];
                break;
            case 'up':
                $depth -= $data[1];
                break;
            
            default:
                break;
        }
    }

    echo "TOTAL HORIZONTAL ".$horizontal."\r\n";
    echo "TOTAL DEPTH ".$depth."\r\n";
    echo "RESULT ".$horizontal." x ".$depth." = ".$horizontal*$depth."\r\n"."\r\n";
}

function calculate_part2(){

    //1 - Read from a file
    $file = "C:\\Miguel Barahona\\Personal\\aoc_2021\\2\\input.txt";
    $f = fopen($file,"r");

    //2 - Read from remote url
    //$f = file_get_contents($url);

    $counter = 0;
    $horizontal = 0;
    $depth = 0;
    $aim = 0;

    while(!feof($f)){ // FOR TEST && $counter<10){
        $counter++;
        $line = fgets($f);
        $data = rtrim($line);
        $data = explode(" ",$data);

        switch ($data[0]) {
            case 'forward':
                $horizontal += $data[1];
                $depth += $aim * $data[1];
                break;
            case 'down':
                $aim += $data[1];
                break;
            case 'up':
                $aim -= $data[1];
                break;
            
            default:
                break;
        }
    }

    echo "TOTAL HORIZONTAL ".$horizontal."\r\n";
    echo "TOTAL AIM ".$aim."\r\n";
    echo "TOTAL DEPTH ".$depth."\r\n";
    echo "RESULT ".$horizontal." x ".$depth." = ".$horizontal*$depth."\r\n"."\r\n";
}

calculate_part1();
calculate_part2();

