<?php
require_once __DIR__ . '/../../app/helpers.php';
require_once __DIR__ . '/../../app/auth.php';
require_once __DIR__ . '/../../app/validators.php';
require_once __DIR__ . '/../../app/repositories/TicketRepository.php';
require_once __DIR__ . '/../../app/middleware.php';


requireLogin();

$errors = [];

if (isPost()) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $priority = trim($_POST['priority'] ?? '');

    $data = [
        'title' => $title,
        'description' => $description,
        'category' => $category,
        'priority' => $priority
    ];

    $file = $_FILES['attachment'] ?? null;

    $errors = validateTicketCreate($data, $file);

    $attachmentPath = ''; // ovo ide u bazu (relativno)
    if (empty($errors) && $file && ($file['tmp_name'] ?? '') !== '') {
        $uploadDirDisk = __DIR__ . '/../uploads/'; // public/uploads/
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $newName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

        $destDisk = $uploadDirDisk . $newName;   // fizička putanja
        $attachmentPath = 'uploads/' . $newName; // relativna putanja za bazu

        if (!move_uploaded_file($file['tmp_name'], $destDisk)) {
            $errors[] = 'Greska prilikom cuvanja fajla.';
            $attachmentPath = '';
        }
    }

    if (empty($errors)) {
        $ticketRepo = new TicketRepository();

        $user = currentUser();
        $user_id = $user['id'];

        $ticketId = $ticketRepo->create(
            $user_id,
            $title,
            $description,
            $category,
            $priority,
            $attachmentPath // '' ako nema
        );

        if (!$ticketId) {
            $errors[] = 'Greska pri kreiranju ticketa.';
        } else {
            unset($_SESSION['old']);
            redirect('view.php?id=' . (int) $ticketId);
        }
    }

    if (!empty($errors)) {
        $_SESSION['old'] = [
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'priority' => $priority
        ];
    }
}
?>
<!doctype html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <title>Help Desk - Create Ticket</title>
</head>

<body>

    <h1>Create Ticket</h1>
    <p><a href="../dashboard.php">Nazad</a></p>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $e): ?>
            <?php echo e($e) . "<br>"; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Title</label><br>
        <input type="text" name="title" value="<?php echo e(old('title') ?? ''); ?>"><br>

        <label>Description</label><br>
        <textarea name="description"><?php echo e(old('description') ?? ''); ?></textarea><br>

        <label>Category</label><br>
        <input type="text" name="category" value="<?php echo e(old('category') ?? ''); ?>"><br>

        <label>Priority</label><br>
        <input type="text" name="priority" value="<?php echo e(old('priority') ?? ''); ?>"><br>

        <label>Ubaci fajl (opciono)</label><br>
        <input type="file" name="attachment"><br><br>

        <button type="submit">Submit</button>
    </form>

</body>

</html>