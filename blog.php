<?php

    $postsdir = __DIR__ . DIRECTORY_SEPARATOR . 'posts';

    if(!is_dir($postsdir)){
        mkdir($postsdir, 0777, true);
    }

    function pause(){
        readline("Naciśnij enter aby kontunuować.");
    }

    function lista($postsdir){
        $files = scandir($postsdir);
        $posts = [];
        foreach ($files as $f) {
        if ($f === '.' || $f === '..') continue;
    }
        if (is_file($postsdir . DIRECTORY_SEPARATOR . $f)) {
            $posts[] = $f;
     }
      return $posts;
    }
    
    function pokaz($postsdir) {
    $posts = lista($postsdir);
        if (count($posts) === 0) {
    echo "Brak wpisów.\n";
    return;
    }
    echo "Lista wpisów:\n";
    foreach ($posts as $i => $file) {
        $content = file_get_contents($postsdir . DIRECTORY_SEPARATOR . $file);
        $firstLine = strtok($content, "\n");
        $title = $firstLine !== false && trim($firstLine) !== '' ? trim($firstLine) : '(brak tytułu)';
        printf("[%d] %s — %s\n", $i + 1, $file, $title);
    }
}

    function stworz($postsdir) {
    $title = readline("Tytuł (krótki): ");
    $body = "";
    echo "Wprowadź treść wpisu. Zakończ wpis linią z samym '.' i naciśnij Enter.\n";
    while (true) {
        $line = readline();
        if ($line === '.') break;
        $body .= $line . PHP_EOL;
    }
    $filename = time() . '_' . substr(md5((string)microtime(true)), 0, 6) . '.txt';
    $full = $postsdir . DIRECTORY_SEPARATOR . $filename;
    $content = trim($title) . PHP_EOL . PHP_EOL . $body;
    file_put_contents($full, $content);
    echo "Wpis zapisany jako $filename\n";
}

function zobacz($postsdir) {
    $posts = lista($postsdir);
    if (count($posts) === 0) {
        echo "Brak wpisów do wyświetlenia.\n";
        return;
    }
    pokaz($postsdir);
    $num = (int)readline("Podaj numer wpisu do wyświetlenia: ");
    if ($num < 1 || $num > count($posts)) {
        echo "Nieprawidłowy numer.\n";
        return;
    }
    $file = $posts[$num - 1];
    $content = file_get_contents($postsdir . DIRECTORY_SEPARATOR . $file);
    echo "===== $file =====\n\n";
    echo $content . "\n";

}

function edytuj($postsdir) {
    $posts = lista($postsdir);
    if (count($posts) === 0) {
        echo "Brak wpisów do edycji.\n";
        return;
    }
    pokaz($postsdir);
    $num = (int)readline("Podaj numer wpisu do edycji: ");
    if ($num < 1 || $num > count($posts)) {
        echo "Nieprawidłowy numer.\n";
        return;
    }
    $file = $posts[$num - 1];
    $path = $postsdir . DIRECTORY_SEPARATOR . $file;
    $old = file_get_contents($path);
    echo "Aktualna zawartość:";
    echo $old . " ";
    $nowyTytul = readline("Nowy tytuł (zostaw puste aby nie zmieniać): ");
    echo "Wprowadź nową treść. Zakończ linią z samym '.end' i naciśnij Enter.\n";
    $body = "";
    $first = readline();
    if ($first === '.keep') {
        if (trim($newTitle) === '') {
            echo "Brak zmian.\n";
            return;
        } else {
            $parts = preg_split('/\R/', $old, 2);
            $rest = isset($parts[1]) ? $parts[1] : "";
            $content = trim($newTitle) . PHP_EOL . PHP_EOL . ltrim($rest);
            file_put_contents($path, $content);
            echo "Zmieniono tytuł.\n";
            return;
        }
    } else {
        if ($first !== null) $body .= $first . PHP_EOL;
        while (true) {
            $line = readline();
            if ($line === '.end') break;
            $body .= $line . PHP_EOL;
        }
        $titleToSave = trim($nowyTytul) !== '' ? trim($nowyTytul) : strtok($old, "\n");
        $content = trim($titleToSave) . PHP_EOL . PHP_EOL . $body;
        file_put_contents($path, $content);
        echo "Wpis zaktualizowany.\n";
    }
}

function usun($postsdir) {
    $posts = lista($postsdir);
    if (count($posts) === 0) {
        echo "Brak wpisów do usunięcia.\n";
        return;
    }
    pokaz($postsdir);
    $num = (int)readline("Podaj numer wpisu do usunięcia: ");
    if ($num < 1 || $num > count($posts)) {
        echo "Nieprawidłowy numer.\n";
        return;
    }
    $file = $posts[$num - 1];
    unlink($postsdir . DIRECTORY_SEPARATOR . $file);
     echo "Usunięto $file\n";
}

 while (true) {
    echo "1) Pokaż listę wpisów\n";
    echo "2) Dodaj nowy wpis\n";
    echo "3) Pokaż wpis\n";
    echo "4) Edytuj wpis\n";
    echo "5) Usuń wpis\n";
    echo "0) Wyjście\n";
    $choice = trim(readline("Wybierz opcję: "));

    switch ($choice) {
        case '1':
            pokaz($postsdir);
            pause();
            break;
        case '2':
            stworz($postsdir);
            pause();
            break;
        case '3':
            zobacz($postsdir);
            pause();
            break;
        case '4':
            edytuj($postsdir);
            pause();
            break;
        case '5':
            usun($postsdir);
            pause();
            break;
        case '0':
            echo "Do widzenia!\n";
            exit(0);
        default:
            echo "Nieznana opcja.\n";
            pause();
            break;
    }
}


?>