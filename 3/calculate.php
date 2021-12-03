<?php

//AOC - Day 3
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\3\calculate.php"


function calculate_part1(){

    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $counter = 0;
    $columns = array();

    while(!feof($f)){ // FOR TEST && $counter<10){
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
        }
    }

    // print_r($columns);

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

    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "GAMMA ".$gamma."\r\n";
    echo "EPSILON ".$epsilon."\r\n";
    echo "GAMMA DEC ".$gamma_dec."\r\n";
    echo "EPSILON DEC ".$epsilon_dec."\r\n";
    echo "POWER CONSUMPTION ".$gamma_dec * $epsilon_dec."\r\n";
}


function findValue ($dataset,$criteria){

    $pos = 0;
    $columns = array();

    while (count($dataset)>1){

        for ($k=0; $k < count($dataset) ; $k++) { 
            
        
            $data = str_split($dataset[$k]);


            //print_r($data);

            //for each column, we must known if has more 1 than 0
            for ($i=0; $i < count($data) ; $i++) {
                if($k==0)
                    $columns[$i] = array("0"=>0,"1"=>0);
                if($data[$i]==0)
                    $columns[$i]["0"]++;
                if($data[$i]==1)
                    $columns[$i]["1"]++;    
            }

        }

        // print_r($columns);

        if($criteria==1){
            $bit = 0;
            if($columns[$pos]["1"]>=$columns[$pos]["0"]){
                $bit = 1;
            }
        }
        else{
            $bit = 1;
            if($columns[$pos]["0"]<=$columns[$pos]["1"]){
                $bit = 0;
            }
        }

        // echo $bit;

        $temp = array();
        for ($j=0; $j < count($dataset); $j++) { 
            if($dataset[$j][$pos]==$bit)
                array_push($temp,$dataset[$j]);
        }
        $dataset = $temp;
        $pos++;

        // print_r($dataset);

    }
    return $dataset[0];

}

function calculate_part2(){

    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $counter = 0;
    
    $dataset = array();

    while(!feof($f)){
        $counter++;
        $line = rtrim(fgets($f));
        
        array_push($dataset,$line);
    }

    // print_r($dataset);

    // print_r($columns);

    
    $oxygen = findValue($dataset,1);
    $co2 = findValue($dataset,0);
    
    $oxygen_dec = bindec($oxygen);
    $co2_dec = bindec($co2);
    
    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "OXYGEN ".$oxygen."\r\n";
    echo "CO2 ".$co2."\r\n";
    echo "OXYGEN DEC ".$oxygen_dec."\r\n";
    echo "CO2 DEC ".$co2_dec."\r\n";
    echo "LIFE SUPPORT RATING ".$oxygen_dec * $co2_dec."\r\n";
}



calculate_part1();
calculate_part2();

