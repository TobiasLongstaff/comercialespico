$(document).ready(() =>
{
    if(tipo == 'clientes')
    {
        obtener_carpetas();
    }
    else
    {
        obtener_carpetas_clientes();
    }

    $(document).on('click', '.aprobar-archivo', function ()
    {
        let element = $(this)[0].parentElement.parentElement;
        let nombre_carpeta = $(element).attr('archivo');

        var ubicacion_carpeta = $('#nombre-carpeta').val()

        var ubicacion = ubicacion_carpeta+'/'+nombre_carpeta;

        console.log(ubicacion)

        Swal.fire(
        {
            title: '¿Queres aprobar este archivo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Aprobar',
            cancelButtonText: 'Cancelar',
        }).then((result) => 
        {
            if (result.isConfirmed) 
            {
                $.post('partials/aprobar-archivo.php', {ubicacion}, function(response)
                {
                    console.log(response)
                    if(response != '11')
                    {
                        Swal.fire(
                            'Error',
                            'Intentar mas tarde',
                            'error'
                        )
                    }
                    else
                    {
                        obtener_archivos(ubicacion_carpeta);
                    }
                    
                });       
            }
        });
    });

    $(document).on('click', '.remove-carpeta', function()
    {
        let element = $(this)[0].parentElement.parentElement;
        let nombre_carpeta = $(element).attr('filaid');

        var ubicacion_carpeta = $('#nombre-carpeta').val()

        var ubicacion = ubicacion_carpeta+'/'+nombre_carpeta;

        Swal.fire(
        {
            title: '¿Queres eliminar esta carpeta?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => 
        {
            if (result.isConfirmed) 
            {
                $.post('partials/eliminar-carpetas.php', {ubicacion}, function(response)
                {
                    console.log(response)
                    if(response != '')
                    {
                        Swal.fire(
                            'Error al eliminar la carpeta',
                            'Antes de eliminar la carpeta es necesario eliminar todos los archivos que se encuentra dentro',
                            'error'
                        )
                    }
                    else
                    {
                        obtener_carpetas(ubicacion_carpeta);
                    }
                    
                });       
            }
        });
    });

    $(document).on('click', '.remove-archivo', function()
    {
        let element = $(this)[0].parentElement.parentElement;
        let nombre_carpeta = $(element).attr('archivo');

        var ubicacion_carpeta = $('#nombre-carpeta').val()

        var ubicacion = ubicacion_carpeta+'/'+nombre_carpeta;

        console.log(ubicacion);

        Swal.fire(
        {
            title: '¿Queres eliminar este archivo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => 
        {
            if (result.isConfirmed) 
            {
                $.post('partials/eliminar-archivos.php', {ubicacion}, function(response)
                {
                    console.log(response)
                    if(response != '1')
                    {
                        Swal.fire(
                            'Error',
                            'Intentar mas tarde',
                            'error'
                        )
                    }
                    else
                    {
                        obtener_archivos(ubicacion_carpeta);
                    }
                    
                });       
            }
        });
    });

    $(document).on('mouseenter', '.container-carpetas', function()
    {
        let element = $(this)[0];
        let nombre_carpeta = $(element).attr('filaid');

        var controles = '.container-controles-carpetas-'+nombre_carpeta;
        $(controles).css('display', 'block');
    });

    $(document).on('mouseleave', '.container-carpetas', function()
    {
        let element = $(this)[0];
        let nombre_carpeta = $(element).attr('filaid');

        var controles = '.container-controles-carpetas-'+nombre_carpeta;
        $(controles).css('display', 'none');
    });

    $(document).on('mouseenter', '.container-btn-archivos', function()
    {
        let element = $(this)[0];
        let nombre_carpeta = $(element).attr('filanom');

        var controles = '.container-controles-archivos-'+nombre_carpeta;
        $(controles).css('display', 'flex');
    });

    $(document).on('mouseleave', '.container-btn-archivos', function()
    {
        let element = $(this)[0];
        let nombre_carpeta = $(element).attr('filanom');

        var controles = '.container-controles-archivos-'+nombre_carpeta;
        $(controles).css('display', 'none');
    });


    $(document).on('click', '.btn-carpeta', function(e)
    {
        let element = $(this)[0].parentElement;
        let nombre_carpeta = $(element).attr('filaid');

        var ubicacion = $('#nombre-sub-carpeta').val()+'/'+nombre_carpeta

        $('#nombre-carpeta').val(ubicacion);
        $('#text-ubicacion').html(ubicacion);


        $('#btn-volver-carpeta').show();
        $('#btn-volver').hide();

        obtener_archivos(ubicacion);

        console.log(ubicacion)

        $('.cantainer-subir-archivo').css('display', 'block');
        document.getElementById('crear-nueva-carpeta').disabled = true;
        e.preventDefault();
    });

    $(document).on('click', '.btn-carpeta-clientes', function(e)
    {
        let element = $(this)[0].parentElement;
        let nombre_carpeta = $(element).attr('filaid');

        $('#text-ubicacion').html(nombre_carpeta);

        $('#nombre-carpeta').val(nombre_carpeta);
        $('#nombre-sub-carpeta').val(nombre_carpeta);

        document.querySelector('#btn-volver').disabled = false;
        document.querySelector('#crear-nueva-carpeta').disabled = false;

        obtener_carpetas(nombre_carpeta);

        e.preventDefault();
    });

    $('#btn-cerrar-popup').click(function() 
    {
        $('#overlay').removeClass("active");
        $('#popup').removeClass("active");
    });

    $(document).on('click', '.mostrar-archivo', function(e) 
    {
        let element = $(this)[0].parentElement;
        let nombre_ubicacion = $(element).attr('filaid');
        $('#iframe-popup').attr('src', nombre_ubicacion);

        $('#overlay').addClass("active");
        $('#popup').addClass("active");  
        e.preventDefault();
    });

    $('#btn-volver').click(function() 
    {
        obtener_carpetas_clientes();

        $('#text-ubicacion').html('');
        $('#nombre-sub-carpeta').val('')
        $('#nombre-carpeta').val('')
        
        document.querySelector('#btn-volver').disabled = true;
        document.querySelector('#crear-nueva-carpeta').disabled = true;
    });

    $('#btn-volver-carpeta').click(function() 
    {
        var sub_ubicacion = $('#nombre-sub-carpeta').val();
        $('#nombre-carpeta').val(sub_ubicacion);

        $('#text-ubicacion').html(sub_ubicacion);

        $(this).hide();
        $('#btn-volver').show();

        obtener_carpetas(sub_ubicacion);
        console.log(sub_ubicacion);
        $('.cantainer-subir-archivo').css('display', 'none');
        document.querySelector('#btn-volver').disabled = false;
        document.querySelector('#crear-nueva-carpeta').disabled = false;
    });

    $('#crear-nueva-carpeta').click(function() 
    {
        var ubicacion = $('#nombre-carpeta').val();
        Swal.fire(
        {
            title: 'Crear Carpeta',
            text: 'Coloque el nombre de la carpeta',
            input: 'text',
            inputAttributes: {
            autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Crear',
            showLoaderOnConfirm: true,
            preConfirm: (nombre_carpeta) => {
                $.post('partials/crear-carpeta.php', {nombre_carpeta, ubicacion}, function(response)
                {                      
                    console.log(response);
                    obtener_carpetas(ubicacion)
                });                  
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => 
        {
            if (result.isConfirmed) 
            {
                obtener_carpetas(ubicacion)
            }
        });
    });
});

    function obtener_archivos(ubicacion)
    {
        $.ajax(
        {
            url: 'partials/obtener-archivos.php',
            type: 'POST',
            data: {ubicacion},
            success: function (response)
            {
                let archivos = JSON.parse(response);
                archivos.sort(function(a, b) { a = new Date(a.fecha); b = new Date(b.fecha); return a>b ? -1 : a<b ? 1 : 0; })
                let plantilla = '';
                let icono = '';
                let btn_archivo = '';
                
                if(response != '[]')
                {
                    archivos.forEach(archivo =>
                    {
                        if(archivo.ico == false) 
                        {
                            icono = '<i class="upload-file uil uil-file"></i><br>';
                        }
                        else
                        {
                            icono = '<i class="upload-file-check uil uil-file-check"></i><br>';
                        }
    
                        if(archivo.tipo_usuario == 'admin' || archivo.tipo_usuario == 'editor')
                        {
                            btn_archivo = '<button class="remove-archivo" type="button">Eliminar</button>';
                        }
                        else
                        {
                            if(archivo.ico == false) 
                            {
                                btn_archivo = '<button class="aprobar-archivo" type="button">Aprobar</button>';
                            }
                        }
    
                        plantilla += 
                        `
                        <div class="container-btn-archivos" archivo="${archivo.nombre}" filanom="${archivo.nombre_class}" filaId=https://drivecomercial.com/carpetas-clientes/${archivo.ubicacion}/${archivo.nombre}>
                            <span class="text-fecha">${archivo.fecha}</span>
                            <button class="mostrar-archivo">`+icono+
                                `<p class="text-titulo" title="${archivo.nombre}">${archivo.nombre}</p>
                            </button>
                            <div class="container-controles-archivos container-controles-archivos-${archivo.nombre_class}">
                                <a class="container-btn-descargar" href="https://drivecomercial.com/carpetas-clientes/${archivo.ubicacion}/${archivo.nombre}" download>
                                    <button class="descargar-archivo" type="button">Descargar</button>
                                </a>`+btn_archivo+`
                            </div>
                        </div>`
                    });
                }
                else
                {
                    plantilla += 
                    `<span>Carpeta vacia</span>`
                }
                $('#container-carpetas').html(plantilla);
            }
        });
    }

    function obtener_carpetas_clientes()
    {
        $.ajax(
            {
                url: 'partials/obtener-carpetas_clientes.php',
                type: 'GET',
                success: function (response)
                {
                    $('#container-carpetas').html(response);
                }
            });
    }

    function obtener_carpetas(ubicacion)
    {
        $.ajax(
        {
            url: 'partials/obtener-carpetas.php',
            type: 'POST',
            data: {ubicacion},
            success: function (response)
            {
                let archivos = JSON.parse(response);
                archivos.sort(function(a, b) { a = new Date(a.fecha); b = new Date(b.fecha); return a>b ? -1 : a<b ? 1 : 0; })
                let plantilla = '';
                let btn_archivo = '';
                
                if(response != '[]')
                {
                    archivos.forEach(archivo =>
                    {
                        if(archivo.tipo_usuario == 'admin' || archivo.tipo_usuario == 'editor')
                        {
                            btn_archivo = `<div class="container-controles-carpetas container-controles-carpetas-${archivo.nombre}">
                                <button class="remove-carpeta" type="button" >Eliminar</button>
                                </div>`
                        }

                        plantilla += 
                        `
                        <div class="container-carpetas" filaId="${archivo.nombre}">
                            <span class="text-fecha">${archivo.fecha}</span><br>
                            <button class="btn-carpeta">
                                <i class="upload-file fas fa-folder"></i><br>
                                <label>${archivo.nombre}</label>
                            </button>`+btn_archivo+`
                        </div>`
                    });
                }
                else
                {
                    plantilla += 
                    `<span>Carpeta vacia</span>`
                }
                $('#container-carpetas').html(plantilla);
            }
        });
    }

    function readURL(input) 
    {
        if (input.files && input.files[0]) 
        {
            var reader = new FileReader();

            reader.onload = function(e) 
            {
                $('.image-upload-wrap').hide(); 
                $('.file-upload-content').show();   
                $('.image-title').html(input.files[0].name);
            };
            reader.readAsDataURL(input.files[0]);
        } 
        else 
        {
            removeUpload();
        }
    }

    function removeUpload() 
    {
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }

    $('.image-upload-wrap').bind('dragover', function () 
    {
        $('.image-upload-wrap').addClass('image-dropping');
    });

    $('.image-upload-wrap').bind('dragleave', function () 
    {
        $('.image-upload-wrap').removeClass('image-dropping');
    });

    const $inputArchivos = document.querySelector("#inputArchivos"),
    $btnEnviar = document.querySelector("#btnEnviar"),
    $estado = document.querySelector("#estado");

    $btnEnviar.addEventListener("click", async () => 
    {
        var ubicacion = $('#nombre-carpeta').val();
        var sub_ubicacion = $('#nombre-sub-carpeta').val();
        
        console.log(ubicacion);

        const archivosParaSubir = $inputArchivos.files;
        if (archivosParaSubir.length <= 0) 
        {
            // Si no hay archivos, no continuamos
            return;
        }

        // Preparamos el formdata
        const formData = new FormData();

        // Agregamos cada archivo a "archivos[]". Los corchetes son importantes
        for (const archivo of archivosParaSubir) 
        {
            formData.append("archivos[]", archivo);
            formData.append('ubicacion', ubicacion);
            formData.append('sub-ubicacion', sub_ubicacion);
        }

        // Los enviamos
        $estado.textContent = "Enviando archivos...";
        const respuestaRaw = await fetch("./partials/upload.php", 
        {
            method: "POST",
            body: formData,
        });
        const respuesta = respuestaRaw.json();

        // Puedes manejar la respuesta como tú quieras
        console.log({ respuesta });

        // Finalmente limpiamos el campo
        removeUpload();
        $inputArchivos.value = null;
        $estado.textContent = "Archivos enviados";
        obtener_archivos(ubicacion)
    });