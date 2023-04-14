window.onload = function () {
  console.log(navigator.mediaDevices.enumerateDevices());
  try {
    obtenirCursos();
  } catch (e) {
    console.log(e);
  }
};

function obtenirCursos() {
  $.ajax({
    url: "../assets/backend/carregarDades.php",
    type: "POST",
    data: JSON.stringify({
      accio: "classes",
    }),
    contentType: "application/json",
    dataType: "json",
    success: function (data) {
      data = data.classes;
      mostrarCursos(data);
    },
    error: function (data) {
      throw new Error("Error obtenint les dades");
    },
  });
}

function mostrarCursos(cursos) {
  var thead = $("#thead");
  thead.text("");
  var tbody = $("#tbody");
  tbody.text("");
  var tr = $("<tr></tr>");
  var titols = ["Cicle", "Curs", "Grup", "Tutor", "Accions"];
  for (let i = 0; i < 5; ++i) {
    var th = document.createElement("th");
    th.className = "text-center";
    th.innerHTML = titols[i];
    tr.append(th);
  }
  thead.append(tr);
  //Amb el fitxer passem per tots els alumnes comprovant els noms de cicles, cursos i grups i els afegim amb una array, tot seguit afegim la array a la taula
  var cicles = [];
  for (let i = 0; i < cursos.length; ++i) {
    var cicle = cursos[i].cicle;
    var curs = cursos[i].curs;
    var grup = cursos[i].grup;
    var tutor = cursos[i].tutor.nomCognoms;
    var trobat = false;
    for (let j = 0; j < cicles.length; ++j) {
      if (
        cicles[j].cicle == cicle &&
        cicles[j].curs == curs &&
        cicles[j].grup == grup
      ) {
        trobat = true;
        break;
      }
    }
    if (!trobat) {
      cicles.push({
        cicle: cicle,
        curs: curs,
        grup: grup,
        tutor: tutor,
      });
    }
  }
  //Afegim les dades a la taula amb un botó per accedir al curs que farà un event listener per recarregar la taula amb els alumnes del curs
  for (let i = 0; i < cicles.length; ++i) {
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
    td.text(cicles[i].tutor);
    tr.append(td);
    td = $("<td></td>");
    td.attr("class", "text-center");
    var button = $("<button></button>");
    button.addClass("btn btn-success");
    button.text("Accedir");
    button.click(function () {
      accedirCurs(cursos[i]);
    });
    td.append(button);
    tr.append(td);
    tbody.append(tr);
  }
}

function accedirCurs(classe) {
  var thead = $("#thead");
  thead.text("");
  var tbody = $("#tbody");
  tbody.text("");
  var tr = $("<tr></tr>");
  var titols = ["Nom i cognoms", "Té imatge?", "Accions"];
  for (let i = 0; i < 3; ++i) {
    var th = document.createElement("th");
    th.className = "text-center";
    th.innerHTML = titols[i];
    tr.append(th);
  }
  let td = $("<td></td>");
  td.attr("class", "text-center");
  let button = $("<button></button>");
  button.addClass("btn btn-warning");
  button.text("Tornar");
  button.click(function () {
    obtenirCursos();
  });
  td.append(button);
  tr.append(td);
  thead.append(tr);
  //Amb el fitxer passem per tots els alumnes comprovant els noms de cicles, cursos i grups i els afegim amb una array, tot seguit afegim la array a la taula
  Object.values(classe.alumnes).forEach((alumne) => {
    var tr = $("<tr></tr>");
    var td = $("<td></td>");
    td.text(alumne.nomCognoms);
    td.attr("class", "text-center");
    tr.append(td);
    td = $("<td></td>");
    td.attr("class", "text-center");
    if (alumne.imatge == null || alumne.imatge == "") {
      td.text("No");
    } else {
      td.text("Si");
    }
    tr.append(td);
    td = $("<td></td>");
    td.attr("class", "text-center");
    var button = $("<button></button>");
    button.addClass("btn btn-success");
    button.text("Fer foto");
    button.click(function () {
      accedirAlumne(alumne);
    });
    td.append(button);
    tr.append(td);
    tbody.append(tr);
  });
}

function accedirAlumne(alumne) {
  $("#modalCamara").modal("show");
  //Obtenir camara
  //Comprovem si el navegador és d'ordenador o mòbil
  if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    //Si és d'ordenador
    navigator.mediaDevices
      .getUserMedia({ video: true })
      .then(function (stream) {
        video.srcObject = stream;
        video.play();
      })
      .catch(function (err) {
        console.log("An error occurred! " + err);
      });
  } else if (navigator.getUserMedia) {
    // Standard
    navigator.getUserMedia(
      { video: true },
      function (stream) {
        video.src = stream;
        video.play();
      },
      errBack
    );
  } else if (navigator.webkitGetUserMedia) {
    // WebKit-prefixed
    navigator.webkitGetUserMedia(
      { video: true },
      function (stream) {
        video.src = window.webkitURL.createObjectURL(stream);
        video.play();
      },
      errBack
    );
  }
  $("#modalCamara").modal("show");
  $("#video").show();
  $("#btnFoto").click(function () {
    //Pausem el video per fer la foto
    $("#video").attr("hidden", true);
    let canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext("2d").drawImage(video, 0, 0);
    //Mostrem la foto
    $("#fotoAlumne").attr("src", canvas.toDataURL("image/png"));
    $("#fotoAlumne").attr("hidden", false);
    $("#ferFoto").attr("hidden", true);
    $("#opcions").attr("hidden", false);
    $("#guardarFoto").click(function () {
      guardarImatgeAlumne(alumne, canvas.toDataURL("image/png"));
    });
  });
  $("#repetirFoto").click(function () {
    $("#fotoAlumne").attr("hidden", true);
    $("#opcions").attr("hidden", true);
    $("#ferFoto").attr("hidden", false);
    $("#video").attr("hidden", false);
  });
  $("#modalCamara").on("hidden.bs.modal", function () {
    video.srcObject.getTracks()[0].stop();
    $("#fotoAlumne").attr("hidden", true);
    $("#enviarFoto").attr("hidden", true);
    $("#video").attr("hidden", false);
  });
}

function guardarImatgeAlumne(alumne, imatge) {
  $.ajax({
    url: "../assets/backend/guardarImatge.php",
    type: "POST",
    data: JSON.stringify({
      nomCognoms: alumne.nomCognoms,
	  grup: alumne.cicle + alumne.curs + alumne.grup,
      usuari: alumne.usuari,
      imatge: imatge,
    }),
    contentType: "image/png",
    success: function (data) {
      //Mostrem un missatge de confirmació
	  data = JSON.parse(data);
      $("#modalCamara").modal("hide");
      $("#missatge").text(data.message);
      $(".toast").toast("show");
	  setTimeout(function(){ location.reload(); }, 2000);
    },
  });
}
