<?php

//AOC - Day 13
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\13\calculate.php"

function getData(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $maxx = 0;
    $maxy = 0;

    $data = array("points"=>array(),"fold"=>array());
    while(!feof($f)){
        $line = rtrim(fgets($f));
        if($line!='' && substr($line,0,4)!='fold'){
            $point = explode(",",rtrim($line));
            $x = $point[0];
            $y = $point[1];
            if($x>$maxx)
                $maxx = $x;
            if($y>$maxy)
                $maxy=$y;
            array_push($data["points"],array("x"=>$x,"y"=>$y));
        }
        if(substr($line,0,4)=='fold'){
            $line = explode(" ",$line);
            $line = explode("=",$line[2]);
            array_push($data["fold"],array("axis"=>$line[0],"value"=>$line[1]));
        }
    }
    $data["maxx"]=$maxx;
    $data["maxy"]=$maxy;
    return $data;
}

function createMap($data){
    $map = array();
    for ($i=0; $i <= $data["maxy"]; $i++) { 
        for ($j=0; $j <= $data["maxx"]; $j++) { 
            $map[$i][$j] = '.';
            // if($data["points"]["x"]==$j && $data["points"]["y"]==$i){
            if(in_array(array("x"=>$j,"y"=>$i),$data["points"])){
                $map[$i][$j] = '#';
            }
        }
    }
    return $map;
}

function printMap($map){
    for ($i=0; $i < count($map); $i++) { 
        for ($j=0; $j < count($map[$i]); $j++) { 
            echo $map[$i][$j];
        }
        echo "\r\n";
    }
    echo "\r\n";
}

function foldMap($map,$axis,$value){
    $new_map = array();
    if($axis=="y"){
        //first values are equal
        for ($i=0; $i < $value; $i++) { 
            for ($j=0; $j < count($map[$i]); $j++) { 
                $new_map[$i][$j] = $map[$i][$j];
            }
        }
        //and now, paste values from end to begin
        $newi = 0;
        for ($i=count($map)-1; $i > $value; $i--) { 
            for ($j=0; $j < count($map[$i]); $j++) {
                $new_map[$newi][$j] = '.';
                if($map[$i][$j] == '#' || $map[$newi][$j] == '#') 
                    $new_map[$newi][$j] = '#';
            }
            $newi++;
        }
    }
    elseif($axis=="x"){
        //first values are equal
        for ($i=0; $i < count($map); $i++) { 
            for ($j=0; $j < $value; $j++) { 
                $new_map[$i][$j] = $map[$i][$j];
            }
        }
        //and now, paste values from end to begin
        
        for ($i=0; $i < count($map); $i++) { 
            $newj = 0;
            for ($j=count($map[$i])-1; $j > $value; $j--) {
                // echo $i." ".$j." ".$map[$i][$j]." - ".$i." ".$newj." ".$map[$i][$newj]."\r\n";
                $new_map[$i][$newj] = '.';
                if($map[$i][$j] == '#' || $map[$i][$newj] == '#') 
                    $new_map[$i][$newj] = '#';
                $newj++;
            }
            
        }
    }
    $map = $new_map;
    return $map;
}

function countDots($map){
    $cont = 0;
    for ($i=0; $i < count($map); $i++) { 
        for ($j=0; $j < count($map[$i]); $j++) { 
            if($map[$i][$j] == '#')
                $cont++;
        }
    }
    return $cont;
}

function calculate_part1($data){
    $map = createMap($data);

    //printMap($map);

    foreach($data["fold"] as $k => $fold){

        echo "FOLDING AXIS ".$fold["axis"]." ".$fold["value"]."\r\n";

        $map = foldMap($map,$fold["axis"],$fold["value"]);

        $n = countDots($map);

        // printMap($map);

        echo "TOTAL ".$n."\r\n";

    }    

    printMap($map);
}




$data = getData();



// print_r($data);


calculate_part1($data);
// calculate_part2($map);


