<?php

//AOC - Day 4
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\4\calculate.php"

$numbers = array();
$cards = array();

function getData(&$numbers,&$cards){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $counter = 0;

    while(!feof($f)){
        $counter++;
        $line = fgets($f);

        if($counter==1)
            $numbers = explode(",",rtrim($line));
        else{

            if(rtrim($line)==''){
                if(isset($card)){
                    array_push($cards,$card);
                }
                $card = array();
            }
            else{
                //add line to card
                $row_numbers = explode(" ",str_replace("  "," ",trim($line)));
                $row = array();
                foreach($row_numbers as $k => $number){
                    $row[$k] = array("number"=>$number,"marked"=>false);
                }
                array_push($card,$row);
            }
        }
    }
    //add the last card
    array_push($cards,$card);
}

function putNumberCard(&$card,$n){
    for ($row=0; $row < count($card); $row++) { 
        for ($col=0; $col < count($card[$row]); $col++) { 
            if($n == $card[$row][$col]["number"])
                $card[$row][$col]["marked"] = true;
        }
    }
}

function putNumber(&$cards,$n){
    for ($i=0; $i < count($cards); $i++) { 
        putNumberCard($cards[$i],$n);
    }

}

function checkCards($cards,$winners=array()){
    // $rowending = false;
    // $colending = false;
    $i = 0;
    $w = array();
    while($i < count($cards)){
        if(!in_array($i,$winners)){
            //check rows
            $row = 0;
            while($row < count($cards[$i])){
                $col = 0;
                $rowcheck = true;
                while($rowcheck && $col < count($cards[$i][$row])){
                    $rowcheck = $rowcheck && $cards[$i][$row][$col]["marked"];
                    // echo "COUNT ".count($cards[$i][$row])."\r\n";
                    // echo "CARD ".$i. " ROW ".$row." COL ".$col."\r\n";
                    $col++;
                }
                if($rowcheck)
                    array_push($w, array("card"=>$i,"row"=>$row,"col"=>""));
                $row++;
            }

            //check cols
            $row = 0;
            $colchecks = array();
            while($row < count($cards[$i])){
                $col = 0;
                while($col < count($cards[$i][$row])){
                    if($row==0)
                        $colchecks[$col] = true;
                    $colchecks[$col] = $colchecks[$col] && $cards[$i][$row][$col]["marked"];
                    $col++;
                }
                $row++;
            }

            // print_r($colchecks);

            for ($col=0; $col < count($colchecks); $col++) { 
                if($colchecks[$col])
                    array_push($w, array("card"=>$i,"row"=>"", "col"=>$col));
            }
        }
        $i++;
    }
    return $w;
}

function calculateScore($card){
    $row = 0;
    $score = 0;
    while($row < count($card)){
        $col = 0;
        while($col < count($card[$row])){
            if(!$card[$row][$col]["marked"])
                $score += $card[$row][$col]["number"];
            $col++;
        }
        $row++;
    }
    return $score;
}

function calculate_part1($numbers,&$cards){
    $i = 0;
    $ok = true;
    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "NUMBERS COUNTER: ".count($numbers)."\r\n";
    echo "CARDS COUNTER: ".count($cards)."\r\n";
    while($ok && $i<count($numbers)){ 
        $number = $numbers[$i];
        putNumber($cards,$number);
        echo "NUMBER ".$number."\r\n";
        $result = checkCards($cards);
        if(count($result)>0){
            foreach($result as $k => $v){
                echo "FOUND LINE IN CARD ".$v["card"]." ROW ".$v["row"]." COL ".$v["col"]."\r\n";
                $ok = false;
                $score = calculateScore($cards[$v["card"]]);
                echo "FINAL SCORE: ".$score*$number."\r\n";;
            }
        }
        $i++;
    }
}

function calculate_part2($numbers,&$cards){
    $i = 0;
    $ok = true;
    $winners = array();
    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "NUMBERS COUNTER: ".count($numbers)."\r\n";
    echo "CARDS COUNTER: ".count($cards)."\r\n";
    while($ok && $i<count($numbers)){ 
        $number = $numbers[$i];
        putNumber($cards,$number);
        echo "NUMBER ".$number."\r\n";
        $result = checkCards($cards,$winners);
        
        if(count($result)>0){

            foreach($result as $k => $v){
                echo "FOUND LINE IN CARD ".$v["card"]." ROW ".$v["row"]." COL ".$v["col"]."\r\n";
                if(!in_array($v["card"],$winners))
                    array_push($winners,$v["card"]);
            }

            // print_r($winners);
            
            if(count($winners) == count($cards)){
                $ok = false;
            }
        }
        $i++;
    }
    $score = calculateScore($cards[$v["card"]]);
    echo "FINAL SCORE: ".$score*$number."\r\n";
    
}


getData($numbers,$cards);

// $numbers = array(7,4,9,5,11,17,23,2,0,14,21,24,10,16,13,6,15,25,12,22,18,20,8,19,3,26,1);
// $numbers = array(7,4,9,5,11,17,23,2,0,14,21,3,20); //FOR CHECK COLS

calculate_part1($numbers,$cards);
calculate_part2($numbers,$cards);

// print_r($numbers);
// print_r($cards);

