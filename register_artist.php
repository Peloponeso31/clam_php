<?php
header('Content-Type: text/html; charset=utf-8');
try {
    $pdo = new PDO("mysql:host=localhost;dbname=syslamco_clam", 'syslamco_franciscotv', 'L]ig7Uq?aw@!');
    $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
    $pdo->exec("set names utf8mb4");
} catch (PDOException $Exception) {
    echo $Exception->getMessage();
    echo (int)$Exception->getCode();
}

if (isset($_POST['id_talento'])) {
    $id_talento = $_POST['id_talento'];
    $talento = $pdo->query("SELECT * FROM `talentos` WHERE `id`=$id_talento")->fetch();
}

if (isset($_POST['artista'])) {
    $artista = $_POST['artista'];

    $tipo = $pdo->query("SELECT `tipo` FROM catalogo_tipo_talento WHERE `id`={$artista['tipo']}")->fetch();
    $genero = $pdo->query("SELECT `genero` FROM talento_generos WHERE `id`={$artista['genero']}")->fetch();

    $artista["tipo"] = $tipo['tipo'];
    $artista['genero'] = $genero['genero'];

    $sql = "INSERT INTO `talentos` (" . implode(', ', array_keys($artista)) . ") VALUES ('" . implode('\', \'', $artista) . "')";
    $pdo->query($sql);

    header('Location: ./register_contacts.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">
    <title>CLAM</title>
</head>

<body>
<div id="root" class="w-screen h-screen">
    <div style="position: fixed; z-index: 9999; inset: 16px; pointer-events: none;"></div>
    <div class="size-full flex flex-col gap-y-5">
        <div class="shadow-md w-full max-h-[80px] h-full p-5 flex flex-row items-center">
            <a class="text-lg bg-white p-2 relative hover:bg-gray-200 rounded-md" href="./"> Regresar </a>
        </div>
        <form class="w-full grid grid-cols-3 grid-rows-8 gap-5 place-items-center overflow-y-hidden p-5"
              action="./register_artist.php"
              method="POST">
            <div
                    class="overflow-hidden relative flex flex-col size-full justify-center items-center rounded-2xl border border-black drop-shadow-md col-span-1 row-span-3">
                <input type="text" name="artista[foto]" id="base64_image" hidden>
                <input type="file" accept="image/*" id="input_imagenes" hidden required onchange="convert_img_base64()">
                <button class="size-full flex justify-center items-center text-black focus:outline-none p-5 text-center bg-white"
                        onClick="document.getElementById('input_imagenes').click()"
                        type="button">
                    <p class="text-2xl text-red-600">Foto (Máximo 15MB)</p>
                </button>
                <img id="imagen_artista" src="<?php if (isset($talento['foto'])) {
                    echo $talento['foto'];
                } ?>" onClick="document.getElementById('input_imagenes').click()">
            </div>

            <input type="text" name="artista[nombre]" required
                   class="col-span-2 p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                   placeholder="Nombre del talento"
                   value="<?php if (isset($talento['nombre'])) {
                       echo $talento['nombre'];
                   } ?>">
            <div class="relative size-full"><label
                        class="absolute -top-3 left-5 text-sm text-center bg-white text-gray-500 z-10">
                    Tipo del talento<span class="text-red-500">*</span></label>
                <div class="size-full z-[500]">
                    <div class="relative font-montserrat size-full">
                        <select class="border border-black rounded-md w-full text-start py-1 px-3 cursor-pointer text-2xl  col-span-2 px-4 rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center max-h-[100px] size-full"
                                id="tipos_talentos"
                                name="artista[tipo]"
                                onchange="hide_nonselected_elements()">
                            <?php
                            foreach ($pdo->query("SELECT * FROM `catalogo_tipo_talento`") as $fila) {
                                echo '<option value="' . $fila['id'] . '">' . $fila['tipo'] . '</option>';
                            }
                            ?>
                        </select>
                        <svg stroke="currentColor" fill="currentColor"
                             stroke-width="0" viewBox="0 0 24 24"
                             class="absolute w-10 inset-y-[35%] right-[2px] cursor-pointer bg-white" height="1.5em"
                             width="1.5em" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" d="M0 0h24v24H0V0z"></path>
                            <path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path>
                        </svg>
                    </div>
                    <div class="w-full relative z-50"></div>
                </div>
            </div>
            <div class="relative size-full"><label
                        class="absolute -top-3 left-5 text-sm text-center bg-white text-gray-500 z-10">Género del
                    talento<span class="text-red-500">*</span></label>
                <div class="size-full z-[500]">
                    <div class="relative font-montserrat size-full">
                        <select class="border border-black rounded-md w-full text-start py-1 px-3 cursor-pointer text-2xl  col-span-2 px-4 rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center max-h-[100px] size-full"
                                name="artista[genero]" id="generos">
                            <?php
                            foreach ($pdo->query("SELECT * FROM `talento_generos`") as $fila) {
                                echo '<option name="' . $fila['tipo_talento_id'] . '" value="' . $fila['id'] . '">' . $fila['genero'] . '</option>';
                            }
                            ?>
                        </select>
                        <svg stroke="currentColor" fill="currentColor"
                             stroke-width="0" viewBox="0 0 24 24"
                             class="absolute w-10 inset-y-[35%] right-[2px] cursor-pointer bg-white" height="1.5em"
                             width="1.5em" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" d="M0 0h24v24H0V0z"></path>
                            <path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <textarea
                    class="resize-none col-span-2 row-span-2 p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                    name="artista[semblanza]" required></textarea>
            <input type="text" name="artista[video]" required
                   class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                   placeholder="Video">
            <div class="row-span-3 grid grid-cols-1 grid-rows-3 size-full gap-5">
                <div class="flex flex-row items-center gap-5 opacity-50"><span
                            class="h-full flex-1 bg-red-600 rounded-xl flex items-center justify-center text-white text-xl font-bold">
                            <p>7+</p>
                        </span><span
                            class="h-full flex-1 bg-green-500 rounded-xl border-2 border-red-600 flex items-center justify-center text-white text-xl font-bold">
                            <p>0-3</p>
                        </span><span
                            class="h-full flex-1 bg-[#ffff00] rounded-xl border-2 border-red-600 flex items-center justify-center text-black text-xl font-bold">
                            <p>4-6</p>
                        </span></div>
                <a class="flex flex-row items-center gap-5" href="./register_contacts.php">
                    <div class="flex-1 bg-red-600 h-full text-center flex items-center justify-center text-white text-xl rounded-xl">
                        <p>CONTACTOS</p>
                    </div>
                </a><a class="flex flex-row items-center gap-5" href="./register_staff.php">
                    <div
                            class="flex-1 bg-red-600 h-full text-center flex items-center justify-center text-white text-xl rounded-xl">
                        <p>STAFF \ CREW</p>
                    </div>
                </a>
            </div>
            <span class="col-span-2"></span>
            <input type="text" name="artista[costo_artista]" required
                   class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                   placeholder="Costo Artista">
            <input type="text" name="artista[comision_evento]" required
                   class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                   placeholder="Comisión Evento">
            <input type="text" name="artista[costo_produccion]" required
                   class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                   placeholder="Costo Producción">
            <input type="text" name="artista[comision_intermediario]" required
                   class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                   placeholder="Comisión Intermediario">
            <section class="w-full py-10 col-span-full flex justify-center">
                <button type="submit"
                        class="transition duration-700 ease-in-out py-2 px-8 bg-blue-600 text-white text-lg rounded-lg">
                    Registrar
                    talento
                </button>
            </section>
        </form>
    </div>
</div>


</body>

<script>
    function hide_nonselected_elements() {
        tipo_talento_selected = document.getElementById("tipos_talentos").value;
        generos = document.getElementById("generos").options;
        first = true;

        Array.prototype.forEach.call(generos, function (option) {
            if (option.getAttribute('name') === tipo_talento_selected) {
                if (first) {
                    option.selected = true;
                    first = false;
                }
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    }

    const toBase64 = file => new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = reject;
    });

    async function convert_img_base64() {
        const file = document.getElementById('input_imagenes').files[0];
        const base64_image = document.getElementById('base64_image');
        const imagen_artista = document.getElementById('imagen_artista');
        let base64_string = await toBase64(file);
        imagen_artista.src = base64_string;
        base64_image.value = base64_string;
    }

    hide_nonselected_elements();
</script>

</html>