<?php 

require 'connec.php';

$connection = createConnection();

$query = "SELECT * FROM friend";
$statement = $connection->query($query);
$friends = $statement->fetchAll();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$data = array_map('trim', $_POST);
$data = array_map('htmlentities', $data);

    if (!isset($data['firstname'])||empty($data['firstname']))
    {
        $errors[] = 'Veuillez rentrer un prénom.';
    }

    if (!isset($data['lastname'])||empty($data['lastname']))
    {
        $errors[] = 'Veuillez rentrer un Nom.';
    }

    if(strlen($data['firstname'])> 45)
    {
        $errors[] = "Nous n'acceptons pas les noms trop longs.";
    }

    if(strlen($data['lastname'])> 45)
    {
        $errors[] = "T'es pas Carlos Sainz Jr mon reuf.";
    }

    if (empty($errors))
    {
        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $connection->prepare($query);
        $statement->bindValue(':firstname', $data['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $data['lastname'], \PDO::PARAM_STR);
        $statement->execute();
    
        header('Location: /my-app/Quete_PDO/index.php');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO</title>
</head>
<body>
    <h2>Friends' list</h2>
    <?php foreach ($friends as $data) : ?>
        <ul>
        <?= "<li>" . $data['firstname'] . ' ' . $data['lastname'] . "</li>" ?>
        </ul>
    <?php endforeach ?>

    <form action = "" method ="post">
        <input type = "text" name = "firstname" placeholder = "firstname">
    <br>
        <input type = "text" name = "lastname" placeholder = "lastname">
    <br>
        <input type = "submit">
</body>
</html>