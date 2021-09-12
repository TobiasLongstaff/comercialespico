$(document).ready(() =>
{
    $("#form-login").submit(function(e)
    {
        const postData =
        {
            mail: $('#log-mail').val(),
            password: $('#log-pass').val()
        };
        $.post('partials/logeo.php', postData, function (data)
        {
            if(data == "1")
            {
                $(location).attr('href','index.php');
            }
            else
            {
                console.log(data);
                $('#error-login').html(data);
            }
        }); 
        e.preventDefault();   
    });
})