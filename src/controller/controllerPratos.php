<?php
require_once '../model/modelClientes.php';

$prato =  new Prato();

if($_POST['op'] == 1){
    $resultado = $prato -> regista(
                                                $_POST['nome'], 
                                                $_POST['preco'], 
                                                $_POST['idTipo'], 
                                                $_FILES

    );
    echo($resultado);
}else if($_POST['op'] == 2){
    $resultado = $prato -> lista();
    echo($resultado);
}else if($_POST['op'] == 3){
    $resultado = $prato -> remove(
                                                $_POST['id']                                               
    );
    echo($resultado);
}else if($_POST['op'] == 4){
    $resultado = $prato -> getDados(
                                                $_POST['id']                                               
    );
    echo($resultado);
}else if($_POST['op'] == 5){
    $resultado = $prato -> edita(
                                                $_POST['nome'], 
                                                $_POST['preco'], 
                                                $_POST['idTipo'], 
                                                $_FILES, 
                                                $_POST['old_key']
    );
    echo($resultado);
}

?>