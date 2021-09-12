$(document).ready(() =>
{
    if(tipo == 'clientes')
    {
        obtener_archivos();
    }
    else
    {
        obtener_carpetas();
    }

    $('#form-cliente-asociado').submit(function(e) 
    {
        const postData =
        {
            cliente: $('#select-cliente').val(),
            carpeta: $('#nombre-carpeta').val()
        };

        $.post('partials/asociar-carpeta.php', postData, function (data)
        {
            console.log(data);
            if(data == 1)
            {
                Swal.fire(
                    'Guardado',
                    '¡Operación realizada correctamente !',
                    'success'
                )
            }
        });
        e.preventDefault();
    });

    $(document).on('click', '.btn-carpeta', function(e)
    {
        let element = $(this)[0].parentElement;
        let nombre_carpeta = $(element).attr('filaid');

        $('#text-ubicacion').html(nombre_carpeta);
        $('#nombre-carpeta-destino').val(nombre_carpeta);

        ubicacion = $('#nombre-carpeta').val()
        $('#nombre-carpeta').val(ubicacion+nombre_carpeta);

        $('.cantainer-subir-archivo').css('display', 'block');
        obtener_archivos(nombre_carpeta);
        document.getElementById('crear-nueva-carpeta').disabled = true;
        $('.footer-archivos').css('display', 'block');
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
        $('#text-ubicacion').html('');
        obtener_carpetas();
        $('#nombre-carpeta').val(ubicacion)
        $('.cantainer-subir-archivo').css('display', 'none');
        $('.footer-archivos').css('display', 'none');
        document.getElementById('crear-nueva-carpeta').disabled = false;
    });

    $('#crear-nueva-carpeta').click(function() 
    {
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
                $.post('partials/crear-carpeta.php', {nombre_carpeta}, function(response)
                {                      
                    console.log(response);
                    obtener_carpetas()
                });                  
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => 
        {
            if (result.isConfirmed) 
            {
                obtener_carpetas()
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

    function obtener_carpetas()
    {
        $.ajax(
        {
            url: 'partials/obtener-carpetas.php',
            type: 'GET',
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
        var ubicacion = $('#nombre-carpeta-destino').val();
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