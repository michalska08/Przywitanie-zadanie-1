<?php
    $zdanie = readline("Wpisz jakieś zdanie: ");
        
    $zdanie = trim($zdanie);
    $slowa = explode(" ", $zdanie);
    $liczba = count($slowa);
    
    if ($liczba > 10){
        echo("W tym zdaniu jest: $liczba słów");
    }
    else{
        echo("W tym zdaniu są: $liczba słowa");
    }

    

    

?>