<?php
function e(string $s) {
    return htmlspecialchars($s,ENT_QUOTES,"UTF-8");
}

function redirect(string $dest) {
    header("Location: ".$dest);
    exit;
}

function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit;
}

function isPost() {
    if($_SERVER['REQUEST_METHOD']==='POST') 
        return true;
    return false;
}

function isGet() {
    if($_SERVER['REQUEST_METHOD']==='GET')
        return true;
    return false;
}

function request($name) {
    if(isPost()) {
        if(isset($_POST[$name]))
            return $_POST[$name];
        else 
            return null;
    }

    if(isGet()) {
        if(isset($_GET[$name]))
            return $_GET[$name];
        else 
            return null;
    }

    return null;
}

//Prilikom greske kod npr submitovanja forme da ostane popunjena,
//  a ne prazna
function old($key) {
    if (isset($_SESSION['old'][$key])) {
        return $_SESSION['old'][$key];
    }
    return null;
}

function url($path='') {
    $baseUrl = "http://localhost/MiniHelpDesk/public";

    if($path==='') {
        return $baseUrl;
    }

    return rtrim($baseUrl,'/') . '/' . ltrim($path,'/');
}

function abort(int $statusCode,string $message='') {
    switch ($statusCode) {
        case 400:
            $finalMessage = $message !== '' ? $message : 'Neispravan zahtev.';
            break;

        case 401:
            $finalMessage = $message !== '' ? $message : 'Niste autorizovani.';
            break;

        case 403:
            $finalMessage = $message !== '' ? $message : 'Nemate dozvolu za pristup.';
            break;

        case 404:
            $finalMessage = $message !== '' ? $message : 'Stranica ili resurs ne postoji.';
            break;

        case 500:
        default:
            $statusCode=500;
            $finalMessage = $message !== '' ? $message : 'Došlo je do greške na serveru.';
            break;
    }

    http_response_code($statusCode);

    echo '<!doctype html>';
    echo '<html lang="sr">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<title>Greška ' . (int)$statusCode . '</title>';
    echo '</head>';
    echo '<body>';
    echo '<h1>Greška ' . (int)$statusCode . '</h1>';
    echo '<p>' . htmlspecialchars($finalMessage, ENT_QUOTES, 'UTF-8') . '</p>';
    echo '</body>';
    echo '</html>';

    exit;
}


?>