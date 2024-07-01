<?php
    require_once 'utilities/connection.php';

    class Sessao{

        function regista_Sessao(
                                $dataHora,
                                $cinema,
                                $filme
                                ) {
            global $conn;
            $msg = "";
            $stmt = "";


                
            $stmt = $conn->prepare("INSERT INTO sessao (dataHora,codigoSala,idImbdFilme) 
            VALUES (?, ?, ?)");
        
            $stmt->bind_param("sii", 
                                    $dataHora,
                                    $cinema,
                                    $filme
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
        








        function lista_Sessao() {
            global $conn;
            $msg = "<table class='table' id='tableSessoesTable'>";
            $msg .= "<thead>";
            $msg .= "<tr>";
        

            $msg .= "<th>Data/Hora</th>";
            $msg .= "<th>Cinema</th>";
            $msg .= "<th>Filme</th>";

        
            $msg .= "<td>Remover</td>";
            $msg .= "<td>Editar</td>";
        
            $msg .= "</tr>";
            $msg .= "</thead>";
            $msg .= "<tbody>";
        
            $stmt = $conn->prepare("SELECT sessao.*, 
            cinema.nome_cinema as cinemaNome,
            filme.nome as filmeNome
            from sessao, cinema, filme 
            where sessao.codigoSala = cinema.codigo and
             sessao.idImbdFilme = filme.idImbd;"); 


            
        
            if ($stmt) { 
                if ($stmt->execute()) { 
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $msg .= "<tr>";

                            $msg .= "<th scope='row'>" . $row['dataHora'] . "</th>";
                            $msg .= "<td>" . $row['cinemaNome'] . "</td>";
                            $msg .= "<td>" . $row['filmeNome'] . "</td>";



                            session_start();
                        
                            if(isset($_SESSION['utilizador']) && $_SESSION['tipo'] == 1){ 

                            $msg .= "<td><button type='button' class='btn btn-danger' onclick='remover_Sessao(" . $row['id'] . ")'>Remover</button></td>";
                            }else{
                                $msg .= "<td><button type='button' class='btn btn-danger' disabled>Remover</button></td>";

                            }
                            $msg .= "<td><button type='button' class='btn btn-primary' onclick='edita_Sessao(" . $row['id'] . ")'>Editar</button></td>";
                            $msg .= "</tr>";
                        }
                        $result->free(); 
                    } else {
                        $msg .= "<tr>";

                        $msg .= "<th scope='row'>Sem resultados</th>";
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
        
        














        function remover_Sessao($codigo) {
            global $conn;
        
            $msg = "";
            $stmt = "";
        
            $stmt = $conn->prepare("DELETE FROM sessao
                                    WHERE id = ?");
        
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
        












        function getDados_Sessao($codigo) {
            global $conn;


            $stmt = $conn->prepare("SELECT * FROM sessao WHERE id = ?");
            $stmt->bind_param("i", $codigo);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

    
            $stmt->close();
            $conn->close();

            
            return json_encode($row);  
        }
        










        function edita_Sessao( 
            $dataHora,
            $cinema,
            $filme,
            $oldKEY
            ) {
            global $conn;
          
            $msg = "";
            $stmt = "";
        
            $stmt = $conn->prepare("UPDATE sessao SET 
                                    dataHora = ?,
                                    codigoSala = ?,
                                    idImbdFilme = ?

                                    WHERE id = ? ;");
        
            if ($stmt) { 
                $stmt->bind_param("siii",            
                $dataHora,
                $cinema,
                $filme,
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
        

        function getSelect_Cinema(){
            global $conn;
            $msg = "<option value = '-1'>Escolha uma opção</option>";
            $stmt = "";


            $stmt = $conn->prepare("SELECT * FROM cinema;");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $msg .= "<option value = '".$row['codigo']."'>".$row['nome_cinema']."</option>";
                }
            } else {
                $msg .= "<option value = '-1'>Sem Cinemas</option>";
            }
            $stmt->close(); 
            $conn->close();
            
            return $msg;
        }
        function getSelect_Filme(){
            global $conn;
            $msg = "<option value = '-1'>Escolha uma opção</option>";
            $stmt = "";


            $stmt = $conn->prepare("SELECT * FROM filme;");
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $msg .= "<option value = '".$row['idImbd']."'>".$row['nome']."</option>";
                }
            } else {
                $msg .= "<option value = '-1'>Sem Cinemas</option>";
            }
            $stmt->close(); 
            $conn->close();
            
            return $msg;
        }
    }

    
?>