<?php
    require_once 'utilities/connection.php';
    require_once 'utilities/validadores.php';

    class Filme{

        function registaFilme(
                                $idImbd,
                                $nome,
                                $ano,
                                $calss
                                ) {
            global $conn;
            $msg = "";
            $stmt = "";


                
            $stmt = $conn->prepare("INSERT INTO filme (idImbd,nome,ano,codigoClassificacao) 
            VALUES (?, ?, ?, ?)");
        
            $stmt->bind_param("isii", 
                                        $idImbd,
                                        $nome,
                                        $ano,
                                        $calss
                                        );
        
            if ($stmt->execute()) {
                $msg = "Registado com sucesso!";
            } else {
                $msg = "Erro ao registar: " . $stmt->error;  
            } 

            $stmt->close();
                


            
            
            $conn->close();
            return $msg;
        }
        








        function listaFilme() {
            global $conn;
            $msg = "<table class='table' id='tableFilmesTable'>";
            $msg .= "<thead>";
            $msg .= "<tr>";
        
            $msg .= "<th>ID IMDB</th>";
            $msg .= "<th>Nome</th>";
            $msg .= "<th>Ano</th>";
            $msg .= "<th>Classificação</th>";

        
            $msg .= "<td>Remover</td>";
            $msg .= "<td>Editar</td>";
        
            $msg .= "</tr>";
            $msg .= "</thead>";
            $msg .= "<tbody>";
        
            $stmt = $conn->prepare("SELECT filme.*, classificacao.descricao as descricaoFilme
            from filme, classificacao where filme.codigoClassificacao = classificacao.codigo;"); 


            
        
            if ($stmt) { 
                if ($stmt->execute()) { 
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $msg .= "<tr>";

                            $msg .= "<th scope='row'>" . $row['idImbd'] . "</th>";
                            $msg .= "<td>" . $row['nome'] . "</td>";
                            $msg .= "<td>" . $row['ano'] . "</td>";
                            $msg .= "<td>" . $row['descricaoFilme'] . "</td>";


                            session_start();
                        
                            if(isset($_SESSION['utilizador']) && $_SESSION['tipo'] == 1){ 

                            $msg .= "<td><button type='button' class='btn btn-danger' onclick='removerFilme(" . $row['idImbd'] . ")'>Remover</button></td>";
                            }else{
                                $msg .= "<td><button type='button' class='btn btn-danger' disabled>Remover</button></td>";

                            }
                            $msg .= "<td><button type='button' class='btn btn-primary' onclick='editaFilme(" . $row['idImbd'] . ")'>Editar</button></td>";
                            $msg .= "</tr>";
                        }
                        $result->free(); 
                    } else {
                        $msg .= "<tr>";

                        $msg .= "<th scope='row'>Sem resultados</th>";
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
        
        














        function removerFilme($codigo) {
            global $conn;
        
            $msg = "";
            $stmt = "";
        
            $stmt = $conn->prepare("DELETE FROM filme
                                    WHERE idImbd = ?");
        
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
        












        function getDadosFilme($codigo) {
            global $conn;


            $stmt = $conn->prepare("SELECT * FROM filme WHERE idImbd = ?");
            $stmt->bind_param("i", $codigo);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

    
            $stmt->close();
            $conn->close();

            
            return json_encode($row);  
        }
        










        function editaFilme( 
            $idImbd,
            $nome,
            $ano,
            $calss,
            $oldKEY
            ) {
            global $conn;
          
            $msg = "";
            $stmt = "";
        
            $stmt = $conn->prepare("UPDATE filme SET 
                                    idImbd = ?,
                                    nome = ?,
                                    ano = ?,
                                    codigoClassificacao = ?

                                    WHERE idImbd = ? ;");
        
            if ($stmt) { 
                $stmt->bind_param("isiii",            
                $idImbd,
                $nome,
                $ano,
                $calss,
                $oldKEY);
        
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
        

        function getSelectClassificacao(){
            global $conn;
            $msg = "<option value = '-1'>Escolha uma opção</option>";
            $stmt = "";


            $stmt = $conn->prepare("SELECT * FROM classificacao;");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $msg .= "<option value = '".$row['codigo']."'>".$row['descricao']."</option>";
                }
            } else {
                $msg .= "<option value = '-1'>Sem classificações</option>";
            }
            $stmt->close(); 
            $conn->close();
            
            return $msg;
        }
    }

    
?>