<?php

//AOC - Day 16
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\16\calculate.php"

//help - https://vikithedev.eu/aoc/2021/16/

function getData(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $data = array();
    while(!feof($f)){
        $line = rtrim(fgets($f));
        $row = str_split(rtrim($line));
        //array_push($data,$row);
        $data = $row;
    }
    return $data;
}

function convertBinary($data){
    $conv = array("0"=>"0000","1"=>"0001","2"=>"0010","3"=>"0011","4"=>"0100","5"=>"0101","6"=>"0110","7"=>"0111","8"=>"1000","9"=>"1001","A"=>"1010","B"=>"1011","C"=>"1100","D"=>"1101","E"=>"1110","F"=>"1111");
    $res = '';
    foreach($data as $k => $h){
        // echo $h."\r\n";
        $res .= $conv[$h];
    }
    return $res;
}

function readData(&$cad,$n='',$long=0){
    $packets = array();

    if($long>0){
        $allcad = $cad;
        $cad = substr($cad,0,$long);
    }

    while(($n=='' || $n>0) && strlen($cad)>0 && trim($cad,"0")!=''){

        $pos = 0;
        
        $v = substr($cad,$pos,3);
        $pos += 3;
        $t = substr($cad,$pos,3);
        $pos += 3;

        $vdec = bindec($v);

        $packet = array("cad"=>$cad,"v"=>$v,"vdec"=>$vdec,"t"=>$t);

        $b = '';
        $dec = '';
        $length = '';
        $operator = '';
        $indicator = '';

        $numbers = array();

        if($t == "100"){
            //literal

            $length = 0;
            $start = 6;
            $size = 5;
            $p = substr($cad,$start,$size);
            $pos += $size;
            $cont = 0;
            //add numbers starting with 1
            while(substr($p,0,1)!='0'){
                $numbers[] = substr($p,1);
                $start += $size;
                $p = substr($cad,$start,$size);
                $pos+=$size;
            }
            //add packet starting with 0
            $numbers[] = substr($p,1);

            $b = implode("",$numbers);

            $dec = bindec($b);

            $packet["numbers"] = $numbers;
            $packet["bin"] = $b;
            $packet["dec"] = $dec;

            $packets[] = $packet;

            $cad = substr($cad,$pos);
        }
        else{
            //operator
            $indicator = substr($cad,$pos,1);
            $pos+=1;
            
            if($indicator=='0'){
                $nbits = 15;

                $length_bin = substr($cad,$pos,$nbits);
                $pos+=$nbits;
                $length = bindec($length_bin);
                $npackets = '';
            }
            else{
                $nbits = 11;

                $num_subpackets_bin = substr($cad,$pos,$nbits);
                $pos+=$nbits;

                $npackets = bindec($num_subpackets_bin);
            }

            
            


            $ncad = substr($cad,$pos);

            if(($t=='101' || $t=='110' || $t=='111')){
                $npackets=2;
            }

            $operator = readData($ncad,$npackets,$length);

            if($packet["t"]=='000') $packet["dec"] = 0;
            if($packet["t"]=='001') $packet["dec"] = 1;
            if($packet["t"]=='010') $packet["dec"] = PHP_INT_MAX;
            if($packet["t"]=='011') $packet["dec"] = 0;
            if($packet["t"]=='101') $packet["dec"] = 0;
            if($packet["t"]=='110') $packet["dec"] = 0;
            if($packet["t"]=='111') $packet["dec"] = 0;

            foreach($operator as $p){
                $dec = $p["dec"];
                if($packet["t"]=='000'){
                    $packet["operation"] = 'SUM';
                    $packet["dec"] += $dec; 
                }
                if($packet["t"]=='001'){
                    $packet["operation"] = 'PRODUCT';
                    $packet["dec"] *= $dec; 
                }
                if($packet["t"]=='010'){
                    $packet["operation"] = 'MINIMUM';
                    if($dec < $packet["dec"])
                        $packet["dec"] = $dec;
                }
                if($packet["t"]=='011'){
                    $packet["operation"] = 'MAXIMUM';
                    if($dec > $packet["dec"])
                        $packet["dec"] = $dec;
                }
                if($packet["t"]=='101'){
                    $packet["operation"] = 'GREATER';
                    if(isset($dec_ant) && $dec < $dec_ant)
                        $packet["dec"] = 1; 
                }
                if($packet["t"]=='110'){
                    $packet["operation"] = 'LESS';
                    if(isset($dec_ant) && $dec > $dec_ant)
                        $packet["dec"] = 1; 
                }
                if($packet["t"]=='111'){
                    $packet["operation"] = 'EQUAL';
                    if(isset($dec_ant) && $dec == $dec_ant)
                        $packet["dec"] = 1; 
                }
                $dec_ant = $dec;
            }

            $packet["length"] = $length;
            $packet["indicator"] = $indicator;
            $packet["operator"] = $operator;

            $packets[] = $packet;

            $cad = $ncad;
            $pos = 0;

        }
        
        if($n>0)
            $n--;

    }

    if(isset($allcad))
        $cad = substr($allcad,$long);
    
    return $packets;
}

function addVersions($data){
    $sum = 0;
    foreach($data as $v){
        $sum += $v["vdec"];
        if(isset($v["operator"]))
            $sum += addVersions($v["operator"]);
    }
    return $sum;
}



// function pinta($data,$esp=''){
//     $cad = '';
//     foreach($data as $p){
//         if(isset($p["operation"])){
//         // foreach($data as $p){
//             $cad .= $p["operation"]." ".$p["dec"]."\r\n";
//             $cad .= pinta($p["operator"],$esp.' ');
//         }
//         else{
//             $cad .= "VALUE ".$p["dec"]."\r\n";
//         }
//     }
//     return $cad;
// }

$data = getData();

// print_r($data);

function calculate_part1($data){

    $t1 = microtime(true);
    $binary = convertBinary($data);

    // echo $binary."\r\n";

    $data = readData($binary);

    // print_r($data);

    $sum = addVersions($data);

    $t2 = microtime(true);

    echo "PART 1"."\r\n";
    echo "TIME TO PROCESS ".($t2 - $t1)." s"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "ADD VERSIONS ".$sum."\r\n";
}

function calculate_part2($data){

    $t1 = microtime(true);
    $binary = convertBinary($data);

    // echo $binary."\r\n";

    $data = readData($binary);

    // print_r($data);

    $sum = addVersions($data);

    $t2 = microtime(true);

    // echo pinta($data);

    echo "PART 2"."\r\n";
    echo "TIME TO PROCESS ".($t2 - $t1)." s"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "RESULT ".$data[0]["dec"]." OPERATION ".$data[0]["operation"]."\r\n";
}



calculate_part1($data);
calculate_part2($data);








