<?php
    session_start(); // ATIVA NO php O USO DAS VARIÁVEIS DE SESSÃO

    // INCLUSÃO DO ARQUIVO
    require_once('conexaoBanco.php');

    // CHAMA A FUNÇÃO PARA CONECTAR COM O BANCO DE DADOS
    ConexaoBanco();

    // VARIÁVEIS
    $nome = "";
    $email = "";
    $celular = "";
    $botao = "Cadastrar";

// EXCLUIR CADASTRO

// VERIFICA SE EXISTE UMA VARIÁVEL CHAMADA $modo NA URL
if(isset($_GET['modo'])){
    // PEGA O CONTEÚDO DA VARIÁVEL $modo
    $modo=$_GET['modo'];
    
    // VERIFICA SE A VARIÁVEL $modo=excluir
    if($modo=='excluir'){
        // RESGATA O CÓDIGO PASSADO NA URL
        $idContato=$_GET['idContato'];
        // DELETA NO BANCO DE DADOS O REGISTRO CADASTRADO
        $sql="DELETE FROM contato WHERE idContato=".$idContato;
        mysql_query($sql);
        
        header('location:index.php');
                
    // EDITAR CADASTRO
    }else if($modo=='consulta_editar'){
        $botao = "Editar";
        // RESGATA O CÓDIGO PASSADO NA URL
        $idContato=$_GET['idContato'];
        
        // VARIÁVEL DE SESSÃO
        $_SESSION['contato'] = $idContato; // GUARDA O CÓDIGO DO REGISTRO QUE SERÁ ATUALIZADO NO UPDATE
            
        $sql="SELECT * FROM contato WHERE idContato=".$idContato;
        
        // GUARDA NA VARIÁVEL $select O RETORNO DOS REGISTROS CADASTRADOS NO BANCO DE DADOS
        $select = mysql_query($sql);
        
        if($rsConsulta=mysql_fetch_array($select)){
            // RASGATA TODOS OS DADOS DO BANCO DE DADOS E GUARDA NAS VARIÁVEIS LOCAIS
            $nome=$rsConsulta['nome'];
            $email=$rsConsulta['email'];
            $celular=$rsConsulta['celular'];
        }
    }
}

    // VERIFICA SE O BOTÃO CADASTRAR FOI CLICADO
    if(isset($_POST["btnCadastrar"])){
        
        // RESGATANDO OS VALORES DO FORMULÁRIO
        $nome = $_POST["txtNome"];
        $email = $_POST["txtEmail"];
        $celular = $_POST["txtCelular"];
        
        if($_POST["btnCadastrar"]=="Cadastrar"){
            
            // MONTA O Script PARA ENVIAR PARA O DB
            $sql="INSERT INTO contato(nome, email, celular) values('".$nome."', '".$email."', '".$celular."')";
            
        }else if($_POST["btnCadastrar"]=="Editar"){
            
            $sql = "UPDATE contato SET nome='".$nome."', email='".$email."', celular='".$celular."' WHERE idContato=".$_SESSION['contato'];
        }
    
        mysql_query($sql); // EXECUTA O SCRIPT NO BANCO DE DADOS
        header('location:index.php');
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cadastro de Contatos</title>
        <meta charset="utf-8">
        <!-- INCLUINDO OS ARQUIVOS CSS PARA ESTILIZAR A PÁGINA -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/animate.css">
        <link rel="icon" type="image/jpg" href="icones/user.png"/>
        <!-- INCLUINDO UM ARQUIVO JavaScript PARA O TRATAMENTO DAS CAIXAS DE TEXROS -->
        <script type="text/javascript" src="js/validacao.js"></script>
    </head>
    <body>
        <!-- CABEÇALHO -->
        <header id="cabecalho">
            <p id="fomatar">Cadastro de Contatos</p>
        </header>
        <!-- FORMULÁRIO -->
        <form name="frmCadContatos" method="post" action="index.php">
            <!-- CORPO DO FORMULÁRIO -->
            <main id="content">
                <!-- ÁREA PARA CADASTRAR CONTATOS -->
                <div id="bloco_cadastro">
                    <p class="format">Nome:</p>
                    <div id="text_nome">
                        <input id="input_nome" onkeypress="return validarNumero(event, 'number')" type="text" name="txtNome" value="<?php echo($nome) ?>" maxlength="100" size="35" pattern="[a-z A-Z ã Ã õ Õ é É í Í á Á ô Ô ç Ç]*" title="*** Digitação apenas de letras ***" placeholder="Digite seu nome" required>

                    </div>
                    <p class="format">E-mail:</p>
                    <div id="text_email">
                        <input id="input_email" type="text" name="txtEmail" value="<?php echo($email) ?>" maxlength="50" size="35" placeholder="Digite seu e-mail" required >

                    </div>
                    <p class="format">Celular:</p>
                    <div id="text_celular">
                        <input id="input_celular" onkeypress="return validarNumero(event, 'caracter', 'celular')" type="text" name="txtCelular" value="<?php echo($celular) ?>" maxlength="15" size="20" placeholder="Digite seu celular" required>
                    </div>
                    <!-- BOTÃO QUE ENVIA O CADASTRO PARA O BANCO DE DADOS -->
                    <div id="centralizar_btn">
                        <input id="btn" type="submit" name="btnCadastrar" value="<?php echo($botao) ?>">
                    </div>
                </div>
               
                <!-- ÁREA PARA CONSULTAR CONTATOS -->
                <div id="bloco_consulta">
                    <div id="div_campo">
                        <div class="nome_email">Nome</div>
                        <div class="nome_email">E-mail</div>
                        <div id="campo_celular">Celular</div>
                        <div id="campo_opcoes">Opções</div>
                    </div>
                     <?php
                        // COLOCA EM ORDEM OS REGISTROS CADASTRADOS DO ÚLTIMO PARA O PRIMEIRO
                        $sql="select * from contato order by idContato desc";
                        $select=mysql_query($sql);

                        while($rsConsulta=mysql_fetch_array($select)){
                    ?>
                    <div class="linhas_consulta">
                        <div class="consuta_nome_email">
                            <?php echo($rsConsulta['nome']) ?>
                        </div>
                        <div class="consuta_nome_email">
                           <?php echo($rsConsulta['email']) ?>
                        </div>
                        <div id="consulta_cel">
                            <?php echo($rsConsulta['celular']) ?>
                        </div>
                        <div id="opcoes">
                            <div id="centralizar_opcoes">
                                <div class="opcao_delete_update">
                                    <a href="index.php?modo=consulta_editar&idContato=<?php echo($rsConsulta['idContato'])?>">
                                        <img src="icones/edit.png" alt="Editar contato" title="Editar contato">
                                    </a>
                                </div>
                                <div class="opcao_delete_update">
                                    <a href="index.php?modo=excluir&idContato=<?php echo($rsConsulta['idContato'])?>">
                                        <img src="icones/delete.png" alt="Deletar contato" title="Deletar contato">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>  
                </div>
            </main>
        </form>
    </body>
</html>