<?php
    session_start();

    if(isset($_SESSION['utilizador'])){ 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once 'assets/main/docHead.html' ?>
  
  <script src="src/js/contentFunctions/cinemas.js"></script>

</head>

<body>
  <?php include_once 'assets/main/navbar.php' ?>


  <div class="container my-5">
    <div class="card">
      <div class="card-header">
        Novo Cinema
      </div>
      <div class="mx-5 my-5">
        <form class="row g-3">

          <div class="col-md-3">
            <label for="codigo" class="form-label">Codigo</label>
            <input type="number" class="form-control" id="codigo">
          </div>
          <div class="col-md-3">
            <label for="nome_cinema" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome_cinema">
          </div>
          <div class="col-md-3">
            <label for="telefone_cinema" class="form-label">Telefone</label>
            <input type="number" class="form-control" id="telefone_cinema">
          </div>
          <div class="col-md-3">
            <label for="morada_cinema" class="form-label">Morada</label>
            <input type="text" class="form-control" id="morada_cinema">
          </div>
          <div class="col-md-3">
            <label for="codPostal_cinema" class="form-label">Codigo Postal</label>
            <input type="text" class="form-control" id="codPostal_cinema" placeholder="0000-000">
          </div>
          <div class="col-md-3">
            <label for="arruamento_cinema" class="form-label">Arruamento</label>
            <input type="number" class="form-control" id="arruamento_cinema">
          </div>
          <div class="col-md-3">
            <label for="localidade_cinema" class="form-label">Localidade</label>
            <input type="text" class="form-control" id="localidade_cinema">
          </div>
          <div class="col-md-3">
            <label for="dataInau_cinema" class="form-label">Data de Inauguração</label>
            <input type="date" class="form-control" id="dataInau_cinema">
          </div>
         


          <div class="col-12">
            <button type="button" class="btn btn-primary" onclick="regista_cinema()">Registar</button>
          </div>
        </form>
      </div>
    </div>

    


</body>
</html>

<?php 
}else{
    echo "sem permissão!";
}
?>