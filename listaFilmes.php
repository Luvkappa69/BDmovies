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
        Pesquise o Filme!
        </div>
      <div class="mx-5 my-5">
        <form class="row g-3">

          <div class="col-md-3">
              <label for="pesquisaFilme" class="form-label"><h1>Filme</h1></label>
              <select class="form-select select2" aria-label="Default select example" id="pesquisaFilme" onchange="pesquisar()">
              </select>
          </div>

          <div class="row mt-5">

            <div class="col-md-4 card">
              <h3 class="card-header">Cinema</h3>
              <div id="cinemaDoFilme">

              </div>
            </div>

            <div class="col-md-1 "></div>
            
            <div class="col-md-6 card">
              <h3 class="card-header">Sessões Disponiveis</h3>
              <div id="sessaoDoFilme">

              </div>
            </div>

          </div>

        </form>
      </div>
    </div>

    <br><br><hr><br><br>
    
    <div class="container">
        <div class="row mx-5 mb-5">
            <div id="tableFilmes"></div>
        </div>
    </div>
    
    <?php include_once 'assets/filmesModal.html' ?>
    <?php include_once 'assets/infoFilmesModal.html' ?>
</body>
</html>
<?php 
}else{
    echo "sem permissão!";
}

?>