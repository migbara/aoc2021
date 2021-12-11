<?php

//AOC - Day 11
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\11\calculate.php"

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

function printMap($map){
    for ($i=0; $i < count($map); $i++) { 
        for ($j=0; $j < count($map[$i]); $j++) { 
            echo $map[$i][$j];
        }
        echo "\r\n";
    }
}

function flash(&$map,$y,$x,&$ceros,$k){
    $c = 0;
    if($map[$y][$x]<9 && $map[$y][$x]>0){
        $map[$y][$x]++;
    }
    else{
        //if is 0, we have know if has flashed in the same step
        if($map[$y][$x]==0){
            if(!in_array(array("x"=>$x,"y"=>$y),$ceros[$k]))
                $map[$y][$x]++;
        }
        else{
            $c++;
            $map[$y][$x] = "0";
            
            array_push($ceros[$k],array("x"=>$x,"y"=>$y));
            //Now, eight cells around must be incremented by 1
            if($y>0 && $x>0 && $y<count($map)-1 && $x<count($map[$y])-1){
            //inside matrix
                $c += flash($map,$y-1,$x-1,$ceros,$k);
                $c += flash($map,$y-1,$x,$ceros,$k);
                $c += flash($map,$y-1,$x+1,$ceros,$k);
                $c += flash($map,$y,$x-1,$ceros,$k);
                $c += flash($map,$y,$x+1,$ceros,$k);
                $c += flash($map,$y+1,$x-1,$ceros,$k);
                $c += flash($map,$y+1,$x,$ceros,$k);
                $c += flash($map,$y+1,$x+1,$ceros,$k);
            }
            elseif($y > 0 && $x==0 && $y<count($map)-1){
                //left side, but not corners
                $c += flash($map,$y-1,$x,$ceros,$k);
                $c += flash($map,$y-1,$x+1,$ceros,$k);
                $c += flash($map,$y,$x+1,$ceros,$k);
                $c += flash($map,$y+1,$x,$ceros,$k);
                $c += flash($map,$y+1,$x+1,$ceros,$k);
            }
            elseif($y > 0 && $x==count($map[$y])-1 && $y<count($map)-1){
                //right side, but not corners
                $c += flash($map,$y-1,$x-1,$ceros,$k);
                $c += flash($map,$y-1,$x,$ceros,$k);
                $c += flash($map,$y,$x-1,$ceros,$k);
                $c += flash($map,$y+1,$x-1,$ceros,$k);
                $c += flash($map,$y+1,$x,$ceros,$k);
            }
            elseif($y == 0 && $x>0 && $x<count($map[$y])-1){
                //up side, but not corners
                $c += flash($map,$y,$x-1,$ceros,$k);
                $c += flash($map,$y,$x+1,$ceros,$k);
                $c += flash($map,$y+1,$x-1,$ceros,$k);
                $c += flash($map,$y+1,$x,$ceros,$k);
                $c += flash($map,$y+1,$x+1,$ceros,$k);
            }
            elseif($y == count($map)-1 && $x>0 && $x<count($map[$y])-1){
                //down side, but not corners
                $c += flash($map,$y-1,$x-1,$ceros,$k);
                $c += flash($map,$y-1,$x,$ceros,$k);
                $c += flash($map,$y-1,$x+1,$ceros,$k);
                $c += flash($map,$y,$x-1,$ceros,$k);
                $c += flash($map,$y,$x+1,$ceros,$k);
            }
            elseif($y == 0 && $x==0){
                //left up 
                $c += flash($map,$y,$x+1,$ceros,$k);
                $c += flash($map,$y+1,$x,$ceros,$k);
                $c += flash($map,$y+1,$x+1,$ceros,$k);
            }
            elseif($y == 0 && $x==count($map[$y])-1){
                //right up 
                $c += flash($map,$y,$x-1,$ceros,$k);
                $c += flash($map,$y+1,$x-1,$ceros,$k);
                $c += flash($map,$y+1,$x,$ceros,$k);
            }
            elseif($y == count($map)-1 && $x==0){
                //left down 
                $c += flash($map,$y-1,$x,$ceros,$k);
                $c += flash($map,$y-1,$x+1,$ceros,$k);
                $c += flash($map,$y,$x+1,$ceros,$k);
            }
            elseif($y == count($map)-1 && $x==count($map[$y])-1){
                //right down 
                $c += flash($map,$y-1,$x-1,$ceros,$k);
                $c += flash($map,$y-1,$x,$ceros,$k);
                $c += flash($map,$y,$x-1,$ceros,$k);
            }
        }
    }
    return $c;
}

function calculate_part1($map){
    $cont = 0;
    $steps = 100;
    $ceros = array();//Para saber en qué paso se han puesto los 0s
    for ($k=0; $k < $steps; $k++) { 
        
        for ($i=0; $i < count($map); $i++) { 
            for ($j=0; $j < count($map[$i]); $j++) { 
                if(!isset($ceros[$k]))
                    $ceros[$k]=array();
                $cont += flash($map,$i,$j,$ceros,$k);
            }
        }
    
    }
    printMap($map);
    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL ".$cont."\r\n";
}

function calculate_part2($map){
    $cont = 0;
    $steps = 100;
    $ceros = array();//for know 0s flashed in each step
    $k = 0;
    $found = '';
    while($found == ''){
        
        for ($i=0; $i < count($map); $i++) { 
            for ($j=0; $j < count($map[$i]); $j++) { 
                if(!isset($ceros[$k]))
                    $ceros[$k]=array();
                $cont += flash($map,$i,$j,$ceros,$k);
            }
        }

        if(count($ceros[$k])==100)
            $found = $k;
        $k++;
    
    }
    printMap($map);
    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL ".($found+1)."\r\n";
}


$map = getData();

// print_r($map);


// calculate_part1($map);
calculate_part2($map);


