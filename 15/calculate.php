<?php

//AOC - Day 15
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\15\calculate.php"

function getData(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $row = array();
    $max_rows = 0;

    $data = array();
    while(!feof($f)){
        $line = rtrim(fgets($f));
        $row = str_split(rtrim($line));
        array_push($data,$row);
        $max_rows++;
        $max_cols = count($row);
    }
    return array("map"=>$data,"rows"=>$max_rows,"cols"=>$max_cols);
}

function findPaths($data,$y,$x,&$paths,$points=0,$v=array()){
    //this function is working, but not for big matrix
    // echo $x." ".$y."\r\n";

    if($x!=0 || $y!=0){
        $points += $data["map"][$y][$x];
        // echo "SUMA ".$data["map"][$y][$x]." x ".$x." y ".$y."\r\n";
    }

    if($points<$paths){
    
        array_push($v,array("x"=>$x,"y"=>$y));
        
        if($y==($data["rows"]-1) && $x==($data["cols"]-1)){
            // array_push($paths,$points);
            echo "POINTS ".$points."\r\n";
            $paths = $points;
            return($paths);
        }
        else{
            if($x<($data["cols"]-1) && !in_array(array("x"=>$x+1,"y"=>$y),$v)){
                //find path moving right
                findPaths($data,$y,$x+1,$paths,$points,$v);
            }
            if($y<($data["rows"]-1) && !in_array(array("x"=>$x,"y"=>$y+1),$v)){
                //find path moving down
                findPaths($data,$y+1,$x,$paths,$points,$v);
            }
            if($x>0 && !in_array(array("x"=>$x-1,"y"=>$y),$v)){
                //find path moving left
                findPaths($data,$y,$x-1,$paths,$points,$v);
            }
            if($y>0 && !in_array(array("x"=>$x,"y"=>$y-1),$v)){
                //find path moving up
                findPaths($data,$y-1,$x,$paths,$points,$v);
            }
        }
    }
    else{
        unset($v);
        echo $points.".";
    }
}

//new idea, simply fill each point with the minimum effort to get it
// the right botton corener will have the minimum effort
function fillMap($v,$map){
    $cont = 0;
    // $max = 0;
    $v[0][0] = 0;

    $points = array(array("x"=>0,"y"=>0)); 

    while(count($points)>0){
        $point = array_shift($points);
        $y = $point['y'];
        $x = $point['x'];
 
        //up
        if($y>0 && ($v[$y-1][$x] > $v[$y][$x] + $map[$y-1][$x])){
            $v[$y-1][$x] = $v[$y][$x] + $map[$y-1][$x];
            // if(!in_array(["x"=>$x,"y"=>$y-1],$points))
                $points[] = ["x"=>$x,"y"=>$y-1];
        }
        //down
        if($y<(count($map)-1) && ($v[$y+1][$x] > $v[$y][$x] + $map[$y+1][$x])){
            $v[$y+1][$x] = $v[$y][$x] + $map[$y+1][$x];
            // if(!in_array(["x"=>$x,"y"=>$y+1],$points))
                $points[] = ["x"=>$x,"y"=>$y+1];
        }
        //left
        if($x>0 && ($v[$y][$x-1] > $v[$y][$x] + $map[$y][$x-1])){
            $v[$y][$x-1] = $v[$y][$x] + $map[$y][$x-1];
            // if(!in_array(["x"=>$x-1,"y"=>$y],$points))
                $points[] = ["x"=>$x-1,"y"=>$y];
        }
        //right
        if($x<(count($map[0])-1) && ($v[$y][$x+1] > $v[$y][$x] + $map[$y][$x+1])){
            $v[$y][$x+1] = $v[$y][$x] + $map[$y][$x+1];
            // if(!in_array(["x"=>$x+1,"y"=>$y],$points))
                $points[] = ["x"=>$x+1,"y"=>$y];
        }
        
        
        $cont++;

        // if(count($points)>$max)
        //     $max = count($points);

    }

    // echo "PUNTOS PROCESADOS METODO fillMap ".$cont."\r\n";
    // echo "MAX POINTS ".$max."\r\n";

    // printMap($v,8);

    return $v[count($map)-1][count($map[0])-1];
}


function changeMap($data,$steps){
    $map = $data["map"];

    for ($k=1; $k <= $steps; $k++) { 

        $maxi = count($data["map"]);
        
        for ($i=0; $i < $maxi; $i++) { 

            $maxj = count($data["map"][$i]);
            
            for ($j=0; $j < $maxj; $j++) { 
                $map[$i + ($maxi*$k)][$j] = $map[$i][$j] + $k;
                if($map[$i + ($maxi*$k)][$j] >= 10)
                    $map[$i + ($maxi*$k)][$j] -= 9;
            }
        }

    }

    $maxj = count($map[0]);

    for ($k=1; $k <= $steps; $k++) { 

        //$maxi = count($map);

        
        
        for ($i=0; $i < count($map); $i++) { 

            
            
            for ($j=0; $j < $maxj; $j++) { 
                //if($i>$maxi){
                    $map[$i][($j + ($maxj*$k))] = $map[$i][$j] + $k;
                    if($map[$i][($j + ($maxj*$k))] >= 10)
                        $map[$i][($j + ($maxj*$k))] -= 9;
                // }
                // else{
                //     $map[$i][$j + $maxj*$k] = $map[$i][$j];
                // }
            }
        }

    }
    // print_r($map);
    return $map;
}

function printMap($map,$pos){
    for ($i=0; $i < count($map); $i++) {
        $line = ''; 
        for ($j=0; $j < count($map[$i]); $j++) { 
            $line .= sprintf("%".$pos."s",$map[$i][$j]);
        }
        $line .= "\r\n";
        echo $line;
    }
}

function calculate_part1($data){
    
    $t1 = microtime(true);
    $v = $data["map"];

    for ($i=0; $i < count($v); $i++) { 
        for ($j=0; $j < count($v[$i]); $j++) { 
            $v[$i][$j] = PHP_INT_MAX;
        }
    }

    $n = fillMap($v,$data["map"]);

    $t2 = microtime(true);
    echo "PART 1"."\r\n";
    echo "TIME TO PROCESS ".($t2 - $t1)." s"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "MINIMUM PATH VALUE ".$n."\r\n";
}

function calculate_part2($data){

    $t1 = microtime(true);
    $data["map"] = changeMap($data,4);

    // print_r($data["map"]);

    // printMap($data["map"],8);
    
    $v = $data["map"];

    for ($i=0; $i < count($v); $i++) { 
        for ($j=0; $j < count($v[$i]); $j++) { 
            $v[$i][$j] = PHP_INT_MAX;
        }
    }

    $n = fillMap($v,$data["map"]);

    $t2 = microtime(true);

    echo "PART 2"."\r\n";
    echo "TIME TO PROCESS ".($t2 - $t1)." s"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "MINIMUM PATH VALUE ".$n."\r\n";
}

$data = getData();

// print_r($data);

calculate_part1($data);
calculate_part2($data);


// print_r($data);
/*
$paths = 0;
//choose a random path, for example, left and bottom line
$points = 0;
for ($i=1; $i < count($data["map"]); $i++) { 
    $points+=$data["map"][$i][0];
}
for ($j=1; $j < $data["cols"]; $j++) { 
    $points+=$data["map"][($data["rows"]-1)][$j];
}
$paths = $points;

echo $paths."\r\n";


$resp = floodFill(['x' => 0, 'y' => 0], $data["map"]);

echo $resp."\r\n";

findPaths($data,0,0,$paths);

echo $paths."\r\n";
*/
// echo min($paths);







