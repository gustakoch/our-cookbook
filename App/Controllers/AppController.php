<?php

namespace App\Controllers;

use Resources\Classes\Bcrypt;
use Resources\Classes\Logs;
use Resources\Controller\Action;
use Resources\Model\Container;

class AppController extends Action {
    public function autenticaUsuario() {
        session_start();

        if ($_SESSION['id'] == '' || $_SESSION['nome'] == '') {
            header('Location: /?error');
        }
    }

    public function permissaoDeAdmin() {
        if ($_SESSION['permissao'] != 'admin') {
            header('Location: /admin');
        }
    }

    public function admin() {
        $this->autenticaUsuario();

        $receita = Container::getModel('Receita');
        $this->dados->receitas = $receita->cincoUltimasReceitasCadastradas();

        $this->render('admin', 'Layout');
    }

    public function receitas() {
        $this->autenticaUsuario();

        $receita = Container::getModel('Receita');
        $receita->__set('id_usuario', $_SESSION['id']);

        $this->dados->receitas = $receita->todasAsReceitas();

        $this->render('receitas', 'Layout');
    }

    public function novaReceita() {
        $this->autenticaUsuario();

        $ingrediente = Container::getModel('Ingrediente');
        $this->dados->ingredientes = $ingrediente->todosOsIngredientes();

        $this->render('novareceita', 'Layout');
    }

    public function ingredientes() {
        $this->autenticaUsuario();

        $ingrediente = Container::getModel('Ingrediente');
        $this->dados->ingredientes = $ingrediente->todosOsIngredientes();

        $this->render('ingredientes', 'Layout');
    }

    public function usuarios() {
        $this->autenticaUsuario();
        $this->permissaoDeAdmin();

        $usuario = Container::getModel('Usuario');
        $this->dados->usuarios = $usuario->todosOsUsuarios();

        $this->render('usuarios', 'Layout');
    }

    public function busca() {
        $this->autenticaUsuario();

        $this->render('busca', 'Layout');
    }

    public function adminSenhas() {
        $this->autenticaUsuario();
        $this->permissaoDeAdmin();

        $usuario = Container::getModel('Usuario');

        $this->dados->usuarios = $usuario->todosOsUsuarios();

        $this->render('admin_senhas', 'Layout');
    }

    public function receitasFavoritas() {
        $this->autenticaUsuario();

        $receita = Container::getModel('Receita');
        $receita->__set('id_usuario', $_SESSION['id']);

        $this->dados->receitas = $receita->favoritosPorUsuario();

        $this->render('receitas_favoritas', 'Layout');
    }

    public function mensagens() {
        $this->autenticaUsuario();
        $this->permissaoDeAdmin();

        $mensagem = Container::getModel('Mensagem');
        $this->dados->todas_mensagens = $mensagem->todasAsMensagens();
        $this->dados->mensagens = array(
            'nao_lidas' => $mensagem->mensagensNaoLidas(),
            'lidas' => $mensagem->mensagensLidas()
        );

        $this->render('mensagens', 'Layout');
    }

    public function mensagem() {
        $this->autenticaUsuario();
        $this->permissaoDeAdmin();

        if (!isset($_GET['id']) || $_GET['id'] == "") {
            header('Location: /mensagens');
        }

        $mensagem = Container::getModel('Mensagem');
        $mensagem->__set('id', $_GET['id']);

        $this->dados->mensagem = $mensagem->getMensagemById();

        $status_lido = $mensagem->verificaStatusMensagem();

        if ($status_lido == 0) {
            $mensagem->atualizaStatusLido();
        }

        $this->render('mensagem', 'Layout');
    }

    public function updateStatusUsuario() {
        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_POST['id']);
        $usuario->__set('status', $_POST['status']);

        if ($usuario->updateStatesAtivado()) {
            return true;
        } else {
            return false;
        }
    }

    public function novoIngrediente() {
        session_start();

        $ingrediente = Container::getModel('Ingrediente');

        $ingrediente->__set('id_usuario', $_SESSION['id']);
        $ingrediente->__set('ingrediente', ucfirst(mb_strtolower($_POST['ingrediente'])));

        if (!$ingrediente->validacaoDeCampos()) {
            Logs::register($_SESSION['nome'], 'error', 'Não passou da validação de campos!');

            header('Location: /ingredientes?error');
        } else {
            $ingrediente->cadastrarIngrediente();
            Logs::register($_SESSION['nome'], 'success', 'Novo ingrediente cadastrado!');

            header('Location: /ingredientes?ok');
        }
    }

    // EM DESUSO NO MOMENTO
    public function removerImagensTemp() {
        $pasta = "/var/www/html/uploads/temp/";

        if (is_dir($pasta)) {
            $diretorio = dir($pasta);

            while ($arquivo = $diretorio->read()) {
                if (($arquivo != '.') && ($arquivo != '..')) {
                    unlink($pasta.$arquivo);
                }
            }

            $diretorio->close();
        }
    }

    public function nomeImagemUpload($imagem, $temp = false) {
        $extensao = strtolower(end(explode('.', $imagem)));

        if (!$temp) {
            $nome_imagem = "img-receita-" . time() . ".".$extensao."";
        } else {
            $nome_imagem = "img-receita-temp-" . time() . "." . $extensao . "";
        }

        return $nome_imagem;
    }

    public function uploadImagemTemp() {
        $dir = __DIR__ . "../../../uploads/temp/";
        return move_uploaded_file($_FILES['imagem']['tmp_name'], $dir . $this->nomeImagemUpload($_FILES['imagem']['name'], true));
    }

    public function uploadImagem() {
        $dir = __DIR__ . "../../../uploads/";
        return move_uploaded_file($_FILES['imagem']['tmp_name'], $dir . $this->nomeImagemUpload($_FILES['imagem']['name']));
    }

    public function cadastroNovaReceita() {
        session_start();

        $receita = Container::getModel('Receita');
        $validacao = $receita->validarCadastroDeReceitas();

        if ($validacao['ok']) {
            $descricao = substr($_POST['descricao'], 0, 120);
            $nome_imagem = $this->nomeImagemUpload($_FILES['imagem']['name']);
            $string_ingredientes = implode(',', $_POST['ingredientes']);

            $receita->__set('id_usuario', $_SESSION['id']);
            $receita->__set('nome_receita', $_POST['nome_receita']);
            $receita->__set('descricao', $descricao);
            $receita->__set('nome_imagem', $nome_imagem);
            $receita->__set('ingredientes', $string_ingredientes);
            $receita->__set('modo_de_fazer', $_POST['modo_de_fazer']);
            $receita->__set('qtde_porcoes', $_POST['qtde_porcoes']);
            $receita->__set('tempo_preparo', $_POST['tempo_preparo']);

            $this->uploadImagem();
            $receita->salvarReceita();
            Logs::register($_SESSION['nome'], 'success', 'Nova receita cadastrada!');

            header('Location: /novareceita?ok');
        } else {
            $ingrediente = Container::getModel('Ingrediente');
            $this->dados->ingredientes = $ingrediente->todosOsIngredientes();

            $ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : array();

            $this->dados->dados_receita = array(
                'msg' => $validacao['msg'],
                'nome_receita' => $_POST['nome_receita'],
                'descricao' => substr($_POST['descricao'], 0, 120),
                'ingredientes' => $ingredientes,
                'modo_de_fazer' => $_POST['modo_de_fazer']
            );
            Logs::register($_SESSION['nome'], 'error', $validacao['msg']);

            $this->render('novareceita', 'Layout');
        }
    }

    public function buscarReceitaPorId() {
        $receita = Container::getModel('Receita');
        $ingrediente = Container::getModel('Ingrediente');

        $receita->__set('id', $_POST['id']);

        $dados = $receita->getReceitaPorId();

        echo json_encode(array(
            "dados_receita" => $dados,
            'todos_ingredientes' => $ingrediente->todosOsIngredientes()
        ));
    }

    public function resultadosDaBusca() {
        session_start();

        $receita = Container::getModel('Receita');
        $receita->__set('busca', $_GET['busca']);
        $receita->__set('id_usuario', $_SESSION['id']);

        $this->dados->resultados = $receita->buscaReceitas();
        $this->render('busca', 'Layout');
    }

    public function favoritos() {
        session_start();
        error_reporting(~E_NOTICE);

        $receita = Container::getModel('Receita');
        $receita->__set('id', $_POST['id_receita']);
        $receita->__set('id_usuario', $_SESSION['id']);

        $favorito = $receita->atualizarFavorito();

        echo json_encode(array('favorito' => $favorito));
    }

    public function alterarSenhaUsuario() {
        session_start();

        error_reporting(~E_NOTICE);
        $usuario = Container::getModel('Usuario');

        $usuario->__set('id', $_POST['id_usuario']);
        $usuario->__set('senha', Bcrypt::hash($_POST['nova_senha']));
        $usuario->__set('confirmar_senha', $_POST['confirmar_senha']);

        $validacao = $usuario->validarTrocaDeSenhaAdmin();

        if ($validacao['ok']) {
            $usuario->alterarSenhaUsuario();
            $this->dados->usuarios = $usuario->todosOsUsuarios();
            $this->dados->msg = "Senha alterada com sucesso!";

            Logs::register($_SESSION['nome'], 'success', 'Alterou a senha do usuário de id ' . $_POST['id_usuario']);

            sleep(1);
            $this->render('admin_senhas', 'Layout');
        } else {
            $this->dados->usuarios = $usuario->todosOsUsuarios();
            $this->dados->validacao = array(
                'id' => $_POST['id_usuario'],
                'msg' => $validacao['msg'],
                'nova_senha' => $_POST['nova_senha']
            );
            Logs::register($_SESSION['nome'], 'error', 'Erro ao alterar senha do usuário de id '.$_POST['id_usuario'].'. Erro: ' . $validacao['msg']);

            $this->render('admin_senhas', 'Layout');
        }
    }

    public function excluir() {
        $id_receita = preg_replace("/[^0-9]/", "", $_GET['id']);
        session_start();

        $receita = Container::getModel('Receita');
        $receita->__set('id', $id_receita);
        $receita->__set('id_usuario', $_SESSION['id']);

        $remocao = $receita->removerReceita();
        if ($remocao) {
            $receita->removerFavorito();
            echo json_encode(array(
                'title' => 'Removida!',
                'msg' => 'Sua receita foi removida com sucesso.'
            ));
        }
    }

    public function alterar() {
        $id_receita = preg_replace("/[^0-9]/", "", $_GET['id']);
        session_start();

        $receita = Container::getModel('Receita');
        $receita->__set('id', $id_receita);
        $receita->__set('id_usuario', $_SESSION['id']);

        $cadastrou_receita = $receita->usuarioCadastrouReceita();

        if ($cadastrou_receita) {
            $ingrediente = Container::getModel('Ingrediente');
            $this->dados->ingredientes = $ingrediente->todosOsIngredientes();
            $this->dados->receita = $receita->procurarReceitaPorId();

            $this->render('editar_receita', 'Layout');
        } else {
            // Fazer alguma coisa quando o usuário não é quem cadastrou a receita.
        }
    }

    public function atualizarReceita() {
        $receita = Container::getModel('Receita');
        session_start();

        $id_receita = preg_replace("/[^0-9]/", "", $_POST['id']);

        $descricao = substr($_POST['descricao'], 0, 120);
        $string_ingredientes = implode(',', $_POST['ingredientes']);

        $receita->__set('id', $id_receita);
        $receita->__set('nome_receita', $_POST['nome_receita']);
        $receita->__set('descricao', $descricao);
        $receita->__set('ingredientes', $string_ingredientes);
        $receita->__set('modo_de_fazer', $_POST['modo_de_fazer']);
        $receita->__set('qtde_porcoes', $_POST['qtde_porcoes']);
        $receita->__set('tempo_preparo', $_POST['tempo_preparo']);

        $validacao = $receita->validarAtualizacaoReceita();

        if (strlen($_FILES['imagem']['name']) > 0) {
            $nome_imagem = $this->nomeImagemUpload($_FILES['imagem']['name']);
            $receita->__set('nome_imagem', $nome_imagem);
            $this->uploadImagem();
        } else {
            $nome_imagem = $receita->getStringImagem();
            $receita->__set('nome_imagem', $nome_imagem);
        }

        if ($validacao['ok']) {
            $receita->atualizarReceita();
            $this->dados->msg = "Receita atualizada com sucesso!";
            $this->dados->receitas = $receita->todasAsReceitas();

            $this->render('receitas', 'Layout');
        } else {
            error_reporting(~E_WARNING);

            $ingrediente = Container::getModel('Ingrediente');
            $this->dados->ingredientes = $ingrediente->todosOsIngredientes();

            $ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : [];

            $receita = Container::getModel('Receita');

            $descricao = substr($_POST['descricao'], 0, 120);
            $string_ingredientes = implode(',', $_POST['ingredientes']);

            $receita->__set('nome_receita', $_POST['nome_receita']);
            $receita->__set('descricao', $descricao);
            $receita->__set('ingredientes', $string_ingredientes);
            $receita->__set('modo_de_fazer', $_POST['modo_de_fazer']);
            $receita->__set('qtde_porcoes', $_POST['qtde_porcoes']);
            $receita->__set('tempo_preparo', $_POST['tempo_preparo']);

            $this->dados->receita = array(
                'msg' => $validacao['msg'],
                'id' => $_POST['id'],
                'nome_receita' => $_POST['nome_receita'],
                'descricao' => substr($_POST['descricao'], 0, 120),
                'ingredientes' => $ingredientes,
                'modo_de_fazer' => $_POST['modo_de_fazer'],
                'qtde_porcoes' => $_POST['qtde_porcoes'],
                'tempo_preparo' => $_POST['tempo_preparo']
            );

            $this->render('editar_receita', 'Layout');
        }

    }

}
