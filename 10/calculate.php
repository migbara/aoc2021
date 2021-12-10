<?php

//AOC - Day 10
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\10\calculate.php"

function getData(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $row = array();

    $data = array();
    while(!feof($f)){
        $line = rtrim(fgets($f));
        $arr = str_split(rtrim($line));
        array_push($data,$arr);
    }
    return $data;
}

function checkLine($s){
    //review stack comparing chars open and close
}


function calculate_part1($lines){
    $illegal_chars = array();
    //fill stack
    for ($i=0; $i < count($lines); $i++) { 
        $stack = array();
        $ok = true;
        for ($j=0; $j < count($lines[$i]); $j++) { 
            if($ok){
                $c = $lines[$i][$j];
                // echo $c."\r\n";
                if($c == "[" || $c == "(" || $c == "{" || $c == "<")
                    array_push($stack,$c);
                else{
                    //if is a close char, compare with the last added at stack
                    $s = $stack[count($stack)-1];
                    // echo "END STACK ".$s."\r\n";
                    if($c == "]"){
                        if($s == "["){
                            //if is pairing, dont add and remove the last
                            array_pop($stack);
                        }
                        else{
                            array_push($illegal_chars,$c);
                            $ok = false;
                        }
                    }
                    elseif($c == ")"){

                        if($s == "("){
                            //if is pairing, dont add and remove the last
                            array_pop($stack);
                        }
                        else{
                            array_push($illegal_chars,$c);
                            $ok = false;
                        }
                    }
                    elseif($c == "}"){

                        if($s == "{"){
                            //if is pairing, dont add and remove the last
                            array_pop($stack);
                        }
                        else{
                            array_push($illegal_chars,$c);
                            $ok = false;
                        }
                    }
                    elseif($c == ">"){

                        if($s == "<"){
                            //if is pairing, dont add and remove the last
                            array_pop($stack);
                        }
                        else{
                            array_push($illegal_chars,$c);
                            $ok = false;
                        }
                    }
                }
            }
            else{
                //for end the loop
                $j = count($lines[$i]);
            }
        }
    }
    // print_r($illegal_chars);
    $points = array(")"=>3,"]"=>57,"}"=>1197,">"=>25137);
    $total = 0;
    foreach($illegal_chars as $char){
        $total += $points[$char];
    }
    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL ".$total."\r\n";
}


function calculate_part2($lines){
    $completeLines = array();
    $corrupted = array();

    //fill stack
    for ($i=0; $i < count($lines); $i++) { 
        $stack = array();
        $ok = true;
        for ($j=0; $j < count($lines[$i]); $j++) { 
            if($ok){
                $c = $lines[$i][$j];
                // echo $c."\r\n";
                if($c == "[" || $c == "(" || $c == "{" || $c == "<")
                    array_push($stack,$c);
                else{
                    //if is a close char, compare with the last added at stack
                    $s = $stack[count($stack)-1];
                    // echo "END STACK ".$s."\r\n";
                    if($c == "]"){
                        if($s == "["){
                            //if is pairing, dont add and remove the last
                            array_pop($stack);
                        }
                        else{
                            array_push($corrupted,$i);
                            $ok = false;
                        }
                    }
                    elseif($c == ")"){

                        if($s == "("){
                            //if is pairing, dont add and remove the last
                            array_pop($stack);
                        }
                        else{
                            array_push($corrupted,$i);
                            $ok = false;
                        }
                    }
                    elseif($c == "}"){

                        if($s == "{"){
                            //if is pairing, dont add and remove the last
                            array_pop($stack);
                        }
                        else{
                            array_push($corrupted,$i);
                            $ok = false;
                        }
                    }
                    elseif($c == ">"){

                        if($s == "<"){
                            //if is pairing, dont add and remove the last
                            array_pop($stack);
                        }
                        else{
                            array_push($corrupted,$i);
                            $ok = false;
                        }
                    }
                }
            }
            else{
                //for end the loop
                $j = count($lines[$i]);
            }
        }

        //now, the lines not corrupted, or stack is empty (all ok) or need a string to finish
        $complete = array();
        while(count($stack)>0 && !in_array($i,$corrupted)){
            $s = $stack[count($stack)-1];
            if($s == "["){
                array_push($complete,"]");
            }
            if($s == "("){
                array_push($complete,")");
            }
            if($s == "{"){
                array_push($complete,"}");
            }
            if($s == "<"){
                array_push($complete,">");
            }
            array_pop($stack);
        }
        if(count($complete)){
            array_push($completeLines,$complete);
        }
    }
    // print_r($corrupted);
    // print_r($completeLines);

    $cont = count($completeLines);
    $num = 5;

    $points = array(")"=>1,"]"=>2,"}"=>3,">"=>4);

    $linesScore = array();

    // $completeLines = array(array(0 => "]",1 => ")",2 => "}",3 => ">"));
    // $num = 5;
    
    for ($i=0; $i < count($completeLines); $i++) { 
        $total = 0;
        for ($j=0; $j < count($completeLines[$i]); $j++) { 
            $s = $completeLines[$i][$j];
            $total = $total*$num + $points[$s];
            // echo $total."\r\n";
        }
        array_push($linesScore,$total);
    }

    // print_r($linesScore);

    sort($linesScore);

    // print_r($linesScore);
    $n = floor($cont / 2);
    // echo $n;
    // echo $linesScore[$n];
    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "MIDDLE ".$linesScore[$n]."\r\n";
}


$lines = getData();

// print_r($lines);

calculate_part1($lines);
calculate_part2($lines);



