<?php
require_once '../model/modelSessoes.php';

$sessao =  new Sessao();

if($_POST['op'] == 1){
    $resultado = $sessao -> regista_Sessao(
                                                $_POST['dataHora'], 
                                                $_POST['codigoSala'], 
                                                $_POST['idImbdFilme']
    );
    echo($resultado);
}else if($_POST['op'] == 2){
    $resultado = $sessao -> lista_Sessao();
    echo($resultado);
}else if($_POST['op'] == 3){
    $resultado = $sessao -> remover_Sessao(
                                                $_POST['id']                                               
    );
    echo($resultado);
}else if($_POST['op'] == 4){
    $resultado = $sessao -> getDados_Sessao(
                                                $_POST['id']                                               
    );
    echo($resultado);
}else if($_POST['op'] == 5){
    $resultado = $sessao -> edita_Sessao(
                                                $_POST['dataHora'], 
                                                $_POST['codigoSala'], 
                                                $_POST['idImbdFilme'],
                                                $_POST['old_key']
    );
    echo($resultado);
}
else if($_POST['op'] == 7){
    $resultado = $sessao -> getSelect_Cinema();
    echo($resultado);
}
else if($_POST['op'] == 8){
    $resultado = $sessao -> getSelect_Filme();
    echo($resultado);
}

?>