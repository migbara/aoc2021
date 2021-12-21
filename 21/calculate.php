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
        $row = explode(" starting position: ",$line);
        $position = $row[1];
        $player = explode("Player ",$row[0]);
        $player = $player[1];
        $data[] = ["player"=>$player,"position"=>$position];
    }
    return $data;
}

function play($data,$dice_size,$goal){
    // $goal = 20;
    for ($i=0; $i < count($data); $i++) { 
        $data[$i]["score"] = 0;
    }
    $turno = -1;
    $score = 0;
    $cont_dice = 0;
    $dice_move = 0;
    while($score<$goal){
        $turno++;
        $turno = (($turno) % count($data));
        $jugador = $turno+1;
        echo "TURNO ".$turno." JUGADOR ".($jugador)."\r\n";

        $avanza = 0;
        $cont_dice = ($cont_dice + 1) % $dice_size;
        $avanza += $cont_dice;
        $cont_dice = ($cont_dice + 1) % $dice_size;
        $avanza += $cont_dice;
        $cont_dice = ($cont_dice + 1) % $dice_size;
        $avanza += $cont_dice;

        $dice_move += 3;

        $new_position = ($data[$turno]["position"] + $avanza) % 10;

        if($new_position==0)
            $new_position = 10;

        echo "JUGADOR ".$jugador." AVANZA ".$avanza." POSICIONES ".$data[$turno]["position"]." => ".$new_position." SCORE: ".($data[$turno]["score"] + $new_position)."\r\n";

        $data[$turno]["position"] = $new_position;

        $data[$turno]["score"] += $new_position;

        $score = $data[$turno]["score"];
    }
    echo "JUGADOR ".$turno." GANA . SCORE: ".$data[$turno]["score"]." POSITION: ".$data[$turno]["position"]."\r\n";

    $player_lose = $turno+1;
    $player_lose = (($player_lose) % count($data));

    echo "JUGADOR ".$player_lose." PIERDE CON SCORE = ".$data[$player_lose]["score"]."\r\n";
    echo "NUMERO DE VECES QUE SE HA TIRADO EL DADO = ".$dice_move."\r\n";
    echo "RESULT ".$dice_move * $data[$player_lose]["score"]."\r\n";
}


$data = getData();


print_r($data);

function calculate_part1($data){

    $t1 = microtime(true);
    
    play($data,100,1000);


    $t2 = microtime(true);

    echo "PART 1"."\r\n";
    echo "TIME TO PROCESS ".($t2 - $t1)." s"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "ADD VERSIONS ".$sum."\r\n";
}

function calculate_part2($data){

    $t1 = microtime(true);
    

    $t2 = microtime(true);

    // echo pinta($data);

    echo "PART 2"."\r\n";
    echo "TIME TO PROCESS ".($t2 - $t1)." s"."\r\n";
    echo "---------------------------------------"."\r\n";
    echo "RESULT ".$data[0]["dec"]." OPERATION ".$data[0]["operation"]."\r\n";
}



calculate_part1($data);
// calculate_part2($data);








