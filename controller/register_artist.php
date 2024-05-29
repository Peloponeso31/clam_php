<?php

header('Content-Type: text/html; charset=utf-8');
try {
    $pdo = new PDO("mysql:host=localhost;dbname=clam", 'root', '');
    $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
    $pdo->exec("set names utf8mb4");
}
catch( PDOException $Exception ) {
    echo $Exception->getMessage();
    echo (int)$Exception->getCode();
}

if (isset($_POST['artista'])) {
    $artista = $_POST['artista'];

    $tipo = $pdo->query("SELECT `tipo` FROM catalogo_tipo_talento WHERE `id`={$artista['tipo']}")->fetch();
    $genero = $pdo->query("SELECT `genero` FROM talento_generos WHERE `id`={$artista['genero']}")->fetch();

    $artista["tipo"] = $tipo['tipo'];
    $artista['genero'] = $genero['genero'];

    $sql =  "INSERT INTO `talentos` (" . implode(', ',array_keys($artista)) . ") VALUES ('" . implode('\', \'',$artista) . "')";
    $pdo->query($sql);

    header('Location: /register_contacts.php');
}

?>
