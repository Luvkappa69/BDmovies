<?php
    require_once 'utilities/connection.php';
    //require_once 'utilities/validadores.php';

    class Prato{

        function regista(
                                $nome,
                                $preco,
                                $idTipo,
                                $foto
                                ) {
            global $conn;
            $msg = "";
            $stmt = "";


            
            $upload = $this -> uploads(
                $foto,                    //Content
                'foto',            //Js into PHP variable name
                "_prato",                  //Nome do ficheiro
                $nome                   //Pasta
                );
            $upload = json_decode($upload, TRUE);


            if($upload['flag']){
                $stmt = $conn->prepare("INSERT INTO pratos (nome, preco, idTipo, foto) 
                VALUES (?, ?, ?, ?);");
                $stmt->bind_param("siis", 
                $nome,
                $preco,
                $idTipo,
                $upload['target']);
            }else{
                $stmt = $conn->prepare("INSERT INTO pratos (nome, preco, idTipo)
            VALUES (?, ?, ?)");
        
            $stmt->bind_param("sii", 
                                    $nome,
                                    $preco,
                                    $idTipo
                                        );
            }



        
         
            
            if ($stmt->execute()) {
                $msg = "Registado com sucesso!";
            } else {
                $msg = "Erro ao registar: " . $stmt->error;  
            } 

            $stmt->close();
                

            
          
            
            
            $conn->close();
            return $msg;
        }
        
        







        function lista() {
            global $conn;
            $msg = "<table class='table' id='tablePratosTable'>";
            $msg .= "<thead>";
            $msg .= "<tr>";
        
            $msg .= "<th>Foto</th>";
            $msg .= "<th>Nome</th>";
            $msg .= "<th>Preço</th>";
            $msg .= "<th>Tipo de Prato</th>";
          
            $msg .= "<td>Remover</td>";
            $msg .= "<td>Editar</td>";
        
            $msg .= "</tr>";
            $msg .= "</thead>";
            $msg .= "<tbody>";
        
            $stmt = $conn->prepare("SELECT * FROM pretos;"); 

            
        
            if ($stmt) { 
                if ($stmt->execute()) { 
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $msg .= "<tr>";

                            $msg .= "<td><img src=".$row['foto']." class='img-thumbnail img-size'></td>";
                            $msg .= "<th scope='row'>" . $row['Nome'] . "</th>";
                            $msg .= "<td>" . $row['preco'] . "</td>";
                            $msg .= "<td>" . $row['idTipo'] . "</td>";


                            if (session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }
                        
                            if(isset($_SESSION['utilizador']) && $_SESSION['tipo'] == 1){ 

                                $msg .= "<td><button type='button' class='btn btn-danger' onclick='remover(" . $row['id'] . ")'>Remover</button></td>";
                            }else{
                                $msg .= "<td><button type='button' class='btn btn-danger' disabled>Remover</button></td>";

                            }
                            $msg .= "<td><button type='button' class='btn btn-primary' onclick='edita(" . $row['id'] . ")'>Editar</button></td>";
                            $msg .= "</tr>";
                        }
                        $result->free(); 
                    } else {
                        $msg .= "<tr>";

                        $msg .= "<td>Sem resultados</td>";
                        $msg .= "<th scope='row'>Sem resultados</th>";
                        $msg .= "<td>Sem resultados</td>";                   
                        $msg .= "<td>Sem resultados</td>";                   
                    ;                                    

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
        
        














        function remove($codigo) {
            global $conn;
        
            $msg = "";
            $stmt = "";
        
            $stmt = $conn->prepare("DELETE FROM pratos
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
        












        function getDados($codigo) {
            global $conn;


            $stmt = $conn->prepare("SELECT * FROM pratos WHERE id = ?");
            $stmt->bind_param("i", $codigo);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

    
            $stmt->close();
            $conn->close();

            
            return json_encode($row);  
        }
        










        function edita(
        $nome,
        $preco,
        $idTipo,
        $telefone,
        $email,
        $oldKEY) {
            global $conn;
          
            $msg = "";
            $stmt = "";
        
            $stmt = $conn->prepare("UPDATE clientes,reserva SET 
                                    nif = ?,
                                    nome = ?,
                                    morada = ?,
                                    telefone = ?,
                                    email = ?,
                                    reserva.idCliente = ?
                                    WHERE nif = ?;");
        
            if ($stmt) { 
                $stmt->bind_param("issisii",
                $nif,
                $nome,
                $morada,
                $telefone,
                $email,
                $nif,
                $oldKEY
            );
        
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



















        function uploads($img, $html_soul, $presetName, $pasta){

            $dir = "../imagens/".$pasta."/";
            $dir1 = "src/imagens/".$pasta."/";
            $flag = false;
            $targetBD = "";
        
            if(!is_dir($dir)){
                if(!mkdir($dir, 0777, TRUE)){
                    die ("Erro não é possivel criar o diretório");
                }
            }
        
            if(array_key_exists($html_soul, $img)){
                if(is_array($img)){
                    if(is_uploaded_file($img[$html_soul]['tmp_name'])){
                        $fonte = $img[$html_soul]['tmp_name'];
                        $ficheiro = $img[$html_soul]['name'];
                        $end = explode(".",$ficheiro);
                        $extensao = end($end);
                
                        $newName =$presetName.date("YmdHis").".".$extensao;
                
                        $target = $dir.$newName;
                        $targetBD = $dir1.$newName;
        
                        $this -> wFicheiro($target);
                
                        $flag = move_uploaded_file($fonte, $target);
                        
                    } 
                }
            }
            return (json_encode(array(
                "flag" => $flag,
                "target" => $targetBD
            )));
        }
        
        function wFicheiro($texto){
            $file = '../prato_Upload_logs.txt';
            if (file_exists($file)) {
                $current = file_get_contents($file);
            } else {
                $current = '';
            }
            $current .= $texto."\n";
            file_put_contents($file, $current);
        }
        


    }

    
?>