<?php

//AOC - Day 12
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\12\calculate.php"

function getData(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $row = array();

    $data = array();
    while(!feof($f)){
        $line = rtrim(fgets($f));
        $vectors = explode("-",rtrim($line));
        array_push($data,array($vectors[0],$vectors[1]));
    }
    return $data;
}

function setPoints($v){
    $g = array();
    for ($i=0; $i < count($v); $i++) { 
        if(!in_array($v[$i][0],array_keys($g))){
            $g[$v[$i][0]] = array($v[$i][1]);
        }
        else{
            if(!in_array($v[$i][1],$g[$v[$i][0]]))
                array_push($g[$v[$i][0]],$v[$i][1]);
        }

        if(!in_array($v[$i][1],array_keys($g))){
            $g[$v[$i][1]] = array($v[$i][0]);
        }
        else{
            if(!in_array($v[$i][0],$g[$v[$i][1]]))
                array_push($g[$v[$i][1]],$v[$i][0]);
        }
    }
    return $g;
}


function findPaths($g,$p,$v,$cad,&$paths){
    if($cad=='')
        $cad = $p;
    else
        $cad .= ",".$p;
    // echo $cad."\r\n";
    //base, end
    if($p=='end'){
        array_push($paths,$cad);
        return($paths);
    }
    else{
        //if point is not visited or destiny point is a cave
        if(!in_array($p,$v) || strtoupper($p) == $p){
            if(!in_array($p,$v))
                array_push($v,$p);

            for ($i=0; $i < count($g[$p]); $i++) { 
                if($g[$p][$i]!='start'){
                    // print_r($v);
                    
                    // echo "VAMOS DESDE ".$p." A ".$g[$p][$i]."\r\n";
                    findPaths($g,$g[$p][$i],$v,$cad,$paths);
                }
            }
        }
    }
}

function isVisitable($v){
    foreach($v as $p => $c){
        if( (strtoupper($p)!=$p) && ($c == 2) )
            return false;
    }
    return true;
}

function findPathsTwice($g,$p,$v,$cad,&$paths){
    if($cad=='')
        $cad = $p;
    else
        $cad .= ",".$p;
    // echo $cad."\r\n";
    //base, end
    if($p=='end'){
        array_push($paths,$cad);
        return($paths);
    }
    else{
        //if point is not visited or destiny point is a cave
        if(!in_array($p,array_keys($v)) || strtoupper($p) == $p || isVisitable($v)){
            if(!in_array($p,array_keys($v)))
                // array_push($v,$p);
                $v[$p] = 1;
            else
                $v[$p]++;

            for ($i=0; $i < count($g[$p]); $i++) { 
                if($g[$p][$i]!='start'){
                    // print_r($v);
                    
                    // echo "VAMOS DESDE ".$p." A ".$g[$p][$i]."\r\n";
                    findPathsTwice($g,$g[$p][$i],$v,$cad,$paths);
                }
            }
        }
    }
}

function calculate_part1($vectors){
    $graph = setPoints($vectors);

    // print_r($graph);

    $visited = array();
    $paths = array();


    findPaths($graph,'start',$visited,'',$paths);

    // print_r($paths);

    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL ".count($paths)."\r\n";
}

function calculate_part2($vectors){
    $graph = setPoints($vectors);

    // print_r($graph);

    $visited = array();
    $paths = array();


    findPathsTwice($graph,'start',$visited,'',$paths);

    // print_r($paths);

    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL ".count($paths)."\r\n";
}

$vectors = getData();

// print_r($vectors);

calculate_part1($vectors);
calculate_part2($vectors);


