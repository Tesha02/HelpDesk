<!doctype html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <title>Help Desk - Create Ticket</title>
</head>
<body>
<h1>Create Ticket</h1>

<form method="POST" enctype="multipart/form-data">
    <label>Title</label><br>
    <input type="text" name="title"><br>
    <label>Description</label><br>
    <input type="textarea" name="description"><br>
    <label>Category</label><br>
    <input type="text" name="category"><br>
    <label>Priority</label><br>
    <input type="text" name="priority"><br>
    <label>Ubaci fajl</label><br>
    <input type="file" name="attachment"><br>
    <button type="submit">Submit</button>
</form>

</body>
</html>
