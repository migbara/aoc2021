<?php

//AOC - Day 7
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\7\calculate.php"

function getData(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $positions = array();
    while(!feof($f)){
        $line = rtrim(fgets($f));
        $positions = explode(",",$line);
    }
    return $positions;
}

function calculate_part1($positions){
    //max and min values
    $max = max($positions);
    $min = min($positions);
    // echo $max." ".$min."\r\n";

    $m = 99999999999;
    for ($i=$min; $i <= $max ; $i++) {
        $sum = 0;
        for ($j=0; $j < count($positions); $j++) {
            $sum += abs($positions[$j] - $i);
            // echo $j." ".$i." ".abs($positions[$j] - $i)." ".$sum."\r\n";
        }
        if($sum < $m){
            $m = $sum;
            $pos = $i;
        }
    }
    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "LEAST FUEL ".$m." POSITION ".$pos."\r\n";
}

function calculate_part2($positions){
    //max and min values
    $max = max($positions);
    $min = min($positions);
    // echo $max." ".$min."\r\n";

    $m = 99999999999;
    for ($i=$min; $i <= $max ; $i++) {
        $sum = 0;
        for ($j=0; $j < count($positions); $j++) {
            $dif = abs($positions[$j] - $i);
            for ($k=$dif; $k >= 1; $k--) { 
                $sum += $k;
            }
            // echo $j." ".$i." ".abs($positions[$j] - $i)." ".$sum."\r\n";
        }
        if($sum < $m){
            $m = $sum;
            $pos = $i;
        }
    }
    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "LEAST FUEL ".$m." POSITION ".$pos."\r\n";
}

$positions = getData();
// print_r($positions);
calculate_part1($positions);
calculate_part2($positions);
