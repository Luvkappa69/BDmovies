let controllerPath = "src/controller/controllerSessoes.php"


function regista_Sessao() {
  if (
    $('#dataHoradate').val() =="" ||
    $('#dataHoratime').val() =="" ||
    $('#codigoSala').val() ==-1 ||
    $('#idImbdFilme').val() ==-1

  ){
    return alerta("error", "Por favor preencha os campos ...");
}

  let dataHora = String($('#dataHoradate').val()) + " " +  String($('#dataHoratime').val()) + ":00"
  console.log(dataHora)
  let dados = new FormData();
  dados.append('dataHora', dataHora);
  dados.append('codigoSala', $('#codigoSala').val());
  dados.append('idImbdFilme', $('#idImbdFilme').val());

  
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
        alerta("error", "Verifique os dados");
      } else{
        alerta("success", msg);
      }
      
      listagem_Sessao();
    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });

}













function listagem_Sessao() {

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
      
      if ($.fn.DataTable.isDataTable('#tableSessoes')) {
        $('#tableSessoes').DataTable().destroy();
      }
      $('#tableSessoes').html(msg);
      $('#tableSessoesTable').DataTable({
        "columnDefs": [{
          "targets": '_all',
          "defaultContent": ""
        }]})
    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}











function remover_Sessao(key) {

  let dados = new FormData();
  dados.append('op', 3);
  dados.append('id', key);

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
      listagem_Sessao();
    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}










function edita_Sessao(key) {

  let dados = new FormData();
  dados.append('op', 4);
  dados.append('id', key);

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

      let dateTime = obj.dataHora;
      let date = dateTime.split(" ")[0];
      let time = dateTime.split(" ")[1].slice(0, 5);
      

      $('#dataHoradateEdit').val(date);
      $('#dataHoratimeEdit').val(time);
      $('#codigoSalaEdit').val(obj.codigoSala);
      $('#idImbdFilmeEdit').val(obj.idImbdFilme);

 
      $('#editModalSessao').modal('toggle');
      $('#btnGuardarEditSessao').attr('onclick', 'guardaEdit_Sessao(' + obj.id + ')')
    })
 
    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}








function guardaEdit_Sessao(key) {
  let dataHora = String($('#dataHoradate').val()) + " " +  String($('#dataHoratime').val()) + ":00"

  let dados = new FormData();

  dados.append('dataHora', dataHora);
  dados.append('codigoSala', $('#codigoSalaEdit').val());
  dados.append('idImbdFilme', $('#idImbdFilmeEdit').val());

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
      listagem_Sessao();
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



function getSelect_Cinema() {

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
      $('#codigoSala').html(msg);
      $('#codigoSalaEdit').html(msg);

    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}
function getSelect_Filme() {

  let dados = new FormData();
  dados.append('op', 8);



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
      $('#idImbdFilme').html(msg);
      $('#idImbdFilmeEdit').html(msg);

    })

    .fail(function (jqXHR, textStatus) {
      alert("Request failed: " + textStatus);
    });
}








$(function () {
  listagem_Sessao();
  getSelect_Cinema()
  getSelect_Filme()
  $('#tableSessoesTable').DataTable();
  $('.select2').select2();
});



