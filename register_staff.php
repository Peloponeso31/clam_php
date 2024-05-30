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
include 'controller/register_update_staff.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>CLAM</title>
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">
</head>


<body>
<div id="root" class="w-screen h-screen">
    <div style="position: fixed; z-index: 9999; inset: 16px; pointer-events: none;"></div>
    <div class="size-full flex flex-col gap-y-5">
        <div class="shadow-md w-full max-h-[80px] h-full p-5 flex flex-row items-center">
            <a class="text-lg bg-white p-2 relative hover:bg-gray-200 rounded-md" href="/"> Regresar </a>
        </div>
        <form action="/register_staff.php" method="POST" class="size-full overflow-hidden flex flex-col p-5">
            <section class="grid grid-cols-3 grid-rows-2 gap-5">
                <div class="flex flex-row items-center gap-5">
                        <span class="h-full flex-1 bg-red-600 rounded-xl flex items-center justify-center text-white text-xl font-bold opacity-50">
                            7+
                        </span>
                    <span class="h-full flex-1 bg-green-500 rounded-xl border-2 border-red-600 flex items-center justify-center text-white text-xl font-bold opacity-100">
                            0-3
                        </span>
                    <spaN class="h-full flex-1 bg-[#ffff00] rounded-xl border-2 border-red-600 flex items-center justify-center text-black text-xl font-bold opacity-50">
                            4-6
                        </span>
                </div>

                <input type="text" name="nombre_talento"
                       class="col-span-2 p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                       placeholder="Nombre del talento"
                       value="<?php
                       if (isset($_POST["nombre_talento"])) {
                           $talento = $_POST["nombre_talento"];
                           try {
                               if ($pdo->query("SELECT * FROM `talentos` WHERE `nombre`='$talento'")) {
                                   echo $talento;
                               } else {
                                   echo "Talento no encontrado.";
                               }
                           }
                           catch (PDOException $Exception) {
                               echo $Exception->getMessage();
                           }
                       }
                       ?>">

                <div class="flex flex-row items-center gap-5">
                    <div
                            class="flex-1 bg-red-600 h-full text-center flex items-center justify-center text-white text-xl rounded-xl">
                        <p>STAFF\CREW</p>
                    </div>
                </div>
                <div class="col-span-2 row-span-1 gap-5 flex items-center justify-center">
                    <button class="transition duration-300 ease-in-out py-2 px-8 bg-blue-600 hover:bg-blue-500 text-white text-lg rounded-lg">
                        Verificar nombre
                    </button>
                    <button class="transition duration-300 ease-in-out py-2 px-8 bg-blue-600 hover:bg-blue-500 text-white text-lg rounded-lg"
                            value="<?php
                            $numero_nuevos = isset($_POST["numero_nuevos"]) ? (int)$_POST["numero_nuevos"] : 0;
                            echo $numero_nuevos;
                            ?>" name="numero_nuevos" onclick="this.value++">
                        Añadir integrante de staff
                    </button>
                </div>
            </section>


            <section class="flex-1 mt-5 overflow-y-auto flex flex-col gap-8 p-3">

                <?php
                if (isset($_POST["nombre_talento"])) {
                    $id_talento = $pdo->query('SELECT * FROM `talentos` WHERE `nombre`="' . $_POST["nombre_talento"] . '"')->fetch(PDO::FETCH_ASSOC)['id'];
                    $consulta = $pdo->query('SELECT * FROM `staff` WHERE `id_talento`="' . $id_talento . '"');

                    foreach ($consulta->fetchAll(PDO::FETCH_ASSOC) as $row) {

                        $es_hombre = $row['genero'] == 'M' ? "checked" : "";
                        $es_mujer = $row['genero'] == 'F' ? "checked" : "";

                        $es_b = $row['nivel'] == 'B' ? "checked" : "";
                        $es_a = $row['nivel'] == 'A' ? "checked" : "";
                        $es_aa = $row['nivel'] == 'AA' ? "checked" : "";
                        $es_t = $row['nivel'] == 'T' ? "checked" : "";

                        echo "<article class=\"border border-gray-500 p-3 grid grid-cols-3 gap-2 shadow-md relative\"
                                         style=\"opacity: 1; transform: none;\">
                                    <button class=\"bg-red-500 hover:bg-red-400 transition duration-300 ease-in-out rounded-md text-xl text-white\"
                                            name='staff[{$row['id']}][eliminar]'
                                            onclick='this.value = true'>
                                        Remover integrante
                                    </button>
                                    <input type=\"text\" maxlength=\"100\" name=\"staff[{$row["id"]}][nombre_apellidos]\" required
                                           class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                           placeholder=\"Nombre y apellidos\"
                                           value='{$row["nombre_apellidos"]}'>
                                    <div class=\"flex flex-wrap justify-around items-center\">
                                        <div>
                                            <input type='radio' name='staff[{$row["id"]}][genero]' value='M' id='masculino' $es_hombre>
                                            <label class='text-red-600' for='masculino'> Masculino </label>
                                        </div>
                                        <div>
                                            <input type='radio' name='staff[{$row["id"]}][genero]' value='F' id='femenino' $es_mujer>
                                            <label class='text-red-600' for='femenino'> Femenino </label>
                                        </div>
                                    </div>
                                    <input type=\"text\" maxlength=\"50\" name=\"staff[{$row["id"]}][puesto]\" required
                                           class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                           placeholder=\"Puesto que ocupa\"
                                           value='{$row["puesto"]}'>
                                    <div class=\"flex flex-wrap justify-around items-center\">
                                        <div>
                                            <input type='radio' name='staff[{$row["id"]}][nivel]' value='B' id='B' $es_a>
                                            <label class='text-red-600' for='B'> B </label>
                                        </div>
                                            
                                        <div>
                                            <input type='radio' name='staff[{$row["id"]}][nivel]' value='A' id='A' $es_a>
                                            <label class='text-red-600' for='A'> A </label>
                                        </div>
                                        
                                        <div>
                                            <input type='radio' name='staff[{$row["id"]}][nivel]' value='AA' id='AA' $es_aa>
                                            <label class='text-red-600' for='AA'> AA </label>
                                        </div>
                                        
                                        <div>
                                            <input type='radio' name='staff[{$row["id"]}][nivel]' value='T' id='T' $es_t>
                                            <label class='text-red-600' for='T'> T </label>
                                        </div>
                                    </div>
                                    <input type=\"email\" maxlength=\"100\" name=\"staff[{$row["id"]}][correo]\" required
                                           class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                           placeholder=\"Correo electrónico\"
                                           value='{$row["correo"]}'>
                                    <input type=\"text\" maxlength=\"10\" minlength=\"10\"
                                           name=\"staff[{$row["id"]}][telefono]\" 
                                           class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                           placeholder=\"Teléfono celular\"
                                           value='{$row["telefono"]}'>
                                    <input type=\"date\" name=\"staff[{$row["id"]}][fecha_nacimiento]\" required
                                           class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                           placeholder=\"Fecha de nacimiento\"
                                           value='{$row["fecha_nacimiento"]}'>
                                    <input type=\"text\" maxlength=\"100\" name=\"staff[{$row["id"]}][nacionalidad]\" required
                                           class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                           placeholder=\"Nacionalidad\"
                                           value='{$row["nacionalidad"]}'>
                                    <input type=\"text\" maxlength=\"100\" name=\"staff[{$row["id"]}][no_pasaporte]\" 
                                           class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                           placeholder=\"Número de pasaporte\"
                                           value='{$row["no_pasaporte"]}'>
                                </article>";
                    }
                }


                ?>


                <?php
                for ($i = 0; $i < $numero_nuevos; $i++) {
                    echo "<article class=\"border border-gray-500 p-3 grid grid-cols-3 gap-2 shadow-md relative\"
                                 style=\"opacity: 1; transform: none;\">
                            <button class=\"bg-red-500 hover:bg-red-400 transition duration-300 ease-in-out rounded-md text-xl text-white\"
                                    name=\"numero_nuevos\"
                                    value='\" . ($numero_nuevos - 1) . \"'>
                                Remover integrante
                            </button>
                            <input type='text' name='nuevos_staff[$i][id_talento]' value='$id_talento' hidden>
                            <input type=\"text\" maxlength=\"100\" name=\"nuevos_staff[$i][nombre_apellidos]\" required
                                   class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                   placeholder=\"Nombre y apellidos\">
                            <div class=\"flex flex-wrap justify-around items-center\">
                                <div>
                                    <input type='radio' name='nuevos_staff[$i][genero]' value='M' id='masculino' checked>
                                    <label class='text-red-600' for='masculino'> Masculino </label>
                                </div>
                                <div>
                                    <input type='radio' name='nuevos_staff[$i][genero]' value='F' id='femenino'>
                                    <label class='text-red-600' for='femenino'> Femenino </label>
                                </div>
                            </div>
                            <input type=\"text\" maxlength=\"50\" name=\"nuevos_staff[$i][puesto]\" required
                                   class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                   placeholder=\"Puesto que ocupa\">
                            <div class=\"flex flex-wrap justify-around items-center\">
                                <div>
                                    <input type='radio' name='nuevos_staff[$i][nivel]' value='B' id='B' checked>
                                    <label class='text-red-600' for='B'> B </label>
                                </div>
                                    
                                <div>
                                    <input type='radio' name='nuevos_staff[$i][nivel]' value='A' id='A'>
                                    <label class='text-red-600' for='A'> A </label>
                                </div>
                                
                                <div>
                                    <input type='radio' name='nuevos_staff[$i][nivel]' value='AA' id='AA'>
                                    <label class='text-red-600' for='AA'> AA </label>
                                </div>
                                
                                <div>
                                    <input type='radio' name='nuevos_staff[$i][nivel]' value='T' id='T'>
                                    <label class='text-red-600' for='T'> T </label>
                                </div>
                            </div>
                            <input type=\"email\" maxlength=\"100\" name=\"nuevos_staff[$i][correo]\" required
                                   class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                   placeholder=\"Correo electrónico\">
                            <input type=\"text\" maxlength=\"10\" minlength=\"10\"
                                   name=\"nuevos_staff[$i][telefono]\" 
                                   class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                   placeholder=\"Teléfono celular\">
                            <input type=\"date\" name=\"nuevos_staff[$i][fecha_nacimiento]\" required
                                   class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                   placeholder=\"Fecha de nacimiento\">
                            <input type=\"text\" maxlength=\"100\" name=\"nuevos_staff[$i][nacionalidad]\" required
                                   class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                   placeholder=\"Nacionalidad\">
                            <input type=\"text\" maxlength=\"100\" name=\"nuevos_staff[$i][no_pasaporte]\" 
                                   class=\"p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full\"
                                   placeholder=\"Número de pasaporte\">
                        </article>";
                }

                ?>

            </section>
            <section class="py-5 flex justify-center">
                <button type="submit"
                        class="transition duration-700 ease-in-out py-2 px-8 bg-blue-600 text-white text-lg rounded-lg">
                    Registrar
                    staff
                </button>
            </section>
        </form>
    </div>
</div>
</body>

</html>