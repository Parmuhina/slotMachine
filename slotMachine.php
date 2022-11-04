<?php
declare(strict_types=1);

function boardFill (array $board, array $slotValue){
    for ($i=0; $i<count($board); $i++) {
        for ($j = 0; $j < count($board[0]); $j++) {
            $board[$i][$j] = $slotValue[rand(1, count($slotValue) - 1)];
        }
    }
        foreach ($board as $boar) {
            foreach ($boar as $b) {
                echo "|" . $b . "|";
            }
            echo PHP_EOL;

        }
        return $board;
}
function check (array $board, array $payLines, array $slotValue){
    foreach ($slotValue as $slot){
        foreach ($payLines as $pay){
            $result=0;
            foreach ($pay as $position){
                [$x, $y]=$position;
                if($board[$x][$y]===$slot){
                    $result++;
                }
            }
            if($result===count($board[0])) {
                return [true, $slot];
            }
        }

    }
}

$board=[
    [" ", " ", " ", " ", " "],
    [" ", " ", " ", " ", " "],
    [" ", " ", " ", " ", " "]
];

$payLines=[
    [[0, 0], [0, 1], [0, 2], [0, 3], [0, 4]],
    [[1, 0], [1, 1], [1, 2], [1, 3], [1, 4]],
    [[2, 0], [2, 1], [2, 2], [2, 3], [2, 4]],
    [[0, 0], [1, 1], [2, 2], [1, 3], [0, 4]],
    [[2, 0], [1, 1], [0, 2], [1, 3], [2, 4]],
    [[0, 0], [0, 1], [1, 2], [2, 3], [2, 4]],
    [[2, 0], [2, 1], [1, 2], [0, 3], [0, 4]],
    [[1, 0], [0, 1], [1, 2], [2, 3], [1, 4]],
    [[1, 0], [2, 1], [1, 2], [0, 3], [1, 4]],
    [[0, 0], [1, 1], [1, 2], [1, 3], [2, 4]],
    [[2, 0], [1, 1], [0, 2], [1, 3], [0, 4]],
    [[1, 0], [2, 1], [1, 2], [0, 3], [1, 4]],
    [[1, 0], [2, 1], [1, 2], [2, 3], [1, 4]],
    [[2, 0], [1, 1], [2, 2], [1, 3], [2, 4]],
    [[0, 0], [1, 1], [0, 2], [1, 3], [0, 4]],
    [[0, 0], [1, 1], [2, 2], [1, 3], [2, 4]],
    [[2, 0], [1, 1], [2, 2], [1, 3], [2, 4]],
    [[1, 0], [0, 1], [1, 2], [0, 3], [1, 4]],
    [[1, 0], [0, 1], [1, 2], [2, 3], [1, 4]],
    [[0, 0], [0, 1], [2, 2], [0, 3], [0, 4]],
    [[0, 0], [0, 1], [1, 2], [0, 3], [0, 4]],
    [[1, 0], [1, 1], [0, 2], [1, 3], [1, 4]],
    [[1, 0], [1, 1], [2, 2], [1, 3], [1, 4]],
    [[2, 0], [2, 1], [1, 2], [2, 3], [2, 4]],
    [[0, 0], [0, 1], [0, 2], [1, 3], [2, 4]],
    [[1, 0], [1, 1], [1, 2], [2, 3], [1, 4]],
    [[2, 0], [1, 1], [1, 2], [1, 3], [0, 4]],
    [[2, 0], [2, 1], [2, 2], [1, 3], [0, 4]],
    [[2, 0], [2, 1], [0, 2], [2, 3], [2, 4]]
];
$spinAmount=[1, 2, 5, 10];
$slotValue=["*", "@", "#", "$", "%", "&", "=", "+"];
$slotCoeficient=["*" =>1, "@" =>1, "#" =>1, "$" =>2, "%" =>2, "&"=>2, "=" =>3, "+" =>3];
$spinNumber=1;
$winingSum=0;

$startCapital=floatval(readline('Insert your start money amount: '));
if (is_numeric($startCapital)===false || $startCapital<=0){
    echo "Inserted value not correct.".PHP_EOL;
    exit;
}
echo "One spin cost: 1$, 2$, 5$, or 10$. Insert only number 1, 2, 5, or 10".PHP_EOL;
$cost=(int)readline('Chose one spin costs: ');

if (is_numeric($cost)===false || in_array($cost, $spinAmount)===false){
    echo "Inserted value not correct.".PHP_EOL;
    exit;
}

do {
    $str = readline('Do you want to play game? If yes, press Y, if no, press another key ');
    echo PHP_EOL;
    if ($str === "Y" && $cost * $spinNumber <= $startCapital) {
        $spinNumber++;
        $newBoard = boardFill($board, $slotValue);
        [$x, $y] = check($newBoard, $payLines, $slotValue);
        $value=0;
        if ($x) {
            echo 'Congratulations, you win' . PHP_EOL;
            foreach ($slotCoeficient as $key => $value) {
                if ($key === $y) {
                    $winingSum += $value * 50;
                    echo 'Your win is ' . $value * 50;
                    echo PHP_EOL;
                    echo "All your win is {$winingSum}" . PHP_EOL;
                    echo "Your cash is equal to " . $startCapital - ($spinNumber-1) * $cost;
                    echo PHP_EOL;
                }
            }
        } else {
            echo 'Sorry, you loose.' . PHP_EOL;
            echo "All your win is {$winingSum}" . PHP_EOL;
            echo "Your cash is equal to " . $startCapital - ($spinNumber-1) * $cost;
            echo PHP_EOL;
        }
    } else {
        if ($cost * $spinNumber > $startCapital) {
            echo "Start capital less than one spin!" . PHP_EOL;
        }
        echo "Thank you for game. See you soon. Bye!" . PHP_EOL;
        exit;
    }
}while($cost * $spinNumber <= $startCapital);
