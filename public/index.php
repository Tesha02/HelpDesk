<?php
require_once "../app/helpers.php";
require_once "../app/auth.php";

$errors = [];
$email = "";
$pass = "";
if (isPost()) {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $errors = login($email, $pass);
    if (empty($errors)) {
        unset($_SESSION['old']);
        redirect("dashboard.php");
    } else {
        $_SESSION['old'] = [
            'email' => $email
        ];
    }
}
?>
<!doctype html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <title>Help Desk - Login</title>
</head>

<body>
    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $e): ?>
            <?php echo e($e) . "<br>" ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <h1>LOGIN</h1>
    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" value=<?php echo e(old('email') ?? ""); ?> /><br>
        <label>Password:</label><br>
        <input type="password" name="password" /><br><br>
        <button type="submit">Uloguj se</button>
        <?php unset($_SESSION['old']); ?>
    </form>


</body>

</html>