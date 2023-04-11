window.onload = function () {

    $('#taula').hide();

    dades = {
        accio: "carregarDades"
    };

    $.ajax({
        url: "../assets/backend/carregarDades.php",
        type: "POST",
        data: JSON.stringify(dades),
        contentType: "application/json",
        dataType: "json",
        success: function(data) {
            $('#taula').show();
            data.usuaris.forEach((usuari,index) => {
                $('#taula tbody').append(`
                    <tr>
                        <th scope="row">${index + 1}</th>
                        <td>${usuari.usuari}</td>
                        <td>${usuari.nomCognoms}</td>
                        <td>${usuari.curs + usuari.grup} ${usuari.cicle}</td>
                    </tr>
                `);
            });
            console.log(data);
        },
        error: function(data) {
            console.log(data);
        }
    });
}