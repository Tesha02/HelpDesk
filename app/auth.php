<?php 
session_start();
require_once "validators.php";
require_once "repositories/UserRepository.php";

function register($username,$email, $password,$confirmPassword)  {
    $data=[
        'username'=>trim($username),
        'email'=>$email, 
        'password'=>$password,
        'confirmPassword'=>$confirmPassword
    ];
    $errors=validateRegister($data);
    
    if(!empty($errors)) {
        return $errors;
    }

    $userRepo=new UserRepository();
    $existing=$userRepo->findByEmail($data['email']);
    if($existing) {
        return ['Email je vec zauzet'];
    }

    $password_hash=password_hash($password,PASSWORD_DEFAULT);
    $user_id=$userRepo->create($username,$email,$password_hash,'user');

    if(!$user_id) {
        return ['Greška pri kreiranju naloga. Pokušajte ponovo.'];
    }

    return [];
}

function login($email, $password) {
    $data=[
        'email'=>$email, 
        'password'=>$password
    ];
    $errors=validateLogin($data);
    if(!empty($errors)) {
        return $errors;
    }

    $userRepo=new UserRepository();
    $user=$userRepo->findByEmail($email);
    if(!$user) {
        return ['Pogresan email ili lozinka'];
    }
    if(!password_verify($data['password'],$user['password_hash'])) {
        return ['Pogresan email ili lozinka'];
    }

    $_SESSION['user_id']=$user['id'];
    $_SESSION['role']=$user['role'] ?? 'user';

    return [];
}

function logout() {
    session_unset();
    session_destroy();
    redirect("index.php");
}

function currentUser() {
    $id=$_SESSION['user_id'];
    $userRepo=new UserRepository();
    $user=$userRepo->findById($id);
    return $user;
}

function isLoggedIn(): bool {
    if(isset($_SESSION['user_id']))
        return true;
    return false;           
}

function isAdmin() {
    $role=$_SESSION['role'] ?? '';
    if($role==='admin') 
        return true;
    return false;
}


?>