<?php

if (isset($_POST['artista'])) {
    $artista = $_POST['artista'];

    $tipo = $pdo->query("SELECT `tipo` FROM catalogo_tipo_talento WHERE `id`={$artista['tipo']}")->fetch();
    $genero = $pdo->query("SELECT `genero` FROM talento_generos WHERE `id`={$artista['genero']}")->fetch();

    $artista["tipo"] = $tipo['tipo'];
    $artista['genero'] = $genero['genero'];

    $sql =  "INSERT INTO `talentos` (" . implode(', ',array_keys($artista)) . ") VALUES ('" . implode('\', \'',$artista) . "')";
    $pdo->query($sql);

    header('Location: ./register_contacts.php');
    exit();
}
?>
