<?php
header('Content-Type: text/html; charset=utf-8');
try {
    $pdo = new PDO("mysql:host=localhost;dbname=clam", 'root', '');
    $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("set names utf8mb4");
} catch (PDOException $Exception) {
    echo $Exception->getMessage();
    echo (int)$Exception->getCode();
}

include 'controller/register_update_contacts.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>CLAM</title>
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">
</head>

<body class="">
<div id="root" class="w-screen h-screen">
    <div style="position: fixed; z-index: 9999; inset: 16px; pointer-events: none;"></div>
    <div class="size-full flex flex-col gap-y-5">
        <div class="shadow-md w-full max-h-[80px] h-full p-5 flex flex-row items-center"><a
                    class="text-lg bg-white p-2 relative hover:bg-gray-200 rounded-md" href="/">Regresar</a></div>
        <form id="elementos_agregar" hidden></form>
        <form action="/register_contacts.php" method="POST" class="size-full overflow-hidden flex flex-col p-5">
            <section class="grid grid-cols-3 grid-rows-2 gap-5">
                <div class="flex flex-row items-center gap-5"><span
                            class="h-full flex-1 bg-red-600 rounded-xl flex items-center justify-center text-white text-xl font-bold opacity-50">
              <p>7+</p>
            </span><span
                            class="h-full flex-1 bg-green-500 rounded-xl border-2 border-red-600 flex items-center justify-center text-white text-xl font-bold opacity-100">
              <p>0-3</p>
            </span><span
                            class="h-full flex-1 bg-[#ffff00] rounded-xl border-2 border-red-600 flex items-center justify-center text-black text-xl font-bold opacity-50">
              <p>4-6</p>
            </span>
                </div>
                <input type="text" name="nombre_talento"
                       class="col-span-2 p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                       placeholder="Nombre del talento" value="<?php
                if (isset($_POST["nombre_talento"])) {
                    if ($pdo->query('SELECT * FROM `talentos` WHERE `nombre`="' . $_POST["nombre_talento"] . '"')) {
                        echo $_POST["nombre_talento"];
                    } else {
                        echo "Talento no encontrado";
                    }
                }
                ?>">

                <div class="flex flex-row items-center gap-5">
                    <div
                            class="flex-1 bg-red-600 h-full text-center flex items-center justify-center text-white text-xl rounded-xl">
                        <p>CONTACTOS</p>
                    </div>
                </div>
                <div class="col-span-2 row-span-1 gap-5 flex items-center justify-center">
                    <button
                            class="transition duration-300 ease-in-out py-2 px-8 bg-blue-600 hover:bg-blue-500 text-white text-lg rounded-lg">
                        Verificar nombre
                    </button>
                    <button class="transition duration-300 ease-in-out py-2 px-8 bg-blue-600 hover:bg-blue-500 text-white text-lg rounded-lg"
                    value="<?php
                    $numero_nuevos = isset($_POST["numero_nuevos"]) ? (int) $_POST["numero_nuevos"] : 0;
                    echo $numero_nuevos;
                    ?>" name="numero_nuevos" onclick="this.value++">
                        Añadir contacto
                    </button>
                </div>
            </section>


            <section class="flex-1 mt-5 overflow-y-auto flex flex-col gap-8 p-3">
                <?php
                if (isset($_POST["nombre_talento"])) {
                    $id_talento = $pdo->query('SELECT * FROM `talentos` WHERE `nombre`="' . $_POST["nombre_talento"] . '"')->fetch(PDO::FETCH_ASSOC)['id'];
                    $consulta = $pdo->query('SELECT * FROM `contactos` WHERE `id_talento`="' . $id_talento . '"');

                    foreach ($consulta->fetchAll(PDO::FETCH_ASSOC) as $row) {
                        echo "<article class=\"border border-gray-500 p-3 grid grid-cols-3 gap-2 shadow-md relative\"
                        style=\"opacity: 1; transform: none;\">
                        <button
                          class=\"bg-red-500 hover:bg-red-400 transition duration-300 ease-in-out rounded-md text-xl text-white\"
                          name='contactos[{$row['id']}][eliminar]'
                          onclick='this.value = true'>
                          Remover contacto
                        </button>
                        <input type=\"text\" name=\"contactos[{$row['id']}][representante]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Empresa \\ Representante\"
                          required
                          value=\"{$row['representante']}\">
                        <input type=\"text\" name=\"contactos[{$row['id']}][nombre_apellidos]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Nombre y apellidos\"
                          required
                          value=\"{$row['nombre_apellidos']}\">
                        <input type=\"text\" name=\"contactos[{$row['id']}][puesto]\"
                          required
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Puesto que ocupa\"
                          value=\"{$row['puesto']}\">
                        <input type=\"text\" name=\"contactos[{$row['id']}][pagina_web]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Página Web\"
                          value=\"{$row['pagina_web']}\">
                        <input type=\"email\" name=\"contactos[{$row['id']}][correo]\"
                          required
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Correo electrónico\"
                          value=\"{$row['correo']}\">
                        <input type=\"text\" maxlength=\"10\" minlength=\"10\"
                          name=\"contactos[{$row['id']}][telefono_celular]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Teléfono celular\"
                          value=\"{$row['telefono_celular']}\">
                        <input type=\"text\" name=\"contactos[{$row['id']}][instagram]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Instagram\"
                          value=\"{$row['instagram']}\">
                        <input type=\"date\" name=\"contactos[{$row['id']}][fecha_nacimiento]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          required
                          placeholder=\"Fecha de nacimiento\"
                          value=\"{$row['fecha_nacimiento']}\">
                        <input type=\"text\" maxlength=\"10\" minlength=\"10\"
                          name=\"contactos[{$row['id']}][telefono_oficina]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Teléfono oficina\"
                          value=\"{$row['telefono_oficina']}\">
                        <input type=\"text\" name=\"contactos[{$row['id']}][facebook]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Facebook\"
                          value=\"{$row['facebook']}\">
                        <input type=\"text\" maxlength=\"10\" minlength=\"10\" name=\"contactos[{$row['id']}][telefono_otro]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Teléfono otro\"
                          value=\"{$row['telefono_otro']}\">
                      </article>";
                    }
                }
                ?>

                <?php
                for ($i = 0; $i < $numero_nuevos; $i++) {
                    echo "<article class=\"border border-gray-500 p-3 grid grid-cols-3 gap-2 shadow-md relative\"
                        style=\"opacity: 1; transform: none;\">
                        
                        <button class=\"bg-red-500 hover:bg-red-400 transition duration-300 ease-in-out rounded-md text-xl text-white\"
                          name='numero_nuevos'
                          value='".($numero_nuevos - 1)."'>
                          Remover contacto
                        </button>
                        <input type='hidden' name='nuevos_contactos[{$i}][id_talento]' value='{$id_talento}'>
                        <input type=\"text\" name=\"nuevos_contactos[{$i}][representante]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          required
                          placeholder=\"Empresa \\ Representante\">
                        <input type=\"text\" name=\"nuevos_contactos[{$i}][nombre_apellidos]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          required
                          placeholder=\"Nombre y apellidos\">
                        <input type=\"text\" name=\"nuevos_contactos[{$i}][puesto]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full \"
                          required
                          placeholder=\"Puesto que ocupa\">
                        <input type=\"text\" name=\"nuevos_contactos[{$i}][pagina_web]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Página Web\">
                        <input type=\"email\" name=\"nuevos_contactos[{$i}][correo]\"
                          required
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Correo electrónico\">
                        <input type=\"text\" maxlength=\"10\" minlength=\"10\"
                          name=\"nuevos_contactos[{$i}][telefono_celular]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Teléfono celular\">
                        <input type=\"text\" name=\"nuevos_contactos[{$i}][instagram]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Instagram\">
                        <input type=\"date\" name=\"nuevos_contactos[{$i}][fecha_nacimiento]\"
                          required
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Fecha de nacimiento\">
                        <input type=\"text\" maxlength=\"10\" minlength=\"10\"
                          name=\"nuevos_contactos[{$i}][telefono_oficina]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Teléfono oficina\">
                        <input type=\"text\" name=\"nuevos_contactos[{$i}][facebook]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Facebook\">
                        <input type=\"text\" maxlength=\"10\" minlength=\"10\" name=\"nuevos_contactos[{$i}][telefono_otro]\"
                          class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                          placeholder=\"Teléfono otro\">
                      </article>";
                }
                ?>
            </section>

            <section class="py-5 flex justify-center">
                <button type="submit"
                        class="transition duration-300 ease-in-out py-2 px-8 bg-blue-600 hover:bg-blue-500 text-white text-lg rounded-lg">
                    Registrar
                    contacto(s)
                </button>
            </section>
        </form>
    </div>
</div>
</body>

<script>

</script>

</html>