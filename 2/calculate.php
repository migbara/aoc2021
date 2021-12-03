<?php

//AOC - Day 2
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\2\calculate.php"


function calculate_part1(){

    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $counter = 0;
    $horizontal = 0;
    $depth = 0;

    while(!feof($f)){
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

    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL HORIZONTAL ".$horizontal."\r\n";
    echo "TOTAL DEPTH ".$depth."\r\n";
    echo "RESULT ".$horizontal." x ".$depth." = ".$horizontal*$depth."\r\n"."\r\n";
}

function calculate_part2(){

    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $counter = 0;
    $horizontal = 0;
    $depth = 0;
    $aim = 0;

    while(!feof($f)){
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

    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL HORIZONTAL ".$horizontal."\r\n";
    echo "TOTAL AIM ".$aim."\r\n";
    echo "TOTAL DEPTH ".$depth."\r\n";
    echo "RESULT ".$horizontal." x ".$depth." = ".$horizontal*$depth."\r\n"."\r\n";
}

calculate_part1();
calculate_part2();

