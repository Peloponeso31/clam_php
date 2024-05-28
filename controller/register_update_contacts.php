<?php

// Modificaciones
if (isset($_POST['contactos'])) {
    $contactos = $_POST['contactos'];
    foreach ($contactos as $key => $value) {
        $value = array_filter($value);
        $last_key = array_search(end($value), $value);

        $sql = "UPDATE `contactos` SET ";
        foreach ($value as $atributo_contacto => $valor_contacto) {
            if ($atributo_contacto != 'eliminar') {
                if ($atributo_contacto == $last_key) {
                    $sql .= "`$atributo_contacto`='$valor_contacto' ";
                }
                else {
                    $sql .= "`$atributo_contacto`='$valor_contacto', ";
                }
            }
        }
        $sql .= "WHERE `id` = $key ";
        try {
            $pdo->query($sql);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

// Eliminaciones
if (isset($_POST['contactos'])) {
    $contactos = $_POST['contactos'];

    foreach ($contactos as $key => $value) {
        if (isset($value['eliminar'])) {
            if ($value['eliminar']) {
                $sql = "DELETE FROM `contactos` WHERE `id` = $key ";
                $pdo->query($sql);
            }
        }
    }
}

// Inserciones
if (isset($_POST['nuevos_contactos'])) {
    $contactos = $_POST['nuevos_contactos'];
    foreach ($contactos as $contacto) {
        $contacto = array_filter($contacto);
        $sql =  "INSERT INTO `contactos` (" . implode(', ',array_keys($contacto)) . ") VALUES ('" . implode('\', \'',$contacto) . "')";
        try {
            $pdo->query($sql);
        }
        catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

?>