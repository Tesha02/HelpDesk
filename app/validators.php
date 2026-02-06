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

?>