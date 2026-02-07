<?php
$errors=[];
function validateRegister(array $data): array {
    $errors=[];
    if(!isset($data['username']) || strlen($data['username'])<3) 
        $errors[]="Username mora da ima najmanje 3 karaktera";
    
    if (!isset($data['email']) || !preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $data['email'])) 
        $errors[]="Nevalidan format email-a";

    if(!isset($data['password']) || strlen($data['password'])<6) 
        $errors[]="Lozinka mora da ima najmanje 6 karaktera";
    
    if(!isset($data['password']) || !isset($data['confirmPassword']) || $data['password'] !== $data['confirmPassword'])
        $errors[]="Lozinke se ne poklapaju";

    return $errors;
}

function validateLogin(array $data): array {
    $errors=[];
    if (!isset($data['email']) || !preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $data['email'])) 
        $errors[]="Nevalidan format email-a";

    if(!isset($data['password']) || strlen($data['password'])<6) 
        $errors[]="Lozinka mora da ima najmanje 6 karaktera";

    return $errors;
}

function validateTicketCreate(array $data, array $file=null): array{
    $errors = [];

    if (!isset($data['title']) || strlen(trim($data['title'])) < 3) {
        $errors[] = 'Naslov mora imati najmanje 3 karaktera.';
    }

    if (!isset($data['description']) || strlen(trim($data['description'])) < 10) {
        $errors[] = 'Opis mora imati najmanje 10 karaktera.';
    }

    $allowedCategory=['billing','technical','other'];
    if(!isset($data['category']) || !in_array($data['category'],$allowedCategory,true)) 
        $errors[]='Nevalidna kategorija';

    $allowedPriorities=['low','medium','high'];
    if(!isset($data['priority']) || !in_array($data['priority'],$allowedPriorities,true)) 
        $errors[]='Nevalidan prioritet';

    if($file && isset($file['tmp_name']) && $file['tmp_name']!=="") {
        if($file['error']!==UPLOAD_ERR_OK)
            $errors[]="Fajl nije uploadovan";
        else {
            $maxBytes=5*1024*1024;
            if($file['size']>$maxBytes)
                $errors[]="Fajl je prevelik";
            else {
                $allowedExt=["jpg", "jpeg", "png", "pdf"];
                $ext=strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
                if(!in_array($ext,$allowedExt,true))
                    $errors[]='Dozvoljeni fajlovi su tipa: jpg, jpeg, png, pdf';
            }
        }
    }
    return $errors;
}

function validateTicketUpdate(array $data): array {

}

?>