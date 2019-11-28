<?php

namespace App\Controllers;

use Resources\Classes\Bcrypt;
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
        session_start();

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

        $usuario = Container::getModel('Usuario');

        $this->dados->usuarios = $usuario->todosOsUsuarios();

        error_reporting(~E_NOTICE);
        $this->render('admin_senhas', 'Layout');
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
            header('Location: /ingredientes?error');
        } else {
            $ingrediente->cadastrarIngrediente();
            header('Location: /ingredientes?ok');
        }
    }

    public function nomeImagem() {
        $pasta = "/var/www/html/uploads/temp/";

        $fotos = glob($pasta . "{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG}", GLOB_BRACE);

        // Pegar o data da modificação de cada foto
        $datas_mod = array();
        foreach ($fotos as $i => $foto) {
            $datas_mod[$i] = filemtime($foto);
        }

        arsort($datas_mod);

        $uf = key($datas_mod);

        $ultima_foto = $fotos[$uf];

        return $ultima_foto;
    }

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

            $this->uploadImagem();
            $receita->salvarReceita();

            header('Location: /novareceita?ok');
        } else {
            $ingrediente = Container::getModel('Ingrediente');
            $this->dados->ingredientes = $ingrediente->todosOsIngredientes();

            $this->dados->dados_receita = array(
                'msg' => $validacao['msg'],
                'nome_receita' => $_POST['nome_receita'],
                'descricao' => substr($_POST['descricao'], 0, 120),
                'ingredientes' => $_POST['ingredientes'],
                'modo_de_fazer' => $_POST['modo_de_fazer']
            );
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

            sleep(2);
            $this->render('admin_senhas', 'Layout');
        } else {
            $this->dados->usuarios = $usuario->todosOsUsuarios();
            $this->dados->validacao = array(
                'id' => $_POST['id_usuario'],
                'msg' => $validacao['msg'],
                'nova_senha' => $_POST['nova_senha']
            );

            $this->render('admin_senhas', 'Layout');
        }
    }
}
