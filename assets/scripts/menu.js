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
                $('#container-carpetas').html(response);
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
                $('#container-carpetas').html(response);
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