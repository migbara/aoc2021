<?php

//AOC - Day 1
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\1\calculate.php"

//1 - Read from a file
$file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
$f = fopen($file,"r");

$ant = '';
$ant2 = '';
$cont_increased = 0;
$cont_decreased = 0;
$cont_equals = 0;

$cont_increased_group = 0;
$cont_decreased_group = 0;
$cont_equals_group = 0;

$sum_act = 0;
$sum_prev = 0;

$counter = 0;

while(!feof($f)){ // FOR TEST && $counter<10){
    $counter++;
    $line = fgets($f);
    $n = rtrim($line);

    if($ant!=''){
        
        //for individual values
        if($n > $ant){
            $cont_increased++;
        }
        elseif($n < $ant){
            $cont_decreased++;
        }
        else{
            $cont_equals++;
        }
        
        //for three-group values
        if($ant2!=''){
            $sum_act = $n + $ant + $ant2;


            // echo "act : ".$n." - ";
            // echo "prev: ".$ant." - ";
            // echo "prev2: ".$ant2."\r\n";
            // echo "SUM ACT : ".$sum_act." - ";
            // echo "SUM PREV: ".$sum_prev."\r\n";

            if($sum_prev>0){
                if($sum_act > $sum_prev){
                    $cont_increased_group++;
                }
                elseif($sum_act < $sum_prev){
                    $cont_decreased_group++;
                }
                else{
                    $cont_equals_group++;
                }
            }

            $sum_prev = $sum_act;
        }
    }
    $ant2 = $ant;
    $ant = $n;
}
echo "PART 1"."\r\n";
echo "---------------------------------------"."\r\n";
echo "TOTAL INCREASED ".$cont_increased."\r\n";
echo "TOTAL DECREASED ".$cont_decreased."\r\n";
echo "TOTAL EQUALS ".$cont_equals."\r\n"."\r\n";
echo "PART 2"."\r\n";
echo "---------------------------------------"."\r\n";
echo "TOTAL INCREASED GROUP ".$cont_increased_group."\r\n";
echo "TOTAL DECREASED GROUP ".$cont_decreased_group."\r\n";
echo "TOTAL EQUALS GROUP ".$cont_equals_group."\r\n"."\r\n";

