<?php
    session_start();

    if(isset($_SESSION['utilizador'])){ 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once 'assets/main/docHead.html' ?>
  
  <script src="src/js/contentFunctions/filmes.js"></script>

</head>

<body>
  <?php include_once 'assets/main/navbar.php' ?>


  <div class="container my-5">
    <div class="card">
      <div class="card-header">
        Novo Filme
      </div>
      <div class="mx-5 my-5">
        <form class="row g-3">

          <div class="col-md-3">
            <label for="idImbd" class="form-label">ID IMDB</label>
            <input type="number" class="form-control" id="idImbd">
          </div>
          <div class="col-md-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome">
          </div>
          <div class="col-md-3">
            <label for="ano" class="form-label">Ano</label>
            <input type="number" class="form-control" id="ano">
          </div>
          <div class="col-md-3">
              <label for="codigoClassificacao" class="form-label">Classificação</label>
              <select class="form-select select2" aria-label="Default select example" id="codigoClassificacao">
              </select>
            </div>
         
            <div class="col-md-6">
                                <label for="capa" class="form-label">Capa do filme</label>
                                <input type="file" class="form-control" id="capa">
                            </div>


          <div class="col-12">
            <button type="button" class="btn btn-primary" onclick="regista_Filme()">Registar</button>
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