<?php
require_once '../model/modelCinemas.php';

$cinema =  new Cinema();

if($_POST['op'] == 1){
    $resultado = $cinema -> registaCinema(
                                                $_POST['codigo'], 
                                                $_POST['nome_cinema'], 
                                                $_POST['telefone_cinema'], 
                                                $_POST['morada_cinema'], 
                                                $_POST['codPostal_cinema'], 
                                                $_POST['arruamento_cinema'], 
                                                $_POST['localidade_cinema'], 
                                                $_POST['dataInau_cinema']

    );
    echo($resultado);
}else if($_POST['op'] == 2){
    $resultado = $cinema -> listaCinema();
    echo($resultado);
}else if($_POST['op'] == 3){
    $resultado = $cinema -> removerCinema(
                                                $_POST['codigo']                                               
    );
    echo($resultado);
}else if($_POST['op'] == 4){
    $resultado = $cinema -> getDadosCinema(
                                                $_POST['codigo']                                               
    );
    echo($resultado);
}else if($_POST['op'] == 5){
    $resultado = $cinema -> editaCinema(
                                                $_POST['codigo'], 
                                                $_POST['nome_cinema'], 
                                                $_POST['telefone_cinema'], 
                                                $_POST['morada_cinema'], 
                                                $_POST['codPostal_cinema'], 
                                                $_POST['arruamento_cinema'], 
                                                $_POST['localidade_cinema'], 
                                                $_POST['dataInau_cinema'], 
                                                $_POST['old_key']
    );
    echo($resultado);
}

?>