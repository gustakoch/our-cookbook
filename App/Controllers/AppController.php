<?php
namespace App\Controllers;

use Resources\Classes\Bcrypt;
use Resources\Classes\Logs;
use Resources\Classes\SendMail;

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
        $this->dados->ingredientes = $ingrediente->getIngredientesAtivos();
        $this->dados->unidades_medida = $ingrediente->unidadesMedidaIngredientes();

        $this->render('novareceita', 'Layout');
    }

    public function ingredientes() {
        $this->autenticaUsuario();

        $ingrediente = Container::getModel('Ingrediente');
        $todosIngredientes = $ingrediente->todosOsIngredientes();

        $pagina = isset($_GET['p']) ? (int) $_GET['p'] : 1;
        $totalIngredientes = count($todosIngredientes);
        $qtdePorPagina = 10;
        $inicio = ($qtdePorPagina * $pagina) - $qtdePorPagina;

        $this->dados->ingredientes = $ingrediente->ingredientesPorPagina($inicio, $qtdePorPagina);
        $this->dados->totalPaginas = (int) ceil($totalIngredientes / $qtdePorPagina);
        $this->dados->paginaAnterior = $pagina - 1;
        $this->dados->paginaSeguinte = $pagina + 1;
        $this->dados->pagina = $pagina;

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
        $this->autenticaUsuario();

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
        $this->autenticaUsuario();

        session_start();

        $ingrediente = Container::getModel('Ingrediente');
        $ingrediente->__set('id_usuario', $_SESSION['id']);
        $ingrediente->__set('ingrediente', mb_convert_case($_POST['ingrediente'], MB_CASE_TITLE));

        $ingredienteExiste = $ingrediente->verificaNomeIngrediente();

        if ($ingredienteExiste) {
            echo json_encode(array(
                'ok' => false,
                'title' => 'Erro ao adicionar ingrediente',
                'msg' => 'O nome informado já está cadastrado'
            ));

            return false;
        }

        if (!$ingrediente->validacaoDeCampos()) {
            Logs::register($_SESSION['nome'], 'error', 'Não passou da validação de campos!');

            echo json_encode(array(
                'ok' => false,
                'title' => 'Erro ao adicionar ingrediente',
                'msg' => 'Por favor, informe o nome do ingrediente'
            ));

            return false;
        } else {
            $ingrediente->cadastrarIngrediente();
            Logs::register($_SESSION['nome'], 'success', 'Novo ingrediente cadastrado!');

            echo json_encode(array(
                'ok' => true,
                'title' => 'Ingrediente adicionado',
                'msg' => 'Seu ingrediente foi adicionado com sucesso'
            ));

            return true;
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
        $this->autenticaUsuario();

        session_start();

        $receita = Container::getModel('Receita');
        $validacao = $receita->validarCadastroDeReceitas();

        if ($validacao['ok']) {
            $descricao = substr($_POST['descricao'], 0, 120);

            $string_ingredientes = implode('-', $_POST['ingredientes']);
            $string_quantidades = implode('-', $_POST['quantidade']);

            if (!$_FILES['imagem']['name']) {
                $nome_imagem = '';
            } else {
                $nome_imagem = $this->nomeImagemUpload($_FILES['imagem']['name']);
                $this->uploadImagem();
            }

            $receita->__set('id_usuario', $_SESSION['id']);
            $receita->__set('nome_receita', ucfirst($_POST['nome_receita']));
            $receita->__set('descricao', $descricao);
            $receita->__set('nome_imagem', $nome_imagem);
            $receita->__set('ingredientes', $string_ingredientes);
            $receita->__set('quantidade_unidade', $string_quantidades);
            $receita->__set('modo_de_fazer', $_POST['modo_de_fazer']);
            $receita->__set('qtde_porcoes', $_POST['qtde_porcoes']);
            $receita->__set('tempo_preparo', $_POST['tempo_preparo']);

            $receita->salvarReceita();

            Logs::register($_SESSION['nome'], 'success', 'Nova receita cadastrada!');

            echo json_encode(array(
                'ok' => true,
                'title' => 'Receita cadastrada!',
                'msg' => 'Parabéns! Mais uma para sua coleção'
            ));

            return true;
        } else {
            echo json_encode(array(
                'ok' => false,
                'title' => 'Erro ao salvar receita',
                'msg' => $validacao['msg']
            ));

            return false;
        }
    }

    public function buscarReceitaPorId() {
        $this->autenticaUsuario();

        $receita = Container::getModel('Receita');
        $ingrediente = Container::getModel('Ingrediente');

        $receita->__set('id', $_GET['id']);
        $dados = $receita->getReceitaPorId();

        echo json_encode(array(
            "dados_receita" => $dados,
            'todos_ingredientes' => $ingrediente->todosOsIngredientes()
        ));
    }

    public function resultadosDaBusca() {
        $this->autenticaUsuario();

        session_start();

        $receita = Container::getModel('Receita');
        $receita->__set('busca', $_GET['busca']);
        $receita->__set('id_usuario', $_SESSION['id']);

        $this->dados->resultados = $receita->buscaReceitas();
        $this->render('busca', 'Layout');
    }

    public function favoritos() {
        $this->autenticaUsuario();

        session_start();
        error_reporting(~E_NOTICE);

        $receita = Container::getModel('Receita');
        $receita->__set('id', $_POST['id_receita']);
        $receita->__set('id_usuario', $_SESSION['id']);

        $favorito = $receita->atualizarFavorito();

        echo json_encode(array('favorito' => $favorito));
    }

    public function alterarSenhaUsuario() {
        $this->autenticaUsuario();

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
        $this->autenticaUsuario();

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
        $this->autenticaUsuario();

        $id_receita = preg_replace("/[^0-9]/", "", $_GET['id']);
        session_start();

        $receita = Container::getModel('Receita');
        $receita->__set('id', $id_receita);
        $receita->__set('id_usuario', $_SESSION['id']);

        $ingrediente = Container::getModel('Ingrediente');

        $this->dados->ingredientes = $ingrediente->todosOsIngredientes();
        $this->dados->receita = $receita->procurarReceitaPorId();

        $this->render('editar_receita', 'Layout');
    }

    public function atualizarReceita() {
        $this->autenticaUsuario();

        $id_receita = preg_replace("/[^0-9]/", "", $_POST['id']);
        session_start();

        $receita = Container::getModel('Receita');

        $descricao = substr($_POST['descricao'], 0, 120);
        $stringIngredientes = implode('-', $_POST['ingredientes']);
        $stringQtdeUnidade = implode('-', $_POST['quantidade']);

        $receita->__set('id', $id_receita);
        $receita->__set('nome_receita', ucfirst($_POST['nome_receita']));
        $receita->__set('descricao', $descricao);
        $receita->__set('ingredientes', $stringIngredientes);
        $receita->__set('quantidade_unidade', $stringQtdeUnidade);
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

            echo json_encode(array(
                'ok' => true,
                'title' => 'Receita atualizada',
                'msg' => 'Sua receita foi atualizada com sucesso'
            ));

            return true;
        } else {
            echo json_encode(array(
                'ok' => false,
                'title' => 'Erro ao atualizar receita',
                'msg' => $validacao['msg']
            ));

            return false;
        }
    }

    public function excluirIngrediente() {
        $this->autenticaUsuario();

        $id_ingrediente = preg_replace("/[^0-9]/", "", $_GET['id']);

        $ingrediente = Container::getModel('Ingrediente');
        $ingrediente->__set('id', $id_ingrediente);

        $removido = $ingrediente->excluirReceiteById();

        if ($removido) {
            echo json_encode(array(
                'title' => 'Removido!',
                'msg' => 'Ingrediente removido com sucesso.'
            ));
        }
    }

    public function inativarIngrediente() {
        $this->autenticaUsuario();

        $id_ingrediente = preg_replace("/[^0-9]/", "", $_GET['id']);

        $ingrediente = Container::getModel('Ingrediente');
        $ingrediente->__set('id', $id_ingrediente);

        $inativado = $ingrediente->inativarIngredienteById();

        if ($inativado) {
            echo json_encode(array(
                'title' => 'Inativado!',
                'msg' => 'Ingrediente inativado com sucesso.'
            ));
        }
    }

    public function editarIngrediente() {
        $this->autenticaUsuario();

        $id_ingrediente = preg_replace("/[^0-9]/", "", $_POST['id']);
        $nomeImgrediente = preg_replace("/[^A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+/", "", $_POST['ingrediente']);
        $nomeImgrediente = mb_convert_case($nomeImgrediente, MB_CASE_TITLE);

        if (strlen(trim($nomeImgrediente)) <= 0) {
            echo json_encode(array(
                'ok' => false,
                'title' => 'Erro ao atualizar ingrediente!',
                'msg' => 'Por favor, informe o novo nome do ingrediente'
            ));

            return false;
        }

        $ingrediente = Container::getModel('Ingrediente');
        $ingrediente->__set('id', $id_ingrediente);
        $ingrediente->__set('ingrediente', $nomeImgrediente);

        $ingredienteExiste = $ingrediente->verificaNomeIngrediente();

        if ($ingredienteExiste) {
            echo json_encode(array(
                'ok' => false,
                'title' => 'Erro ao atualizar ingrediente!',
                'msg' => 'Nome de ingrediente já cadastrado e/ou não permitido'
            ));

            return false;
        }

        $ingredienteAtualizado = $ingrediente->editarReceiteById();

        if ($ingredienteAtualizado) {
            echo json_encode(array(
                'ok' => true,
                'nome_ingrediente' => $nomeImgrediente,
                'title' => 'Atualizado!',
                'msg' => 'Ingrediente atualizado com sucesso'
            ));

            return true;
        }
    }
}
