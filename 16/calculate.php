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

function readData(&$cad,$n=''){
    $packets = array();
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

                //$length = bindec($num_subpackets_bin) * $nbits;
                $npackets = bindec($num_subpackets_bin);
            }

            
            $ncad = substr($cad,$pos);
            //$pos+=$length;

            

            // echo "NUEVA CADENA ".$ncad."\r\n";
            $operator = readData($ncad,$npackets);

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

        }
        
        if($n>0)
            $n--;

    }

    
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

// function calculate($data){
//     $res0 = 0;
//     $res1 = 1;
//     $res2 = PHP_INT_MAX;
//     $res3 = 0;
//     $res5 = 0;
//     $res6 = 0;
//     $res7 = 0;

//     $cont = 0;
//     foreach($data as $v){
//         if(isset($v["dec"])){

//             echo "DEC ".$v["dec"]."\r\n";


//             $res0 += $v["dec"];
//             $res1 *= $v["dec"];

            
            
//             if($v["dec"]<$res2)
//                 $res2 = $v["dec"];
//             echo "010 " . $res2."\r\n";

//             if($v["dec"]>$res3)
//                 $res3 = $v["dec"];
//             echo "011 " . $res3."\r\n";

//             if($cont==0){
//                 $res5_ant = $v["dec"];
//                 $res6_ant = $v["dec"];
//                 $res7_ant = $v["dec"];
//             }
//             if($cont>0 && $v["dec"]>$res5_ant)
//                 $res5 = 1;
//             echo "101 " . $res5."\r\n";
//             if($cont>0 && $v["dec"]<$res6_ant)
//                 $res6 = 1;
//             echo "110 " . $res6."\r\n";
//             if($cont>0 && $v["dec"]==$res7_ant)
//                 $res7 = 1;
//             echo "111 " . $res7."\r\n";
//         }
//         if($v["t"]=='000'){
//             //sum packets
//             if(isset($v["operator"])){
//                 $c= calculate($v["operator"]);
//                 $res0 += $c["res0"];
//             }
//         }
//         if($v["t"]=='001'){
//             //product packets
//             if(isset($v["operator"])){
//                 $c= calculate($v["operator"]);
//                 $res1 *= $c["res1"];
//             }
//         }
//         if($v["t"]=='010'){
//             //minimum packets
//             if(isset($v["operator"])){
//                 $c= calculate($v["operator"]);
//                 // echo "010 " . $c["res2"]."\r\n";
//                 if($c["res2"]<$res2)
//                     $res2 = $c["res2"];
//             }
//         }
//         if($v["t"]=='011'){
//             //minimum packets
//             if(isset($v["operator"])){
//                 $c= calculate($v["operator"]);
//                 echo "011 " . $c["res3"]."\r\n";
//                 if($c["res3"]>$res3)
//                     $res3 = $c["res3"];
//             }
//         }
//         if($v["t"]=='101'){
//             //greater than packets
//             if(isset($v["operator"])){
//                 $c= calculate($v["operator"]);
//                 echo "101 " . $c["res5"]."\r\n";
//                 $res5 = $c["res5"];
//             }
//         }
//         if($v["t"]=='110'){
//             //greater than packets
//             if(isset($v["operator"])){
//                 $c= calculate($v["operator"]);
//                 echo "110 " . $c["res6"]."\r\n";
//                 $res6 = $c["res6"];
//             }
//         }
//         if($v["t"]=='111'){
//             //greater than packets
//             if(isset($v["operator"])){
//                 $c= calculate($v["operator"]);
//                 echo "111 " . $c["res7"]."\r\n";
//                 $res7 = $c["res7"];
//             }
//         }
//         $cont++;
//     }
//     return ["res0"=>$res0,"res1"=>$res1,"res2"=>$res2,"res3"=>$res3,"res5"=>$res5,"res6"=>$res6,"res7"=>$res7];
// }

function pinta($data,$esp=''){
    $cad = '';
    foreach($data as $p){
        if(isset($p["operation"])){
        // foreach($data as $p){
            $cad .= $p["operation"]." ".$p["dec"]."\r\n";
            $cad .= pinta($p["operator"],$esp.' ');
        }
        else{
            $cad .= "VALUE ".$p["dec"]."\r\n";
        }
    }
    return $cad;
}

$data = getData();

// print_r($data);

$binary = convertBinary($data);

echo $binary."\r\n";

$data = readData($binary);

// print_r($data);

$sum = addVersions($data);

echo "SUMA ".$sum."\r\n";

echo pinta($data);




echo "RESULT ".$data[0]["dec"]." OPERATION ".$data[0]["operation"]."\r\n";

// $res = calculate($data);

// echo "RES0 ".$res["res0"]." RES1 ".$res["res1"]." RES2 ".$res["res2"]." RES3 ".$res["res3"]." RES5 ".$res["res5"]." RES6 ".$res["res6"]." RES7 ".$res["res7"]."\r\n";

// calculate_part1($data);
// calculate_part2($data);








