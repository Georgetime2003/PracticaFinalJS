window.onload = function () {
	obtenirCursos().then(mostrarCursos);
};

function obtenirCursos(){
	var fitxer = "../assets/backend/database/JSON/classes.json";
	return fetch(fitxer).then(function (response) {
		return response.json();
	});
}



function mostrarCursos(cursos){
	var thead = $("#thead");
	thead.text("");
	var tbody = $("#tbody");
	tbody.text("");
	var tr = $("<tr></tr>");
	var titols = ["Cicle", "Curs", "Grup", "Tutor","Accions"];
	for (let i = 0; i < 5; ++i){
		var th = document.createElement("th");
		th.className = "text-center";
		th.innerHTML = titols[i];
		tr.append(th);
	}
	thead.append(tr);
	//Amb el fitxer passem per tots els alumnes comprovant els noms de cicles, cursos i grups i els afegim amb una array, tot seguit afegim la array a la taula
	var cicles = [];
	for (let i = 0; i < cursos.length; ++i){
		var cicle = cursos[i].cicle;
		var curs = cursos[i].curs;
		var grup = cursos[i].grup;
		var tutor = cursos[i].usuari;
		var trobat = false;
		for (let j = 0; j < cicles.length; ++j){
			if (cicles[j].cicle == cicle && cicles[j].curs == curs && cicles[j].grup == grup){
				trobat = true;
				break;
			}
		}
		if (!trobat && !(tutor.contains("."))){
			cicles.push({
				"cicle": cicle,
				"curs": curs,
				"grup": grup
			});
		}
	}
	//Afegim les dades a la taula amb un botó per accedir al curs que farà un event listener per recarregar la taula amb els alumnes del curs
	for (let i = 0; i < cicles.length; ++i){
		var tr = $("<tr></tr>");
		var td = $("<td></td>");
		td.text(cicles[i].cicle);
		td.attr("class", "text-center");
		tr.append(td);
		td = $("<td></td>");
		td.text(cicles[i].curs);
		td.attr("class", "text-center");
		tr.append(td);
		td = $("<td></td>");
		td.attr("class", "text-center");
		td.text(cicles[i].grup);
		tr.append(td);
		td = $("<td></td>");
		td.attr("class", "text-center");
		var button = $("<button></button>");
		button.addClass("btn btn-success");
		button.text("Accedir");
		button.click(function () {
			accedirCurs(cicles[i].cicle, cicles[i].curs, cicles[i].grup, cursos);
		});
		td.append(button);
		tr.append(td);
		tbody.append(tr);
	}
}

function accedirCurs(cicle, curs, grup, cursos){
	var thead = $("#thead");
	thead.text("");
	var tbody = $("#tbody");
	tbody.text("");
	var tr = $("<tr></tr>");
	var titols = ["Nom i cognoms", "Té imatge?", "Accions"];
	for (let i = 0; i < 3; ++i){
		var th = document.createElement("th");
		th.className = "text-center";
		th.innerHTML = titols[i];
		tr.append(th);
	}
	thead.append(tr);
	//Amb el fitxer passem per tots els alumnes comprovant els noms de cicles, cursos i grups i els afegim amb una array, tot seguit afegim la array a la taula
	for (let i = 0; i < cursos.length; ++i){
		if (cursos[i].cicle == cicle && cursos[i].curs == curs && cursos[i].grup == grup){
			var tr = $("<tr></tr>");
			var nomCognoms = cursos[i].nomCognoms;
			var imatge = cursos[i].imatge;
			var accio = document.createElement("button");
			accio.className = "btn btn-success";
			accio.innerHTML = "Fer foto";
			accio.addEventListener("click", function () {
				ferFoto(nomCognoms);
			});
			var td = document.createElement("td");
			td.className = "text-center";
			td.innerHTML = nomCognoms;
			tr.append(td);
			td = document.createElement("td");
			td.className = "text-center";
			td.innerHTML = imatge == "" ? "No" : "Sí";
			tr.append(td);
			td = document.createElement("td");
			td.className = "text-center";
			td.append(accio);
			tr.append(td);
			tbody.append(tr);
		}
	}
}