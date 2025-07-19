<?php
session_start();
if (isset($_POST['limpar']) && $_POST['limpar'] == 1) {
    $_SESSION['tarefas'] = [];
}
/* 
class tarefas
{
    public $titulo;
    public $descricao;
    public $concluida;

    public function __construct($titulo, $descricao, $concluida)
    {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->concluida = $concluida;
    }
    public function marcarComoConcluida()
    {
        echo $this->concluida = '->Concluída';
    }
}
*/

class listaDeTarefas
{
    public $tarefa = [];

    public $titulo;
    public $descricao;
 

    public function adicionarTarefa($titulo, $descricao)
    {
        $novaTarefa = new listaDeTarefas($titulo, $descricao);
        $this->tarefa[] = $novaTarefa;
        return $novaTarefa;
    }

    public function estruturaDeExibicao($tarefas){
     $html = '<table  border=1>' ;
    $html .= "<thead><tr><th>Tarefa</th><th>Descrição</th></tr></thead>";
    $html .= "<tbody>";
    foreach ($tarefas as $tarefa) {
        $html .= "<tr>";
        $html .= "<td>" . htmlspecialchars($tarefa['titulo']) . "</td>"; // ✅ Correto agora
        $html .= "<td>" . htmlspecialchars($tarefa['descricao']) . "</td>"; // ✅ Correto agora
        $html .= "</tr>";
    }
    $html .= "</tbody></table>";
    return $html;
}
}


$tarefaManager = new listaDeTarefas();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';

  if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [];
}

// Se o formulário foi enviado, adiciona a nova tarefa na sessão
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $titulo && $descricao) {
    $_SESSION['tarefas'][] = [
        'titulo' => $titulo,
        'descricao' => $descricao
    ];
}   
}

$tabelaHtml = $tarefaManager->estruturaDeExibicao($_SESSION['tarefas']);


?>

<!DOCTYPE html>
<html>

<head>
    <title>Controle de tarefas</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">


    <style>
        .form-custom {
            margin: 40px 100px;
            border-radius: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <form action="index.php" method="POST" enctype="multipart/form-data">

        <h2 class="title_main"> Controle de Tarefas</h2>

        <div class="col form-custom">
            <p class=text_form> Digite um titulo para tarefa:</p>
            <input type="text" class="form-control" placeholder="título" name="titulo">
        </div>

        <div class="col form-custom">
            <p class="text_form"> Digite uma descrição para tarefa:</p>
            <input type="text" class="form-control" placeholder=descrição name="descricao">
        </div>

        <div class="col form-custom">
            <div>
                <button class="button"> Enviar </button>
                <button class="button" type="submit" name="limpar" value="1">Limpar Lista</button>
            </div>
</form>
            <br>
             <br>
            
            
    </form>

    <?php
    if (!empty($tabelaHtml)) {
        echo $tabelaHtml;
    }
    ?>

</body>

</html>