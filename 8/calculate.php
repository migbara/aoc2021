<?php

//AOC - Day 8
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\8\calculate.php"

function getData(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $data = array();
    $cont = 0;
    while(!feof($f)){
        $line = rtrim(fgets($f));

        $parts = explode("|",$line);
        $words = explode(" ",trim($parts[1]));
        $data[$cont]["output"] = array();
        for ($i=0; $i < count($words); $i++) {
            array_push($data[$cont]["output"],$words[$i]);
        }
        
        $data[$cont]["patterns"] = array();
        $words = explode(" ",trim($parts[0]));
        for ($i=0; $i < count($words); $i++) {
            array_push($data[$cont]["patterns"],$words[$i]);
        }
        $cont++;
    }
    return $data;
}

function calculate_part1($data){
    $cont = 0;
    for ($j=0; $j < count($data); $j++) { 
        for ($i=0; $i < count($data[$j]["output"]) ; $i++) {
            $long = strlen($data[$j]["output"][$i]);
            if($long == 2 || $long == 3 || $long == 4 || $long == 7){
                $cont++;
            }
        }
    }
    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "1,4,7 y 8 APPEARS ".$cont." TIMES"."\r\n";
}

function compareStrings($a,$b){
    //return the number of common letters between 2 strings
    $a_arr = str_split($a);
    $b_arr = str_split($b);

    $common = implode(array_unique(array_intersect($a_arr, $b_arr)));
    return strlen($common);
}

function calculate_part2($data){
    //Foreach line we need to know what is the configuration of segments
    $total = 0;
    for ($j=0; $j < count($data); $j++) {
        $pat = array();
        $cad = '';
        for ($i=0; $i < count($data[$j]["patterns"]) ; $i++) {
            $number = $data[$j]["patterns"][$i];
            $long = strlen($number);
            if($long == 2)
                $pat[1] = $number;
            if($long == 3)
                $pat[7] = $number;
            if($long == 4)
                $pat[4] = $number;
            if($long == 7)
                $pat[8] = $number;
        }
        for ($i=0; $i < count($data[$j]["patterns"]) ; $i++) {
            $number = $data[$j]["patterns"][$i];
            $long = strlen($number);
            if($long == 5){
                //if long 5 and has 2 segments in common with 1, is the pattern for number 3
                if(compareStrings($number,$pat[1]) == 2){
                    $pat[3] = $number;
                }
                //if long 5 and has 2 segments in common with 4, is the pattern for number 2
                elseif(compareStrings($number,$pat[4]) == 2){
                    $pat[2] = $number;
                }
                else{
                    $pat[5] = $number;
                }
            }
            if($long == 6){
                //if long 6 and has 1 segment in common with 1, is the pattern for number 6
                if(compareStrings($number,$pat[1]) == 1){
                    $pat[6] = $number;
                }
                //if long 6 and has 4 segments in common with 4, is the pattern for number 9
                elseif(compareStrings($number,$pat[4]) == 4){
                    $pat[9] = $number;
                }
                else{
                    $pat[0] = $number;
                }
            }
        }
        // print_r($pat);
        //Now we know the pattern foreach line
        for ($i=0; $i < count($data[$j]["output"]) ; $i++) {
            foreach($pat as $key => $value){
                $number = $data[$j]["output"][$i];

                // echo $number." ".$value." - BUSCANDO EL ".$key."\r\n";

                if( (compareStrings($number,$value) == strlen($number))  && (strlen($number) == strlen($value)) ){
                    // echo $number." ".$value." - ENCONTRADO EL ".$key."\r\n";
                    $cad .= $key;
                }
            }
        }
        // echo $cad."\r\n";
        $total += $cad;
    }
    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL ".$total."\r\n";
}

$data = getData();
// print_r($data);
calculate_part1($data);
calculate_part2($data);

