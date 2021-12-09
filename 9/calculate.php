<?php

//AOC - Day 9
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\9\calculate.php"

function getData(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $row = array();

    $data = array();
    while(!feof($f)){
        $line = rtrim(fgets($f));
        $row = str_split(rtrim($line));
        array_push($data,$row);
    }
    return $data;
}

function printPoint($map,$i,$j){
    echo $map[$i-1][$j-1].$map[$i-1][$j].$map[$i-1][$j+1]."\r\n";
    echo $map[$i][$j-1].$map[$i][$j].$map[$i][$j+1]."\r\n";
    echo $map[$i+1][$j-1].$map[$i+1][$j].$map[$i+1][$j+1]."\r\n";
}

function searchMin8Points($map){
    $result = array();
    // $detail_map = array();
    for ($i=0; $i < count($map); $i++) {
        for ($j=0; $j < count($map[$i]); $j++) { 
            $n = $map[$i][$j];
            // echo $n."\r\n";
            
            if($i>0 && $j>0 && $i<count($map)-1 && $j<count($map[$i])-1){
            //inside matrix
                if($n < $map[$i-1][$j-1] && $n < $map[$i-1][$j] && $n < $map[$i-1][$j+1]
                    && $n < $map[$i][$j-1] && $n < $map[$i][$j+1]
                    && $n < $map[$i+1][$j-1] && $n < $map[$i+1][$j] && $n < $map[$i+1][$j+1]){
                        array_push($result,$n);
                        echo "INSIDE ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }

            }
            elseif($i > 0 && $j==0 && $i<count($map)-1){
                //left side, but not corners
                if( $n < $map[$i-1][$j] && $n < $map[$i-1][$j+1]
                    && $n < $map[$i][$j+1]
                    && $n < $map[$i+1][$j] && $n < $map[$i+1][$j+1]){
                        array_push($result,$n);
                        echo "LEFT SIDE ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i > 0 && $j==count($map[$i])-1 && $i<count($map)-1){
                //right side, but not corners
                if($n < $map[$i-1][$j-1] && $n < $map[$i-1][$j]
                    && $n < $map[$i][$j-1] 
                    && $n < $map[$i+1][$j-1] && $n < $map[$i+1][$j] ){
                        array_push($result,$n);
                        echo "RIGHT SIDE ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == 0 && $j>0 && $j<count($map[$i])-1){
                //up side, but not corners
                if($n < $map[$i][$j-1] && $n < $map[$i][$j+1]
                    && $n < $map[$i+1][$j-1] && $n < $map[$i+1][$j] && $n < $map[$i+1][$j+1]){
                        array_push($result,$n);
                        echo "UP SIDE ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == count($map)-1 && $j>0 && $j<count($map[$i])-1){
                //down side, but not corners
                if($n < $map[$i-1][$j-1] && $n < $map[$i-1][$j] && $n < $map[$i-1][$j+1]
                    && $n < $map[$i][$j-1] && $n < $map[$i][$j+1]){
                        array_push($result,$n);
                        echo "DOWN SIDE ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == 0 && $j==0){
                //left up 
                if($n < $map[$i][$j+1] && $n < $map[$i+1][$j] && $n < $map[$i+1][$j+1]){
                        array_push($result,$n);
                        echo "LEFT UP ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == 0 && $j==count($map[$i])-1){
                //right up 
                if($n < $map[$i][$j-1] && $n < $map[$i+1][$j-1] && $n < $map[$i+1][$j] ){
                        array_push($result,$n);
                        echo "RIGHT UP ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == count($map)-1 && $j==0){
                //left down 
                if($n < $map[$i-1][$j] && $n < $map[$i-1][$j+1] && $n < $map[$i][$j+1] ){
                        array_push($result,$n);
                        echo "LEFT DOWN ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == count($map)-1 && $j==count($map[$i])-1){
                //right down 
                if($n < $map[$i-1][$j-1] && $n < $map[$i-1][$j] && $n < $map[$i][$j-1] ){
                        array_push($result,$n);
                        echo "RIGHT DOWN ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
        }
    }
    return $result;
}

function searchMin4Points($map){
    $result = array();
    // $detail_map = array();
    for ($i=0; $i < count($map); $i++) {
        for ($j=0; $j < count($map[$i]); $j++) { 
            $n = $map[$i][$j];
            // echo $n."\r\n";
            
            if($i>0 && $j>0 && $i<count($map)-1 && $j<count($map[$i])-1){
            //inside matrix
                if($n < $map[$i-1][$j]
                    && $n < $map[$i][$j-1] && $n < $map[$i][$j+1]
                    && $n < $map[$i+1][$j] ){
                        array_push($result,array("n"=>$n,"y"=>$i,"x"=>$j));
                        // echo "INSIDE ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }

            }
            elseif($i > 0 && $j==0 && $i<count($map)-1){
                //left side, but not corners
                if( $n < $map[$i-1][$j]
                    && $n < $map[$i][$j+1]
                    && $n < $map[$i+1][$j] ){
                        array_push($result,array("n"=>$n,"y"=>$i,"x"=>$j));
                        // echo "LEFT SIDE ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i > 0 && $j==count($map[$i])-1 && $i<count($map)-1){
                //right side, but not corners
                if( $n < $map[$i-1][$j]
                    && $n < $map[$i][$j-1] 
                    && $n < $map[$i+1][$j] ){
                        array_push($result,array("n"=>$n,"y"=>$i,"x"=>$j));
                        // echo "RIGHT SIDE ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == 0 && $j>0 && $j<count($map[$i])-1){
                //up side, but not corners
                if($n < $map[$i][$j-1] && $n < $map[$i][$j+1]
                   && $n < $map[$i+1][$j] ){
                        array_push($result,array("n"=>$n,"y"=>$i,"x"=>$j));
                        // echo "UP SIDE ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == count($map)-1 && $j>0 && $j<count($map[$i])-1){
                //down side, but not corners
                if($n < $map[$i-1][$j] 
                    && $n < $map[$i][$j-1] && $n < $map[$i][$j+1]){
                        array_push($result,array("n"=>$n,"y"=>$i,"x"=>$j));
                        // echo "DOWN SIDE ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == 0 && $j==0){
                //left up 
                if($n < $map[$i][$j+1] && $n < $map[$i+1][$j] ){
                        array_push($result,array("n"=>$n,"y"=>$i,"x"=>$j));
                        // echo "LEFT UP ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == 0 && $j==count($map[$i])-1){
                //right up 
                if($n < $map[$i][$j-1] && $n < $map[$i+1][$j] ){
                        array_push($result,array("n"=>$n,"y"=>$i,"x"=>$j));
                        // echo "RIGHT UP ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == count($map)-1 && $j==0){
                //left down 
                if($n < $map[$i-1][$j] && $n < $map[$i][$j+1] ){
                        array_push($result,array("n"=>$n,"y"=>$i,"x"=>$j));
                        // echo "LEFT DOWN ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
            elseif($i == count($map)-1 && $j==count($map[$i])-1){
                //right down 
                if($n < $map[$i-1][$j] && $n < $map[$i][$j-1] ){
                        array_push($result,array("n"=>$n,"y"=>$i,"x"=>$j));
                        // echo "RIGHT DOWN ".$i." ".$j." - VALUE ".$n."\r\n";
                        // printPoint($map,$i,$j);
                }
            }
        }
    }
    return $result;
}

function basin($map,$point,&$marks){
    //recursive function for find an area rounded by 9s from a point
    //base, if the point is rounded (up down left right) by 9s, or points marked, mark this point
    $minx = 0;
    $miny = 0;
    $maxy = max(array_keys($map));
    $maxx = max(array_keys($map[0]));

    array_push($marks,array("x"=>$point["x"],"y"=>$point["y"]));
    
    if($point["y"] != $miny){
        if($map[$point["y"]-1][$point["x"]] !=9){
            if(!in_array(array("x"=>$point["x"],"y"=>$point["y"]-1),$marks)){
                basin($map,array("x"=>$point["x"],"y"=>$point["y"]-1),$marks);
            }
        }
    }
    //down
    if($point["y"] != $maxy){
        if($map[$point["y"]+1][$point["x"]] !=9){
            if(!in_array(array("x"=>$point["x"],"y"=>$point["y"]+1),$marks)){
                basin($map,array("x"=>$point["x"],"y"=>$point["y"]+1),$marks);
            }
        }
    }
    //left
    if($point["x"] != $minx){
        if($map[$point["y"]][$point["x"]-1] !=9){
            if(!in_array(array("x"=>$point["x"]-1,"y"=>$point["y"]),$marks)){
                basin($map,array("x"=>$point["x"]-1,"y"=>$point["y"]),$marks);
            }
        }
    }
    //right
    if($point["x"] != $maxx){
        if($map[$point["y"]][$point["x"]+1] !=9){
            if(!in_array(array("x"=>$point["x"]+1,"y"=>$point["y"]),$marks)){
                basin($map,array("x"=>$point["x"]+1,"y"=>$point["y"]),$marks);
            }
        }
    }
    
}

function calculate_part1($map){
    $result = searchMin4Points($map);
    // print_r($result);
    $sum = 0;
    foreach($result as $res => $value){
        $sum += $value["n"]+1;
    }
    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL ".$sum."\r\n";
}

function calculate_part2($map){
    $result = searchMin4Points($map);
    // print_r($result);
    $array_max = array();
    foreach($result as $res => $value){
        $marks = array();
        // array_push($basins,basin($map,$value,$marks));
        basin($map,$value,$marks);
        // print_r($marks);
        array_push($array_max,count($marks));
    }
    
    // print_r($array_max);
    $max = 0;
    
    $final = array();
    for ($i=0; $i < 3; $i++) { 
        $max = max($array_max);
        array_push($final,$max);
        $find = false;
        $narray  = array();
        $j = 0;
        while($j < count($array_max)){
            if($array_max[$j]==$max && !$find){
                $find = true;
            }
            else{
                array_push($narray,$array_max[$j]);
            }
            $j++;
        }
        $array_max = $narray;
    }
    // print_r($final);
    $total = 1;
    foreach($final as $value){
        $total = $total * $value;
    }
    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL (".implode("x",$final).") = ".$total."\r\n";
}


$map = getData();



calculate_part1($map);
calculate_part2($map);

// print_r($map);

