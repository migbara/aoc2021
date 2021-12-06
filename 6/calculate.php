<?php

//AOC - Day 6
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\6\calculate.php"




function getData(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $fishes = array();
    while(!feof($f)){
        $line = rtrim(fgets($f));
        $fishes = explode(",",$line);
    }
    return $fishes;
}

function getDataAmount(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $data = array();
    while(!feof($f)){
        $line = rtrim(fgets($f));
        $data = explode(",",$line);
    }
    $fishes = array();
    for ($i=0; $i <= 9; $i++) { 
        $fishes[$i] = 0;
    }
    for ($i=0; $i < count($data); $i++) { 
        $fishes[$data[$i]]++;
    }
    return $fishes;
}

function calculate_array_method($fishes){
    $time = 80;
    // $t1 = microtime();
    //echo sprintf("%-2d",0)." ".implode(",",$fishes)."\r\n";
    for ($i=1; $i <= $time ; $i++) { 
        for ($j=0; $j < count($fishes); $j++) { 
            if($fishes[$j]!=0)
                $fishes[$j]--;
            else{
                $fishes[$j]=6;
                array_push($fishes,9);
            }
        }
        //echo sprintf("%-2d",$i)." ".implode(",",$fishes)."\r\n";
    }
    // $t2 = microtime();
    // echo ($t2*1000 - $t1*1000)." ms"."\r\n";
    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "NUMBER LANTERNFISH: ".count($fishes)."\r\n";
}

function calculate_part1($fishes){
    $time = 80;
    //$t1 = microtime();
    //echo sprintf("%-2d",0)." ".implode(",",$fishes)."\r\n";
    for ($i=1; $i <= $time ; $i++) { 
        //for 0 pass to be 6, and add the same quantity to 8 temporaly
        $fishes_new = array();
        $fishes_new[0] = $fishes[1];
        $fishes_new[1] = $fishes[2];
        $fishes_new[2] = $fishes[3];
        $fishes_new[3] = $fishes[4];
        $fishes_new[4] = $fishes[5];
        $fishes_new[5] = $fishes[6];
        $fishes_new[6] = $fishes[0] + $fishes[7];
        $fishes_new[7] = $fishes[8];
        $fishes_new[8] = $fishes[0];
        $fishes = $fishes_new;
    }
    $cont = 0;
    for ($i=0; $i < count($fishes); $i++) { 
        $cont += $fishes[$i];
    }
    //$t2 = microtime();
    //echo ($t2*1000 - $t1*1000)." ms"."\r\n";
    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "NUMBER LANTERNFISH: ".$cont."\r\n";
}

function calculate_part2($fishes){
    $time = 256;
    //$t1 = microtime();
    //echo sprintf("%-2d",0)." ".implode(",",$fishes)."\r\n";
    for ($i=1; $i <= $time ; $i++) { 
        //for 0 pass to be 6, and add the same quantity to 8 temporaly
        $fishes_new = array();
        $fishes_new[0] = $fishes[1];
        $fishes_new[1] = $fishes[2];
        $fishes_new[2] = $fishes[3];
        $fishes_new[3] = $fishes[4];
        $fishes_new[4] = $fishes[5];
        $fishes_new[5] = $fishes[6];
        $fishes_new[6] = $fishes[0] + $fishes[7];
        $fishes_new[7] = $fishes[8];
        $fishes_new[8] = $fishes[0];
        $fishes = $fishes_new;
    }
    $cont = 0;
    for ($i=0; $i < count($fishes); $i++) { 
        $cont += $fishes[$i];
    }
    //$t2 = microtime();
    //echo ($t2*1000 - $t1*1000)." ms"."\r\n";
    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "NUMBER LANTERNFISH: ".$cont."\r\n";
}

//$fishes = getData();
//calculate_array_method($fishes);

//it's more important the amount than data itself, so we changed the input and the method to calculate. It's impossible use an array so big

//$fishes = array("0"=>0,"1"=>1,"2"=>1,"3"=>2,"4"=>1,"5"=>0,"6"=>0,"7"=>0,"8"=>0);
$fishes = getDataAmount();
print_r($fishes);
calculate_part1($fishes);

$fishes = getDataAmount();
print_r($fishes);
calculate_part2($fishes);