$(document).ready(() =>
{
    var edit_cliente = false;
    obtener_clientes();

    $("#form-abm-clientes").submit(function(e)
    {
        const postData =
        {
            nombre: $('#nombre-cliente').val(),
            id: $('#id-cliente').val(),
            password: $('#password-cliente').val(),
        };

        let url = edit_cliente === false ? 'partials/agregar-cliente.php' : 'partials/editar-cliente.php';

        $.post(url, postData, function (data)
        {
            if(data == "1")
            {
                Swal.fire(
                    '¡Operación realizada exitosamente!',
                    '',
                    'success'
                )
                const form = document.getElementById("form-abm-clientes");
                form.reset();
                edit_cliente = false;
                $('#btn-agregar-nueva-cliente').val('Agregar');
                $('#btn-agregar-nueva-cliente').css('background-color', 'var(--azul)')
                obtener_clientes()
            }
            else
            {
                console.log(data);
            }
        }); 
        e.preventDefault();   
    });

    $(document).on('click', '.eliminar-cliente', function(e)
    {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('filaid');

        Swal.fire(
        {
            title: '¿Queres eliminar este cliente?',
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
                $.post('partials/eliminar-cliente.php', {id}, function()
                {
                    Swal.fire(
                        '¡cliente eliminado exitosamente!',
                        '',
                        'success'
                    )
                    obtener_clientes();
                });       
            }
        });
        e.preventDefault();
    })

    $(document).on('click', '.editar-cliente', function(e)
    {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('filaid');

        $.post('partials/obtener-datos-cliente-editar.php', {id}, function(data)
        {
            const cliente = JSON.parse(data);
            $('#nombre-cliente').val(cliente.nombre);
        })

        $('#btn-agregar-nueva-cliente').val('Editar');
        $('#btn-agregar-nueva-cliente').css('background-color', '#15a95b')
        edit_cliente = true;
        $('#id-cliente').val(id);
        e.preventDefault();
    })

    function obtener_clientes()
    {
        $.ajax(
        {
            url: 'partials/obtener-clientes.php',
            type: 'GET',
            success: function (response)
            {
                let clientes = JSON.parse(response);
                let plantilla = '';
                
                clientes.forEach(cliente =>
                {
                    plantilla += 
                    `
                    <tr filaId="${cliente.id}">
                        <td class="td-controles">
                            <button class="btn-editar editar-cliente"><i class="uil uil-edit-alt"></i></button>
                        </td>
                        <td class="td-controles">
                            <button class="btn-eliminar eliminar-cliente"><i class="uil uil-trash-alt"></i></button>
                        </td>
                        <td>${cliente.id}</td>
                        <td>${cliente.nombre}</td>
                    </tr>  
                    `                           
                });
                $('#container-cliente').html(plantilla);
            }
        });
    }
});