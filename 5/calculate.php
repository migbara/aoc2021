<?php

//AOC - Day 5
//php.exe -c "c:\php8.1.0\php.ini" "C:\....\aoc_2021\5\calculate.php"

$vectors = array();
$map = array();
$maxx = 0;
$maxy = 0;

function getData(&$vectors,&$map,&$maxx,&$maxy){
    //1 - Read from a file
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\input.txt";
    $f = fopen($file,"r");

    $counter = 0;
    $maxx = 0;
    $maxy = 0;

    while(!feof($f)){
        $counter++;
        $line = rtrim(fgets($f));

        $data = explode(" -> ",$line);
        $p1 = explode(",",$data[0]);
        $p2 = explode(",",$data[1]);

        $vector = array("p1"=>array("x"=>$p1[0],"y"=>$p1[1]),"p2"=>array("x"=>$p2[0],"y"=>$p2[1]));

        if($p1[0] > $maxx)
            $maxx = $p1[0];
        if($p2[0] > $maxx)
            $maxx = $p2[0];
        if($p1[1] > $maxy)
            $maxy = $p1[1];
        if($p2[1] > $maxy)
            $maxy = $p2[1];

        array_push($vectors,$vector);    
        
    }

    echo "DIMENSIONS ".$maxx." x ".$maxy."\r\n";

    //create map
    $map = array();
    for ($i=0; $i <= $maxy; $i++) { 
        for ($j=0; $j <= $maxx; $j++) { 
            $map[$i][$j]=0;
        }
    }
    
}

function addMap($vector,&$map){
    //print_r($vector);
    if($vector["p1"]["y"] == $vector["p2"]["y"]){
        //draw a horizontal vector
        if($vector["p1"]["x"]<$vector["p2"]["x"]){
            for ($i=$vector["p1"]["x"]; $i <= $vector["p2"]["x"]; $i++) { 
                $map[$vector["p1"]["y"]][$i]++;
            }
        }
        else{
            for ($i=$vector["p2"]["x"]; $i <= $vector["p1"]["x"]; $i++) { 
                $map[$vector["p1"]["y"]][$i]++;
            }
        }
    }
    elseif($vector["p1"]["x"] == $vector["p2"]["x"]){
        //draw a vertical vector
        if($vector["p1"]["y"]<$vector["p2"]["y"]){
            for ($i=$vector["p1"]["y"]; $i <= $vector["p2"]["y"]; $i++) { 
                $map[$i][$vector["p1"]["x"]]++;
            }
        }
        else{
            for ($i=$vector["p2"]["y"]; $i <= $vector["p1"]["y"]; $i++) { 
                $map[$i][$vector["p1"]["x"]]++;
            }
        }
    }
    else{
        //draw a diagonal vector
        if($vector["p1"]["y"]<$vector["p2"]["y"]){
            $x = $vector["p1"]["x"];
            for ($i=$vector["p1"]["y"]; $i <= $vector["p2"]["y"]; $i++) { 
                $map[$i][$x]++;
                if($vector["p1"]["x"] < $vector["p2"]["x"])
                    $x++;
                else
                    $x--;
            }
        }
        else{
            $x = $vector["p2"]["x"];
            for ($i=$vector["p2"]["y"]; $i <= $vector["p1"]["y"]; $i++) { 
                $map[$i][$x]++;
                if($vector["p1"]["x"] > $vector["p2"]["x"])
                    $x++;
                else
                    $x--;
            }
        }
    }
}

function drawMapTextFile($map){
    $cad = '';
    for ($i=0; $i < count($map); $i++) { 
        for ($j=0; $j < count($map[$i]); $j++) { 
            if($map[$i][$j]==0)
                $cad .= ".";
            else
                $cad .= "".$map[$i][$j];
        }
        $cad .= "\r\n";
    }
    //echo $cad;
    //output to a textfile
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\output.txt";
    $f = fopen($file,"w");
    fputs($f,$cad);
    fclose($f);
}

function drawMapImageFile($map,$maxx,$maxy){
    $hor_size = $maxx;
    $ver_size = $maxy;
    
    $gd = imagecreatetruecolor($hor_size, $ver_size);

    $first = imagecolorallocate($gd, 88, 24, 69);
    $second = imagecolorallocate($gd, 114, 12, 63);
    $third = imagecolorallocate($gd, 199, 0, 57);
    $fourth = imagecolorallocate($gd, 255, 87, 51);
    $fifth = imagecolorallocate($gd, 255, 195, 0);
    $sixth = imagecolorallocate($gd, 218, 247, 166);

    $colors = array($first,$second,$third,$fourth,$fifth,$sixth);

    $x = 0;
    $y = 0;
    $max = 0;
    for ($y=0; $y < count($map); $y++) { 
        for ($x=0; $x < count($map[$y]); $x++) { 
            if($map[$y][$x] > 0){
                if($map[$y][$x] > $max)
                    $max = $map[$y][$x];
                imagesetpixel($gd, $x, $y, $colors[($map[$y][$x] - 1)]);
            }
        }
    }
    //echo "MAX VECTOR CONCURRENCE ".$max."\r\n";
    
    $file = dirname($_SERVER["SCRIPT_FILENAME"])."\\output.png";
    imagepng($gd,$file);
    
}

function putVectors_part1($vectors,&$map){
    for ($i=0; $i < count($vectors); $i++) { 
        $vector = $vectors[$i];
        if( ($vector["p1"]["x"] == $vector["p2"]["x"]) || ($vector["p1"]["y"] == $vector["p2"]["y"]) ){
            addMap($vector,$map);
        }
    }
}

function putVectors_part2($vectors,&$map){
    for ($i=0; $i < count($vectors); $i++) { 
        $vector = $vectors[$i];
        addMap($vector,$map);
    }
}

function countVectors($map,$n){
    $counter = 0;
    for ($i=0; $i < count($map); $i++) { 
        for ($j=0; $j < count($map[$i]); $j++) { 
            if($map[$i][$j]>=$n)
                $counter++;
        }
    }
    return $counter;
}


function calculate_part1($vectors,$map){
    putVectors_part1($vectors,$map);
    drawMapTextFile($map);
    //we need know how many points have 2 vectors or more
    $counter = countVectors($map,2);
    echo "PART 1"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "NUMBERS COUNTER: ".$counter."\r\n";
}

function calculate_part2($vectors,&$map){
    putVectors_part2($vectors,$map);
    drawMapTextFile($map);
    //we need know how many points have 2 vectors or more
    $counter = countVectors($map,2);
    echo "PART 2"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "NUMBERS COUNTER: ".$counter."\r\n";
}


getData($vectors,$map,$maxx,$maxy);
// $vectors = array();
// $vectors["0"] = array("p1"=>array("x"=>"0","y"=>"0"),"p2"=>array("x"=>"8","y"=>"8"));
// $vectors["1"] = array("p1"=>array("x"=>"5","y"=>"5"),"p2"=>array("x"=>"8","y"=>"2"));
// $vectors["2"] = array("p1"=>array("x"=>"3","y"=>"2"),"p2"=>array("x"=>"2","y"=>"3"));
// $vectors["2"] = array("p1"=>array("x"=>"6","y"=>"4"),"p2"=>array("x"=>"2","y"=>"0"));

calculate_part1($vectors,$map);
calculate_part2($vectors,$map);

drawMapImageFile($map,$maxx,$maxy);// It's cool view all info in an image

// print_r($vectors);
// print_r($map);

