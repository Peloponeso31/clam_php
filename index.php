<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>CLAM</title>
</head>
<body class="w-screen h-screen relative overflow-hidden bg-cover bg-[url(/assets/fondoHome.png)]">
    <h1 class="absolute top-1/2 left-20 text-white text-5xl text-center">
        CATALOGO <br/> TALENTO
    </h1>
    <flex class="absolute bottom-[20%] right-20 flex flex-col gap-16">
        <a href="/register_artist.php" class="flex flex-row items-center gap-5 text-3xl text-red-600 font-medium">
          <div class="size-[50px] border border-red-600 border-r-8 border-b-8"></div>
          Nuevo registro.
        </a>
        <a href="/consultas.php" class="flex flex-row items-center gap-5 text-3xl text-red-600 font-medium">
            <div class="size-[50px] border border-red-600 border-r-8 border-b-8"></div>
            Consultas.
        </a>
    </flex>
</body>
</html>