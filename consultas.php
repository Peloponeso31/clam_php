<?php
    header('Content-Type: text/html; charset=utf-8');
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=syslamco_clam", 'syslamco_franciscotv', 'L]ig7Uq?aw@!');
        $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        $pdo->exec("set names utf8mb4");
    }
    catch( PDOException $Exception ) {
        echo $Exception->getMessage();
        echo (int)$Exception->getCode();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>CLAM</title>
</head>

<body>
    <div id="root" class="w-screen h-screen">
        <div style="position: fixed; z-index: 9999; inset: 16px; pointer-events: none;"></div>
        <div class="size-full flex flex-col gap-y-5">
            <div style="position: fixed; z-index: 9999; inset: 16px; pointer-events: none;"></div>
            <div class="shadow-md w-full max-h-[80px] h-full p-5 flex flex-row items-center"><a
                    class="text-lg bg-white p-2 relative hover:bg-gray-200 rounded-md" href="./">Regresar</a></div>
            <div class=" flex flex-wrap gap-5 items-center px-8 py-5"><input
                    class="py-2 px-4 text-lg rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center w-[370px]"
                    placeholder="Nombre del talento">
                <div class="relative"><label
                        class="absolute -top-3 left-5 text-sm text-center bg-white text-gray-500 z-[10]">Filtrar por
                        tipo de artista</label>
                    <div class="size-full z-[500]">
                        <div class="relative font-montserrat size-full"><input
                                class="border border-black rounded-md w-full text-start py-1 px-3 cursor-pointer text-2xl  col-span-2 px-4 rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center max-h-[100px] text-xl "
                                readonly="" value="Todos"><svg stroke="currentColor" fill="currentColor"
                                stroke-width="0" viewBox="0 0 24 24"
                                class="absolute w-10 inset-y-[25%] right-[2px] cursor-pointer bg-white" height="1.5em"
                                width="1.5em" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                <path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path>
                            </svg></div>
                        <div class="w-full relative z-50"></div>
                    </div>
                </div>
                <div class="relative min-w-[260px]"><label
                        class="absolute -top-3 left-5 text-sm text-center bg-white text-gray-500 z-10">Filtrar por
                        género de artista</label>
                    <div class="size-full z-[500]">
                        <div class="relative font-montserrat size-full"><input
                                class="border border-black rounded-md w-full text-start py-1 px-3 cursor-pointer text-2xl  col-span-2 px-4 rounded-md border border-black drop-shadow-md placeholder:text-red-600 placeholder:text-center max-h-[100px] text-xl "
                                readonly="" value="Todos"><svg stroke="currentColor" fill="currentColor"
                                stroke-width="0" viewBox="0 0 24 24"
                                class="absolute w-10 inset-y-[25%] right-[2px] cursor-pointer bg-white" height="1.5em"
                                width="1.5em" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                <path d="M7.41 8.59 12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path>
                            </svg></div>
                        <div class="w-full relative z-50"></div>
                    </div>
                </div><button type="button" class="py-2 px-8 bg-blue-600 text-white text-lg rounded-lg">Buscar
                    talento</button>
            </div>
            <div class="px-8 pb-5 flex-1">
                <div class="overflow-x-auto min-h-[600px] overflow-y-auto border-2 border-slate-400 p-2">
                    <table class="min-w-[2000px] table-fixed">
                        <thead>
                            <tr>
                                <th class="border border-slate-400 text-gray-700 text-xl min-w-[50px]">Acciones</th>
                                <th class="border border-slate-400 text-gray-700 text-xl">Nombre del talento</th>
                                <th class="border border-slate-400 text-gray-700 text-xl min-w-[150px]">Foto</th>
                                <th class="border border-slate-400 text-gray-700 text-xl">Tipo</th>
                                <th class="border border-slate-400 text-gray-700 text-xl">Género</th>
                                <th class="border border-slate-400 text-gray-700 text-xl min-w-[200px]">Semblanza</th>
                                <th class="border border-slate-400 text-gray-700 text-xl min-w-[200px]">Video</th>
                                <th class="border border-slate-400 text-gray-700 text-xl min-w-[200px]">Costo de artista
                                </th>
                                <th class="border border-slate-400 text-gray-700 text-xl min-w-[200px]">Costo de
                                    producción</th>
                                <th class="border border-slate-400 text-gray-700 text-xl min-w-[200px]">Comisión de
                                    evento</th>
                                <th class="border border-slate-400 text-gray-700 text-xl min-w-[200px]">Comisión de
                                    intermediario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($pdo->query("SELECT * FROM `talentos`") as $row) {
                                    // Acciones
                                    echo '<tr>
                                            <td class="border border-slate-400 px-2 py-1 text-center">
                                            <div class="flex flex-row justify-center gap-3">
                                                <form action="./register_artist_controller.php" method="POST">
                                                    <button class="rounded-full hover:bg-gray-200 p-2"
                                                            name="id_talento"
                                                            value='.$row['id'].'>
                                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                             viewBox="0 0 24 24" height="1.5em" width="1.5em"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path fill="none" d="M0 0h24v24H0z"></path>
                                                            <path
                                                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a.996.996 0 0 0 0-1.41l-2.34-2.34a.996.996 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                               
                                                <button class="rounded-full hover:bg-gray-200 p-2"><svg
                                                        stroke="currentColor" fill="currentColor" stroke-width="0"
                                                        viewBox="0 0 24 24" height="1.5em" width="1.5em"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                                                        <path
                                                            d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12 1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z">
                                                        </path>
                                                    </svg></button><button class="rounded-full hover:bg-gray-200 p-2"><svg
                                                        stroke="currentColor" fill="currentColor" stroke-width="0"
                                                        viewBox="0 0 512 512" height="1.5em" width="1.5em"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M405 136.798L375.202 107 256 226.202 136.798 107 107 136.798 226.202 256 107 375.202 136.798 405 256 285.798 375.202 405 405 375.202 285.798 256z">
                                                        </path>
                                                    </svg></button><button class="rounded-full hover:bg-gray-200 p-2"><svg
                                                        stroke="currentColor" fill="currentColor" stroke-width="0"
                                                        viewBox="0 0 16 16" height="1.5em" width="1.5em"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M7.99993 6.00316C9.47266 6.00316 10.6666 7.19708 10.6666 8.66981C10.6666 10.1426 9.47266 11.3365 7.99993 11.3365C6.52715 11.3365 5.33324 10.1426 5.33324 8.66981C5.33324 7.19708 6.52715 6.00316 7.99993 6.00316ZM7.99993 7.00315C7.07946 7.00315 6.33324 7.74935 6.33324 8.66981C6.33324 9.59028 7.07946 10.3365 7.99993 10.3365C8.9204 10.3365 9.6666 9.59028 9.6666 8.66981C9.6666 7.74935 8.9204 7.00315 7.99993 7.00315ZM7.99993 3.66675C11.0756 3.66675 13.7307 5.76675 14.4673 8.70968C14.5344 8.97755 14.3716 9.24908 14.1037 9.31615C13.8358 9.38315 13.5643 9.22041 13.4973 8.95248C12.8713 6.45205 10.6141 4.66675 7.99993 4.66675C5.38454 4.66675 3.12664 6.45359 2.50182 8.95555C2.43491 9.22341 2.16348 9.38635 1.89557 9.31948C1.62766 9.25255 1.46471 8.98115 1.53162 8.71321C2.26701 5.76856 4.9229 3.66675 7.99993 3.66675Z">
                                                        </path>
                                                    </svg></button><button class="rounded-full hover:bg-gray-200 p-2"><svg
                                                        stroke="currentColor" fill="currentColor" stroke-width="0"
                                                        viewBox="0 0 576 512" height="1.5em" width="1.5em"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z">
                                                        </path>
                                                    </svg></button></div>
                                        </td>';

                                    // Nombre del talento
                                    echo '<td class="border border-slate-400 px-2 py-1">
                                            <input type="text" class="focus:outline-none size-full" readonly="" value="'.$row['nombre'].'">
                                          </td>';
                                    
                                    // Fotografia
                                    echo '<td class="border border-slate-400 px-2 py-1">
                                              <div class="w-full flex justify-center">
                                                  <img src="'.$row['foto'].'" alt="imagen del artista" class="h-[80px]"/>
                                              </div>
                                          </td>';
                                    
                                    // Tipo
                                    echo '<td class="border border-slate-400 px-2 py-1">
                                              <input type="text" class="focus:outline-none size-full" readonly="" value="'.$row['tipo'].'">
                                          </td>';
                                    
                                    // Genero
                                    echo '<td class="border border-slate-400 px-2 py-1">
                                          <input type="text" class="focus:outline-none size-full" readonly="" value="'.$row['genero'].'">
                                      </td>';

                                    // Semblanza
                                    echo '<td class="border border-slate-400 px-2 py-1">
                                          <input type="text" class="focus:outline-none size-full" readonly="" value="'.$row['semblanza'].'">
                                      </td>';

                                    // Video
                                    echo '<td class="border border-slate-400 px-2 py-1">
                                          <input type="text" class="focus:outline-none size-full" readonly="" value="'.$row['video'].'">
                                      </td>';

                                    // costo_artista
                                    echo '<td class="border border-slate-400 px-2 py-1">
                                          <input type="text" class="focus:outline-none size-full" readonly="" value="'.$row['costo_artista'].'">
                                      </td>';

                                    // costo_produccion
                                    echo '<td class="border border-slate-400 px-2 py-1">
                                          <input type="text" class="focus:outline-none size-full" readonly="" value="'.$row['costo_produccion'].'">
                                      </td>';

                                    // comision_evento
                                    echo '<td class="border border-slate-400 px-2 py-1">
                                          <input type="text" class="focus:outline-none size-full" readonly="" value="'.$row['comision_evento'].'">
                                      </td>';

                                    // comision_intermediario
                                    echo '<td class="border border-slate-400 px-2 py-1">
                                          <input type="text" class="focus:outline-none size-full" readonly="" value="'.$row['comision_intermediario'].'">
                                      </td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</body>

</html>