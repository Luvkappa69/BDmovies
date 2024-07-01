let controllerPath = "src/controller/controllerCinemas.php"


function regista_cinema() {
  if (
    $('#codigo').val() =="" ||
    $('#nome_cinema').val() =="" ||
    $('#telefone_cinema').val() =="" ||
    $('#morada_cinema').val() =="" ||

    $('#codPostal_cinema').val() =="" ||
    $('#arruamento_cinema').val() =="" ||
    $('#localidade_cinema').val() =="" ||
    $('#dataInau_cinema').val() =="" 

  ){
    return alerta("error", "Por favor preencha os campos ...");
}

  let dados = new FormData();
  dados.append('codigo', $('#codigo').val());
  dados.append('nome_cinema', $('#nome_cinema').val());
  dados.append('telefone_cinema', $('#telefone_cinema').val());
  dados.append('morada_cinema', $('#morada_cinema').val());

  dados.append('codPostal_cinema', $('#codPostal_cinema').val());
  dados.append('arruamento_cinema', $('#arruamento_cinema').val());
  dados.append('localidade_cinema', $('#localidade_cinema').val());
  dados.append('dataInau_cinema', $('#dataInau_cinema').val());

  
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
      
      listagemCinema();
    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });

}













function listagemCinema() {

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
      
      if ($.fn.DataTable.isDataTable('#tableCinemas')) {
        $('#tableCinemas').DataTable().destroy();
      }
      $('#tableCinemas').html(msg);
      $('#tableCinemasTable').DataTable({
        "columnDefs": [{
          "targets": '_all',
          "defaultContent": ""
        }]})
    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}











function removerCinema(key) {

  let dados = new FormData();
  dados.append('op', 3);
  dados.append('codigo', key);

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
      listagemCinema();
      getSelectLocais()
    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}










function editaCinema(key) {

  let dados = new FormData();
  dados.append('op', 4);
  dados.append('codigo', key);

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

      $('#codigoEdit').val(obj.codigo);
      $('#nome_cinemaEdit').val(obj.nome_cinema);
      $('#telefone_cinemaEdit').val(obj.telefone_cinema);
      $('#morada_cinemaEdit').val(obj.morada_cinema);
      $('#codPostal_cinemaEdit').val(obj.codPostal_cinema);
      $('#arruamento_cinemaEdit').val(obj.arruamento_cinema);
      $('#localidade_cinemaEdit').val(obj.localidade_cinema);
      $('#dataInau_cinemaEdit').val(obj.dataInau_cinema);




      $('#editModalCinema').modal('toggle');
      $('#btnGuardarEditCinema').attr('onclick', 'guardaEditCinema(' + obj.codigo + ')')
    })
 
    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}








function guardaEditCinema(key) {

  let dados = new FormData();

  dados.append('nome_cliente', $('#nome_clienteEdit').val());
  dados.append('morada_cliente', $('#morada_clienteEdit').val());
  dados.append('localidade_cliente', $('#localidade_clienteEdit').val());
  
  dados.append('cosPostal_cliente', $('#cosPostal_clienteEdit').val());
  dados.append('nif_cliente', $('#nif_clienteEdit').val());
  dados.append('email_cliente', $('#email_clienteEdit').val());
  dados.append('contacto_cliente', $('#contacto_clienteEdit').val());

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
      listagemCinema();
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












$(function () {
  listagemCinema();
  $('#tableCinemasTable').DataTable();
});



