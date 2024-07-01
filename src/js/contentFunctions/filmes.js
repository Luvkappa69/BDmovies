let controllerPath = "src/controller/controllerFilmes.php"


function regista_Filme() {
  if (
    $('#idImbd').val() =="" ||
    $('#nome').val() =="" ||
    $('#ano').val() =="" ||
    $('#codigoClassificacao').val() == -1

  ){
    return alerta("error", "Por favor preencha os campos ...");
}

  let dados = new FormData();
  dados.append('idImbd', $('#idImbd').val());
  dados.append('nome', $('#nome').val());
  dados.append('ano', $('#ano').val());
  dados.append('capa', $('#capa').prop('files')[0]); //image 🖼️
  dados.append('codigoClassificacao', $('#codigoClassificacao').val());

  
  dados.append('op', 1);


  $.ajax({
    url: controllerPath,
    method: "POST",
    data: dados,
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
  })

    .done(function (msg) {
      if (msg == 0){
        alerta("error", "Contacto incorreto, verifique (NIF, CONTACTO, CODIGO POSTAL)");
      } else{
        alerta("success", msg);
      }
      
      listagemFilmes();
    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });

}













function listagemFilmes() {

  let dados = new FormData();
  dados.append('op', 2);


  $.ajax({
    url: controllerPath,
    method: "POST",
    data: dados,
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
  })

    .done(function (msg) {
      
      if ($.fn.DataTable.isDataTable('#tableFilmes')) {
        $('#tableFilmes').DataTable().destroy();
      }
      $('#tableFilmes').html(msg);
      $('#tableFilmesTable').DataTable({
        "columnDefs": [{
          "targets": '_all',
          "defaultContent": ""
        }]})
    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}











function removerFilme(key) {

  let dados = new FormData();
  dados.append('op', 3);
  dados.append('idImbd', key);

  $.ajax({
    url: controllerPath,
    method: "POST",
    data: dados,
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
  })

    .done(function (msg) {
      alerta("success", msg);
      listagemFilmes();
    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}











function editaFilme(key) {

  let dados = new FormData();
  dados.append('op', 4);
  dados.append('idImbd', key);

  $.ajax({
    url: controllerPath,
    method: "POST",
    data: dados,
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
  })

    .done(function (msg) {
      let obj = JSON.parse(msg);
      

      $('#capaFilme').attr("src", obj.capa);
      $('#idImbdEdit').val(obj.idImbd);
      $('#nomeEdit').val(obj.nome);
      $('#anoEdit').val(obj.ano);
      dados.append('capa', $('#capaEdit').prop('files')[0]); //image 🖼️
      $('#codigoClassificacaoEdit').val(obj.codigoClassificacao);
 
      $('#editModalFilme').modal('toggle');
      $('#btnGuardarEditFilme').attr('onclick', 'guardaEditfilme(' + obj.idImbd + ')')
    })
 
    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}


function showFilme (key) {

  let dados = new FormData();
  dados.append('op', 8);
  dados.append('idImbd', key);

  $.ajax({
    url: controllerPath,
    method: "POST",
    data: dados,
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
  })

    .done(function (msg) {
      let obj = JSON.parse(msg);
      
      $('#capaFilmeInfo').attr('src', obj.capa);

      $('#idImbdInfo').val(obj.idImbd);
      $('#nomeInfo').val(obj.nome);
      $('#anoInfo').val(obj.ano);

      $('#codigoClassificacaoInfo').val(obj.codigoClassificacao);
 
      $('#infoModalInfoFilme').modal('toggle');

    })
 
    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}








function guardaEditfilme (key) {

  let dados = new FormData();

  dados.append('idImbd', $('#idImbdEdit').val());
  dados.append('nome', $('#nomeEdit').val());
  dados.append('ano', $('#anoEdit').val());
  dados.append('codigoClassificacao', $('#codigoClassificacaoEdit').val());


  dados.append('old_key', key);

  dados.append('op', 5);


  $.ajax({
    url: controllerPath,
    method: "POST",
    data: dados,
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
  })

    .done(function (msg) {
      alerta("success", msg);
      listagemFilmes();
    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });

}











function alerta(icon, msg) {

  Swal.fire({
    title: "<strong>Feedback</strong>",
    icon: icon,
    text: msg,
    showCloseButton: true,
    focusConfirm: false,

  });
}



function getSelectclassificacao() {

  let dados = new FormData();
  dados.append('op', 7);



  $.ajax({
    url: controllerPath,
    method: "POST",
    data: dados,
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
  })

    .done(function (msg) {
      $('#codigoClassificacao').html(msg);
      $('#codigoClassificacaoEdit').html(msg);

    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}

function pesquisar() {
  let dados = new FormData();
  dados.append('op', 9);



  $.ajax({
    url: controllerPath,
    method: "POST",
    data: dados,
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
  })

    .done(function (msg) {
      $('#codigoClassificacao').html(msg);
      $('#codigoClassificacaoEdit').html(msg);

    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}






$(function () {
  listagemFilmes();
  getSelectclassificacao()
  $('#tableFilmesTable').DataTable();
  $('.select2').select2();
});



