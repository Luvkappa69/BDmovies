<?php
    require_once 'utilities/connection.php';
    require_once 'utilities/validadores.php';

    class Cinema{

        function registaCinema(
                                $cod,
                                $nome,
                                $tel,
                                $morada,
                                $codPostal,
                                $arruamento,
                                $localidade,
                                $dataInau

                                ) {
            global $conn;
            $msg = "";
            $stmt = "";

            $tempPostal = $codPostal;
            if(
                !validateNine($tel) &&
                !validatePostalCodePT($tempPostal)
            ){
                
                $stmt = $conn->prepare("INSERT INTO cinema (codigo, nome_cinema, telefone_cinema, morada_cinema, codPostal_cinema, arruamento_cinema, localidade_cinema, dataInau_cinema) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
                $stmt->bind_param("isississ", 
                                                $cod,
                                                $nome,
                                                $tel,
                                                $morada,
                                                $codPostal,
                                                $arruamento,
                                                $localidade,
                                                $dataInau
                                            );
            
                if ($stmt->execute()) {
                    $msg = "Registado com sucesso!";
                } else {
                    $msg = "Erro ao registar: " . $stmt->error;  
                } 

                $stmt->close();
                

            }
            else{
                $msg = 0;
            }
            
            
            $conn->close();
            return $msg;
        }
        








        function listaCinema() {
            global $conn;
            $msg = "<table class='table' id='tableCinemasTable'>";
            $msg .= "<thead>";
            $msg .= "<tr>";
        
            $msg .= "<th>Codigo</th>";
            $msg .= "<th>Nome</th>";
            $msg .= "<th>Telefone</th>";
            $msg .= "<th>Morada</th>";
            $msg .= "<th>Codigo Postal</th>";
            $msg .= "<th>Arruamento</th>";
            $msg .= "<th>Localidade</th>";
            $msg .= "<th>Data de Inauguração</th>";
           

        
            $msg .= "<td>Remover</td>";
            $msg .= "<td>Editar</td>";
        
            $msg .= "</tr>";
            $msg .= "</thead>";
            $msg .= "<tbody>";
        
            $stmt = $conn->prepare("SELECT * FROM cinema;"); 

            
        
            if ($stmt) { 
                if ($stmt->execute()) { 
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $msg .= "<tr>";

                            $msg .= "<th scope='row'>" . $row['codigo'] . "</th>";
                            $msg .= "<td>" . $row['nome_cinema'] . "</td>";
                            $msg .= "<td>" . $row['telefone_cinema'] . "</td>";
                            $msg .= "<td>" . $row['morada_cinema'] . "</td>";
                            $msg .= "<td>" . $row['codPostal_cinema'] . "</td>";
                            $msg .= "<td>" . $row['arruamento_cinema'] . "</td>";
                            $msg .= "<td>" . $row['localidade_cinema'] . "</td>";
                            $msg .= "<td>" . $row['dataInau_cinema'] . "</td>";

                            if (session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }
                        
                            if(isset($_SESSION['utilizador']) && $_SESSION['tipo'] == 1){ 

                                $msg .= "<td><button type='button' class='btn btn-danger' onclick='removerCinema(" . $row['codigo'] . ")'>Remover</button></td>";
                            }else{
                                $msg .= "<td><button type='button' class='btn btn-danger' disabled>Remover</button></td>";

                            }
                            $msg .= "<td><button type='button' class='btn btn-primary' onclick='editaCinema(" . $row['codigo'] . ")'>Editar</button></td>";
                            $msg .= "</tr>";
                        }
                        $result->free(); 
                    } else {
                        $msg .= "<tr>";

                        $msg .= "<th scope='row'>Sem resultados</th>";
                        $msg .= "<td>Sem resultados</td>";
                        $msg .= "<td>Sem resultados</td>";                   
                        $msg .= "<td>Sem resultados</td>";                   
                        $msg .= "<td>Sem resultados</td>";                   
                        $msg .= "<td>Sem resultados</td>";                   
                        $msg .= "<td>Sem resultados</td>";                   
                        $msg .= "<td>Sem resultados</td>";                   

                        $msg .= "<td></td>";
                        $msg .= "<td></td>";
                        $msg .= "</tr>";
                    }
                } else {
                    echo "Error executing query: " . $stmt->error; 
                }
                $stmt->close(); 
            } else {
                echo "Error preparing statement: " . $conn->error; 
            }
        
            $msg .= "</tbody>";
            $msg .= "</table>";

            $conn->close();
        
            return $msg;
        }
        
        














        function removerCinema($codigo) {
            global $conn;
        
            $msg = "";
            $stmt = "";
        
            $stmt = $conn->prepare("DELETE FROM cinema
                                    WHERE codigo = ?");
        
            $stmt->bind_param("i", $codigo); 
        
            if ($stmt->execute()) {
                $msg = "Removido com sucesso!";
            } else {
                $msg = "Erro ao remover: " . $stmt->error; 
            }
        
            $stmt->close();
            $conn->close();

        
            return $msg;
        }
        












        function getDadosCinema($codigo) {
            global $conn;


            $stmt = $conn->prepare("SELECT * FROM cinema WHERE codigo = ?");
            $stmt->bind_param("i", $codigo);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

    
            $stmt->close();
            $conn->close();

            
            return json_encode($row);  
        }
        










        function editaCinema($cod,
        $nome,
        $tel,
        $morada,
        $codPostal,
        $arruamento,
        $localidade,
        $dataInau, $oldKEY) {
            global $conn;
          
            $msg = "";
            $stmt = "";
        
            $stmt = $conn->prepare("UPDATE cinema SET 
                                    codigo = ?,
                                    nome_cinema = ?,
                                    telefone_cinema = ?,
                                    morada_cinema = ?,
                                    codPostal_cinema = ?,
                                    arruamento_cinema = ?,
                                    localidade_cinema = ?,
                                    dataInau_cinema = ?

                                    WHERE codigo = ? ;");
        
            if ($stmt) { 
                $stmt->bind_param("isisiissi",$cod,
                $nome,
                $tel,
                $morada,
                $codPostal,
                $arruamento,
                $localidade,
                $dataInau, $oldKEY);
        
                if ($stmt->execute()) {
                    $msg = "Edição efetuada";
                } else {
                    $msg = "Erro ao editar: " . $stmt->error; 
                }
                $stmt->close(); 
            } else {
                $msg = "Erro ao preparar a declaração: " . $conn->error;  
            }

            $conn->close();
        
            return $msg;

        }
        


    }

    
?>