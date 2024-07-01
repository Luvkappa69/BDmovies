<?php
    require_once 'utilities/connection.php';
    require_once 'utilities/validadores.php';

    class Filme{

        function registaFilme(
                                $idImbd,
                                $nome,
                                $ano,
                                $capa,
                                $calss
                                ) {
            global $conn;
            $msg = "";
            $stmt = "";

            $folder = $nome;
            $upload = $this -> uploads(
                $capa,                    //Content
                'capa',            //Js into PHP variable name
                "_CAPA",                  //Nome do ficheiro
                $folder                   //Pasta
                );
            $upload = json_decode($upload, TRUE);


            if($upload['flag']){
                $stmt = $conn->prepare("INSERT INTO filme (idImbd, nome, ano, codigoClassificacao, capa) 
                VALUES (?, ?, ?, ?, ?);");
                $stmt->bind_param("ssiss", $idImbd,
                $nome,
                $ano,
                $calss, $upload['target']);
            }else{
                $stmt = $conn->prepare("INSERT INTO filme (idImbd, nome, ano, codigoClassificacao) 
            VALUES (?, ?, ?, ?)");
        
            $stmt->bind_param("isii", 
                                        $idImbd,
                                        $nome,
                                        $ano,
                                        $calss
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
        








        function listaFilme() {
            global $conn;
            $msg = "<table class='table' id='tableFilmesTable'>";
            $msg .= "<thead>";
            $msg .= "<tr>";
        

            $msg .= "<th>Nome</th>";
            $msg .= "<th>Ano</th>";


        
            $msg .= "<td>Remover</td>";
            $msg .= "<td>Editar</td>";
            $msg .= "<td>Info</td>";
        
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

                            $msg .= "<td scope='row'> " . $row['nome'] . "</td>";
                            $msg .= "<td>" . $row['ano'] . "</td>";


                            if (session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }
                        
                            if(isset($_SESSION['utilizador']) && $_SESSION['tipo'] == 1){ 

                            $msg .= "<td><button type='button' class='btn btn-danger' onclick='removerFilme(" . $row['idImbd'] . ")'>Remover</button></td>";
                            }else{
                                $msg .= "<td><button type='button' class='btn btn-danger' disabled>Remover</button></td>";

                            }
                            $msg .= "<td><button type='button' class='btn btn-primary' onclick='editaFilme(" . $row['idImbd'] . ")'>Editar</button></td>";
                            $msg .= "<td><button type='button' class='btn btn-info' onclick='showFilme(" . $row['idImbd'] . ")'>+Info</button></td>";
                            $msg .= "</tr>";
                        }
                        $result->free(); 
                    } else {
                        $msg .= "<tr>";

                        $msg .= "<th scope='row'>Sem resultados</th>";
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







        function getInfoFilme($codigo) {
            global $conn;


            $stmt = $conn->prepare("SELECT * FROM filme WHERE idImbd = ?");
            $stmt->bind_param("i", $codigo);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($row) {
                $codigoClassificacao = $row['codigoClassificacao'];
                $stmt = $conn->prepare("SELECT descricao FROM classificacao WHERE codigo = ?");
                $stmt->bind_param("i", $codigoClassificacao);
                $stmt->execute();
                $result = $stmt->get_result();
                $classificacaoRow = $result->fetch_assoc();
                $stmt->close();

                if ($classificacaoRow) {
                    $row['codigoClassificacao'] = $classificacaoRow['descricao'];
                }
            }
            $conn->close();

            return json_encode($row);  
        }
        










        function editaFilme( 
                            $idImbd,
                            $nome,
                            $ano,
                            $capa,
                            $calss,
                            $oldKEY
            ) {
            global $conn;
          
            $msg = "";
            $stmt = "";

            $folder = $nome;
            $upload = $this -> uploads(
                $capa,                    //Content
                'capa',            //Js into PHP variable name
                "_CAPA",                  //Nome do ficheiro
                $folder                   //Pasta
                );
            $upload = json_decode($upload, TRUE);


            if($upload['flag']){
                $stmt = $conn->prepare("UPDATE filme SET 
                                    idImbd = ?,
                                    nome = ?,
                                    ano = ?,
                                    capa = ?,
                                    codigoClassificacao = ?");
                $stmt->bind_param("ssiss", 
                                            $idImbd,
                                            $nome,
                                            $ano,
                                            $upload['target'],
                                            $calss, );
            }else{
                $stmt = $conn->prepare("UPDATE filme SET 
                                    idImbd = ?,
                                    nome = ?,
                                    ano = ?,
                                    codigoClassificacao = ?

                                    WHERE idImbd = ? ;");
                $stmt->bind_param("isiii",            
                                        $idImbd,
                                        $nome,
                                        $ano,
                                        $calss,
                                        $oldKEY);
            }
    
            if ($stmt->execute()) {
                $msg = "Edição efetuada";
            } else {
                $msg = "Erro ao editar: " . $stmt->error; 
            }
            $stmt->close(); 


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
            $file = '../capaFilme_Upload_logs.txt';
            if (file_exists($file)) {
                $current = file_get_contents($file);
            } else {
                $current = '';
            }
            $current .= $texto."\n";
            file_put_contents($file, $current);
        }







        function pesquisa($idFilme) {
            global $conn;
        
            // First query to get all sessions
            $stmt = $conn->prepare("SELECT * FROM sessao WHERE sessao.idImbdFilme = ?");
            $stmt->bind_param("i", $idFilme);
            $stmt->execute();
        
            $result = $stmt->get_result();
            $sessoes = [];
        
            while ($sessao = $result->fetch_assoc()) {
                // Second query to get the cinema name for each session
                $codigoSala = $sessao['codigoSala'];
                $stmtCinema = $conn->prepare("SELECT nome_cinema FROM cinema WHERE codigo = ?");
                $stmtCinema->bind_param("i", $codigoSala);
                $stmtCinema->execute();
        
                $resultCinema = $stmtCinema->get_result();
                $cinema = $resultCinema->fetch_assoc();
        
                // Combine session data with cinema name
                if ($cinema) {
                    $sessao['nome_cinema'] = $cinema['nome_cinema'];
                } else {
                    $sessao['nome_cinema'] = null; // Or some default value if cinema not found
                }
        
                $sessoes[] = $sessao;
        
                $stmtCinema->close();
            }
        
            $stmt->close();
            $conn->close();
        
            return json_encode($sessoes);
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