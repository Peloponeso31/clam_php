<?php
header('Content-Type: text/html; charset=utf-8');
try {
    $pdo = new PDO("mysql:host=localhost;dbname=clam", 'root', '');
    $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
    $pdo->exec("set names utf8mb4");
} catch (PDOException $Exception) {
    echo $Exception->getMessage();
    echo (int) $Exception->getCode();
}
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
    <div id="root">
        <div style="position: fixed; z-index: 9999; inset: 16px; pointer-events: none;"></div>
        <div class="size-full flex flex-col gap-y-5">
            <div class="shadow-md w-full max-h-[80px] h-full p-5 flex flex-row items-center"><a
                    class="text-lg bg-white p-2 relative hover:bg-gray-200 rounded-md" href="/">Regresar</a></div>
            <form action="/register-staff.php" method="POST" class="size-full overflow-hidden flex flex-col p-5">
                <section class="grid grid-cols-3 grid-rows-2 gap-5">
                    <div class="flex flex-row items-center gap-5">
                        <span class="h-full flex-1 bg-red-600 rounded-xl flex items-center justify-center text-white text-xl font-bold opacity-50">
                            <p>7+</p>
                        </span>
                        <span class="h-full flex-1 bg-green-500 rounded-xl border-2 border-red-600 flex items-center justify-center text-white text-xl font-bold opacity-100">
                            <p>0-3</p>
                        </span>
                        <spaN class="h-full flex-1 bg-[#ffff00] rounded-xl border-2 border-red-600 flex items-center justify-center text-black text-xl font-bold opacity-50">
                            <p>4-6</p>
                        </span>
                    </div>

                    <input type="text" name="nombre_talento"
                        class="col-span-2 p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                        placeholder="Nombre del talento">

                    <div class="flex flex-row items-center gap-5">
                        <div
                            class="flex-1 bg-red-600 h-full text-center flex items-center justify-center text-white text-xl rounded-xl">
                            <p>STAFF\CREW</p>
                        </div>
                    </div>
                    <div class="col-span-2 row-span-1 gap-5 flex items-center justify-center">
                        <button type="button"
                            class="transition duration-300 ease-in-out py-2 px-8 bg-blue-600 hover:bg-blue-500 text-white text-lg rounded-lg">
                            Verificar nombre
                        </button>
                        <button type="button"
                            class="transition duration-300 ease-in-out py-2 px-8 bg-blue-600 hover:bg-blue-500 text-white text-lg rounded-lg">
                            Añadir integrante de staff
                        </button>
                    </div>
                </section>

                <section class="flex-1 mt-5 overflow-y-auto flex flex-col gap-8 p-3">
                    <article class="border border-gray-500 p-3 grid grid-cols-3 gap-2 shadow-md relative"
                        style="opacity: 1; transform: none;"><button type="button"
                            class="bg-red-500 hover:bg-red-400 transition duration-300 ease-in-out rounded-md text-xl text-white">(1)
                            Remover integrante</button><input type="text" maxlength="100" name="nombre_apellidos-7"
                            class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                            placeholder="Nombre y apellidos">
                        <div class="flex flex-wrap justify-around"><button type="button"
                                class="px-6 text-lg border border-gray-400 rounded-md text-red-600 transition duration-300 ease-in-out drop-shadow bg-white hover:bg-gray-200">F</button><button
                                type="button"
                                class="px-6 text-lg border border-gray-400 rounded-md text-red-600 transition duration-300 ease-in-out drop-shadow hover:bg-blue-400 bg-blue-200">M</button>
                        </div><input type="text" maxlength="50" name="puesto-7"
                            class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                            placeholder="Puesto que ocupa">
                        <div class="flex flex-wrap justify-around"><button type="button"
                                class="px-6 text-lg border border-gray-400 rounded-md text-red-600 transition duration-300 ease-in-out drop-shadow bg-white hover:bg-gray-200">B</button><button
                                type="button"
                                class="px-6 text-lg border border-gray-400 rounded-md text-red-600 transition duration-300 ease-in-out drop-shadow bg-white hover:bg-gray-200">A</button><button
                                type="button"
                                class="px-6 text-lg border border-gray-400 rounded-md text-red-600 transition duration-300 ease-in-out drop-shadow hover:bg-blue-400 bg-blue-200">AA</button><button
                                type="button"
                                class="px-6 text-lg border border-gray-400 rounded-md text-red-600 transition duration-300 ease-in-out drop-shadow bg-white hover:bg-gray-200">T</button>
                        </div><input type="email" maxlength="100" name="correo-7"
                            class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                            placeholder="Correo electrónico"><input type="text" maxlength="10" minlength="10"
                            name="telefono-7"
                            class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                            placeholder="Teléfono celular"><input type="date" name="fecha_nacimiento-7"
                            class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                            placeholder="Fecha de nacimiento"><input type="text" maxlength="100" name="nacionalidad-7"
                            class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                            placeholder="Nacionalidad"><input type="text" maxlength="100" name="no_pasaporte-7"
                            class="p-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center size-full"
                            placeholder="Número de pasaporte">
                    </article>
                </section>
                <section class="py-5 flex justify-center"><button type="submit"
                        class="transition duration-700 ease-in-out py-2 px-8 bg-blue-600 text-white text-lg rounded-lg">Registrar
                        staff</button></section>
            </form>
        </div>
    </div>
</body>

</html>