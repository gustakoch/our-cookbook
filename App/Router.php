<?php

namespace App;

use Resources\Init\Bootstrap;

class Router extends Bootstrap {
    protected function initRoutes() {
        $routes['home'] = array(
            'route' => '/',
            'controller' => 'IndexController',
            'action' => 'index'
        );
        $routes['criarconta'] = array(
            'route' => '/criarconta',
            'controller' => 'IndexController',
            'action' => 'pageCriarConta'
        );
        $routes['criarnovaconta'] = array(
            'route' => '/criarnovaconta',
            'controller' => 'IndexController',
            'action' => 'criarNovaConta'
        );
        $routes['recuperacao'] = array(
            'route' => '/recuperacao',
            'controller' => 'IndexController',
            'action' => 'recuperacao'
        );
        $routes['recuperarsenha'] = array(
            'route' => '/recuperarsenha',
            'controller' => 'IndexController',
            'action' => 'recuperarSenha'
        );
        $routes['alteracaosenha'] = array(
            'route' => '/alteracaosenha',
            'controller' => 'IndexController',
            'action' => 'alteracaoSenha'
        );
        $routes['cadastrarnovasenha'] = array(
            'route' => '/cadastrarnovasenha',
            'controller' => 'IndexController',
            'action' => 'cadastrarNovaSenha'
        );
        $routes['sair'] = array(
            'route' => '/sair',
            'controller' => 'AuthController',
            'action' => 'sair'
        );
        $routes['login'] = array(
            'route' => '/login',
            'controller' => 'AuthController',
            'action' => 'login'
        );
        $routes['admin'] = array(
            'route' => '/admin',
            'controller' => 'AppController',
            'action' => 'admin'
        );
        $routes['novareceita'] = array(
            'route' => '/novareceita',
            'controller' => 'AppController',
            'action' => 'novaReceita'
        );
        $routes['cadastronovareceita'] = array(
            'route' => '/cadastronovareceita',
            'controller' => 'AppController',
            'action' => 'cadastroNovaReceita'
        );
        $routes['ingredientes'] = array(
            'route' => '/ingredientes',
            'controller' => 'AppController',
            'action' => 'ingredientes'
        );
        $routes['novoingrediente'] = array(
            'route' => '/novoingrediente',
            'controller' => 'AppController',
            'action' => 'novoIngrediente'
        );
        $routes['usuarios'] = array(
            'route' => '/usuarios',
            'controller' => 'AppController',
            'action' => 'usuarios'
        );
        $routes['update_status_usuario'] = array(
            'route' => '/update_status_usuario',
            'controller' => 'AppController',
            'action' => 'updateStatusUsuario'
        );
        $routes['buscarreceitaporid'] = array(
            'route' => '/buscarreceitaporid',
            'controller' => 'AppController',
            'action' => 'buscarReceitaPorId'
        );
        $routes['receitas'] = array(
            'route' => '/receitas',
            'controller' => 'AppController',
            'action' => 'receitas'
        );
        $routes['resultados'] = array(
            'route' => '/resultados',
            'controller' => 'AppController',
            'action' => 'resultadosDaBusca'
        );
        $routes['busca'] = array(
            'route' => '/busca',
            'controller' => 'AppController',
            'action' => 'busca'
        );
        $routes['favoritos'] = array(
            'route' => '/favoritos',
            'controller' => 'AppController',
            'action' => 'favoritos'
        );
        $routes['adminsenhas'] = array(
            'route' => '/adminsenhas',
            'controller' => 'AppController',
            'action' => 'adminSenhas'
        );
        $routes['alterarsenhausuario'] = array(
            'route' => '/alterarsenhausuario',
            'controller' => 'AppController',
            'action' => 'alterarSenhaUsuario'
        );
        $routes['receitasfavoritas'] = array(
            'route' => '/receitasfavoritas',
            'controller' => 'AppController',
            'action' => 'receitasFavoritas'
        );
        $routes['contato'] = array(
            'route' => '/contato',
            'controller' => 'IndexController',
            'action' => 'contato'
        );
        $routes['novamensagem'] = array(
            'route' => '/novamensagem',
            'controller' => 'IndexController',
            'action' => 'novaMensagem'
        );
        $routes['mensagens'] = array(
            'route' => '/mensagens',
            'controller' => 'AppController',
            'action' => 'mensagens'
        );
        $routes['mensagem'] = array(
            'route' => '/mensagem',
            'controller' => 'AppController',
            'action' => 'mensagem'
        );
        $routes['excluir'] = array(
            'route' => '/excluir',
            'controller' => 'AppController',
            'action' => 'excluir'
        );
        $routes['alterar'] = array(
            'route' => '/alterar',
            'controller' => 'AppController',
            'action' => 'alterar'
        );
        $routes['atualizarreceita'] = array(
            'route' => '/atualizarreceita',
            'controller' => 'AppController',
            'action' => 'atualizarReceita'
        );
        $routes['cadastros/novoingrediente'] = array(
            'route' => '/cadastros/novoingrediente',
            'controller' => 'AppController',
            'action' => 'cadastroNovoIngrediente'
        );

        $this->setRoutes($routes);
    }
}
