window.onload = function() {
	$('#Importar').click(importar);
}

function importar() {
	var fitxerTSV = $("#formFile").val();
	if (fitxerTSV == "") {
		alert("No has seleccionat cap fitxer");
		return;
	} else {
		var extensio = fitxerTSV.split('.').pop();
		if (extensio != "tsv") {
			alert("El fitxer ha de ser de tipus TSV");
			return;
		} else {
			var fitxer = $("#formFile")[0].files[0];
			var reader = new FileReader();
			var json = [];
			reader.readAsText(fitxer);
			reader.onload = function(event) {
				//Comprovem que les linies el salt de linia sigui \r o \r\n
				var linies = event.target.result.split(/\r\n|\r|\n/);

				for (var i = 0; i < linies.length; i++) {
					var linia = linies[i].split("\t");
					var usuari = linia[0];
					//Treiem el \n de l'inici de la variable usuari
					if (usuari == "Usuari" || usuari == "") {
						continue;
					}
					var nomCognoms = linia[1];
					var cicle = linia[2];
					var curs = linia[3];
					var grup = linia[4];
					
					json.push({
						"usuari": usuari,
						"nomCognoms": nomCognoms,
						"cicle": cicle,
						"curs": curs,
						"grup": grup
					});
				}
				$.ajax({
					url: "../assets/backend/import.php",
					type: "POST",
					data: JSON.stringify(json),
					contentType: "application/json",
					dataType: "json",
					success: function(data) {
						console.log(data);
					},
					error: function(data) {
						console.log(data);
					}
				});
			}
		}
	}
}