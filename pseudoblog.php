<?php

$tablica = [];

while(true){
$wpis = readline("Wpisz swój wpis:");

if (strtolower($wpis) === "koniec"){ 
    break;

}

if ($wpis !== ""){ 
        array_push($tablica,$wpis);
}
}

echo "\nWpisy:\n";
foreach ($tablica as $i => $wpis) {
    echo ($i + 1) . ". $wpis\n";
}


?>

