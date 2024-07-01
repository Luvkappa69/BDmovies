<?php
    function isActive($page) {
        if (basename($_SERVER['PHP_SELF']) == $page) {
            return "activemenu";
        }
    }
    if(isset($_SESSION['utilizador']) && $_SESSION['tipo'] == 1){
?>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="src/img/logo.png">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">


                <li class="nav-item dropdown <?= isActive('cinemas.php') ?> <?= isActive('listaCinemas.php') ?>">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cinemas
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= isActive('cinemas.php') ?>" href="cinemas.php">Adicionar</a></li>
                        <li><a class="dropdown-item <?= isActive('listaCinemas.php') ?>" href="listaCinemas.php">Listar</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown <?= isActive('filmes.php') ?> <?= isActive('listaFilmes.php') ?>">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Filmes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= isActive('filmes.php') ?>" href="filmes.php">Adicionar</a></li>
                        <li><a class="dropdown-item <?= isActive('listaFilmes.php') ?>" href="listaFilmes.php">Listar</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown <?= isActive('sessoes.php') ?> <?= isActive('listaSessoes.php') ?>">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sessões
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= isActive('sessoes.php') ?>" href="sessoes.php">Adicionar</a></li>
                        <li><a class="dropdown-item <?= isActive('listaSessoes.php') ?>" href="listaSessoes.php">Listar</a></li>
                    </ul>
                </li>
                

                <li class="nav-item <?= isActive('main.php') ?>">
                    <a class="nav-link" href="main.php" role="button" aria-expanded="false">Profile</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php 
} else {
?>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="src/img/logo.png">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item dropdown <?= isActive('cinemas.php') ?> <?= isActive('listaCinemas.php') ?>">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cinemas
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= isActive('cinemas.php') ?>" href="cinemas.php">Adicionar</a></li>
                        <li><a class="dropdown-item <?= isActive('listaCinemas.php') ?>" href="listaCinemas.php">Listar</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown <?= isActive('cinemas.php') ?> <?= isActive('listaCinemas.php') ?>">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Filmes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= isActive('filmes.php') ?>" href="filmes.php">Adicionar</a></li>
                        <li><a class="dropdown-item <?= isActive('listaFilmes.php') ?>" href="listaFilmes.php">Listar</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown <?= isActive('sessoes.php') ?> <?= isActive('listaSessoes.php') ?>">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sessões
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= isActive('sessoes.php') ?>" href="sessoes.php">Adicionar</a></li>
                        <li><a class="dropdown-item <?= isActive('listaSessoes.php') ?>" href="listaSessoes.php">Listar</a></li>
                    </ul>
                </li>
                <li class="nav-item <?= isActive('main.php') ?>">
                    <a class="nav-link" href="main.php" role="button" aria-expanded="false">Profile</a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>

<?php    
}
?>

<div style="display: none;">
    Current Page: <?= basename($_SERVER['PHP_SELF']) ?>
</div>





