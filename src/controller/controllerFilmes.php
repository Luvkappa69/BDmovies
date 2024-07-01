<?php
require_once '../model/modelFilmes.php';

$filme =  new Filme();

if($_POST['op'] == 1){
    $resultado = $filme -> registaFilme(
                                                $_POST['idImbd'], 
                                                $_POST['nome'], 
                                                $_POST['ano'], 
                                                $_FILES, 
                                                $_POST['codigoClassificacao']
    );
    echo($resultado);
}else if($_POST['op'] == 2){
    $resultado = $filme -> listaFilme();
    echo($resultado);
}else if($_POST['op'] == 3){
    $resultado = $filme -> removerFilme(
                                                $_POST['idImbd']                                               
    );
    echo($resultado);
}else if($_POST['op'] == 4){
    $resultado = $filme -> getDadosFilme(
                                                $_POST['idImbd']                                               
    );
    echo($resultado);
}else if($_POST['op'] == 8){
    $resultado = $filme -> getInfoFilme(
                                                $_POST['idImbd']                                               
    );
    echo($resultado);
}else if($_POST['op'] == 5){
    $resultado = $filme -> editaFilme(
                                                $_POST['idImbd'], 
                                                $_POST['nome'], 
                                                $_POST['ano'],
                                                $_FILES, 
                                                $_POST['codigoClassificacao'],
                                                $_POST['old_key']
    );
    echo($resultado);
}
else if($_POST['op'] == 7){
    $resultado = $filme -> getSelectClassificacao();
    echo($resultado);
}

?>