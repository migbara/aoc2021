<?php

//AOC - Day 14
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\14\calculate.php"

function getData(){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $cont = 0;

    $data = array("template"=>'',"rules"=>array());
    while(!feof($f)){
        $line = rtrim(fgets($f));
        if($line!='' && $cont==0){
            $data["template"] = $line;
        }
        elseif($line!=''){
            $point = explode(" -> ",$line);
            $patron = $point[0];
            $element = $point[1];
            $data["rules"][$patron] = $element;
        }
        $cont++;
    }
    return $data;
}

function createPolymer($data,$steps){
    $template = str_split($data["template"]);
    
    for ($k=1; $k <= $steps; $k++) { 
        
        $pairs = array();
        for ($i=0; $i < count($template)-1; $i++) { 
            array_push($pairs,$template[$i].$template[$i+1]);
        }
        // print_r($pairs);

        // foreach($pairs as $pair){
        //     if(in_array($pair,array_keys($data["rules"])))
        //         echo $pair." -> ".$data["rules"][$pair]."\r\n";
        // }

        $polymer = array();
        $i = 0;

        while ($i < count($template)-1){
            if(in_array($template[$i].$template[$i+1],$pairs)){
                array_push($polymer,$template[$i]);
                array_push($polymer,$data["rules"][$template[$i].$template[$i+1]]);
                //array_push($polymer,$template[$i+1]);
            }
            else{
                array_push($polymer,$template[$i]);
            }
            $i++;
        }
        array_push($polymer,$template[$i]);

        $template = $polymer;

    };
    return $polymer;
}

function calculate_part1($data){
    $polymer = createPolymer($data,4);

    // print_r($polymer);

    //most common element
    $array_cont = array();
    for ($i=0; $i < count($polymer); $i++) { 
        if(!isset($array_cont[$polymer[$i]]))
            $array_cont[$polymer[$i]] = 0;
        $array_cont[$polymer[$i]]++;
    }

    // print_r($array_cont);

    sort($array_cont);

    // print_r($array_cont);

    $most_common = $array_cont[(count($array_cont)-1)];
    $least_common = $array_cont[0];
    $total = $most_common - $least_common;

    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL ".$total."\r\n";
}


function calculate_part2_impossible($data){
    ini_set('memory_limit', -1);

    $t1 = microtime();
    $polymer = createPolymer($data,40);
    $t2 = microtime();
    echo $t2-$t1." POINT 1"."\r\n";

    // print_r($polymer);

    //most common element
    $array_cont = array();
    for ($i=0; $i < count($polymer); $i++) { 
        if(!isset($array_cont[$polymer[$i]]))
            $array_cont[$polymer[$i]] = 0;
        $array_cont[$polymer[$i]]++;
    }

    $t3 = microtime();
    echo $t3-$t2." POINT 2"."\r\n";

    // print_r($array_cont);

    sort($array_cont);

    $t4 = microtime();
    echo $t4-$t3." POINT 3"."\r\n";

    // print_r($array_cont);

    $most_common = $array_cont[(count($array_cont)-1)];
    $least_common = $array_cont[0];
    $total = $most_common - $least_common;

    $t5 = microtime();
    echo $t5-$t4." POINT 4"."\r\n";

    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL ".$total."\r\n";
}


function calculate_part2($data){
    //we need determinate how many elements will be after each step
    $template = str_split($data["template"]);
    $pairs = array();
    for ($i=0; $i < count($template)-1; $i++) {
        if(!isset($pairs[$template[$i].$template[$i+1]]))
            $pairs[$template[$i].$template[$i+1]] = 0;
        $pairs[$template[$i].$template[$i+1]]++;
    }

    $steps = 40;

    for ($k=0; $k < $steps; $k++) { 
        

        $npairs = $pairs;
        foreach($pairs as $p => $cont){
            foreach($data["rules"] as $rule => $v){
                if($rule == $p && $cont>0){

                    echo "PAIR ".$p." RULE ".$rule. " v ".$v."\r\n";

                    $cad = str_split($p);
                    
                    $new_rule = $cad[0].$v;
                    if(!isset($npairs[$new_rule]))
                        $npairs[$new_rule] = 0;
                    $npairs[$new_rule] += $cont;

                    echo "NEW RULE ".$new_rule." ".$npairs[$new_rule]."\r\n";
                    
                    $new_rule = $v.$cad[1];
                    if(!isset($npairs[$new_rule]))
                        $npairs[$new_rule] = 0;
                    $npairs[$new_rule] += $cont;

                    echo "NEW RULE ".$new_rule." ".$npairs[$new_rule]."\r\n";
                    
                    $npairs[$p] -= $cont;

                    echo "BREAK PAIR ".$p." ".$npairs[$p]."\r\n";
                }
            }
        }
        $pairs = $npairs;
        print_r($pairs);
    }

    $array_cont = array();
    $array_cont[$template[count($template)-1]] = 1;//add the last letter
    foreach ($pairs as $p => $cont) {
        if($cont>0){
            //only count the first letter on each pair
            $cad = str_split($p);
            if(!isset($array_cont[$cad[0]]))
                $array_cont[$cad[0]] = 0;
            $array_cont[$cad[0]] += $cont;
        }        
    }

    print_r($array_cont);

    sort($array_cont);

    // print_r($array_cont);

    $most_common = $array_cont[(count($array_cont)-1)];
    $least_common = $array_cont[0];
    $total = $most_common - $least_common;

    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "TOTAL ".$total."\r\n";
    
}

$data = getData();



// print_r($data);


// calculate_part1($data);
calculate_part2($data);


