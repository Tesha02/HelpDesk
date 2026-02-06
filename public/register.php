<?php
require_once "../app/helpers.php";
require_once "../app/auth.php";

$errors = [];
if (isPost()) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confPass = $_POST['confirmPassword'];
    $errors = register($username, $email, $pass, $confPass);
    if (empty($errors)) {
        unset($_SESSION['old']);
        redirect("index.php");
    } else {
        $_SESSION['old'] = [
            'username' => $username,
            'email' => $email
        ];
    }
}
?>

<!doctype html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <title>Help Desk - Register</title>
</head>

<body>
    <h1>REGISTER</h1>
    <form method="POST">
        <label>Username: </label><br>
        <input type="text" name="username" value=<?php echo e(old('username') ?? "") ?>><br>
        <label>Email: </label><br>
        <input type="email" name="email" value=<?php echo e(old('email') ?? "") ?>><br>
        <label>Password: </label><br>
        <input type="password" name="password"><br>
        <label>Confirm password: </label><br>
        <input type="password" name="confirmPassword"><br><br>
        <button type="submit">Registruj se</button>
        <?php unset($_SESSION['old']); ?>

    </form>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $e): ?>
            <?php echo e($e) . "<br>"; ?>
        <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>