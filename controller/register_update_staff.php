<?php

// Modificaciones
if (isset($_POST['staff'])) {
    $staff = $_POST['staff'];
    foreach ($staff as $key => $value) {
        $value = array_filter($value);
        $last_key = array_search(end($value), $value);

        $sql = "UPDATE `staff` SET ";
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
if (isset($_POST['staff'])) {
    $staff = $_POST['staff'];

    foreach ($staff as $key => $value) {
        if (isset($value['eliminar'])) {
            if ($value['eliminar']) {
                $sql = "DELETE FROM `staff` WHERE `id` = $key ";
                $pdo->query($sql);
            }
        }
    }
}

// Inserciones
if (isset($_POST['nuevos_staff'])) {
    $staff = $_POST['nuevos_staff'];
    foreach ($staff as $integrante) {
        $integrante = array_filter($integrante);
        $sql =  "INSERT INTO `staff` (" . implode(', ',array_keys($integrante)) . ") VALUES ('" . implode('\', \'',$integrante) . "')";
        try {
            $pdo->query($sql);
        }
        catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

?>