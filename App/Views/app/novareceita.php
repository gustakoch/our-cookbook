<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">

        <div class="nova-receita" style="max-width:500px;">
            <h4>Cadastrar nova receita</h4>

            <?php if (isset($this->dados->dados_receita)) { ?>
                <small class="animated bounce text-danger" style="margin-bottom:3px;">* Erro: <?= $this->dados->dados_receita['msg'] ?></small>
            <?php } ?>
            <?php if (isset($_GET['ok'])) { ?>
                <small class="animated bounce text-success" style="margin-bottom:3px;">Receita cadastrada com sucesso!</small>
            <?php } ?>

            <form action="/cadastronovareceita" method="post" enctype="multipart/form-data">
                <label><strong>Imagem:</strong></label>
                <div class="box-image">
                    <img class="preview-img" src="../../../assets/images/cam.png" height="40" width="40">
                </div>

                <label id="img-label" for="imagem">Clique aqui para selecionar a imagem</label>
                <input class="file-chooser" id="imagem" name="imagem" type="file" accept="image/*" hidden>

                <label for="nome_receita"><strong>Nome da receita:</strong></label>
                <input class="form-inputs" type="text" value="<?php if (isset($this->dados->dados_receita['nome_receita'])){ echo $this->dados->dados_receita['nome_receita']; } ?>" name="nome_receita" id="nome_receita" placeholder="Digite o nome da receita">

                <label for="descricao" style="margin-top:10px;"><strong>Descrição da receita:</strong></label>
                <textarea class="form-inputs" name="descricao" id="descricao" rows="3" placeholder="Breve descrição da receita" maxlength="120"><?php if (isset($this->dados->dados_receita['nome_receita'])){ echo $this->dados->dados_receita['descricao']; } ?></textarea>

                <label for="ingredientes" style="margin-top:10px;"><strong>Check In de ingredientes:</strong></label>
                <ul class="lista-ingredientes">

                    <?php foreach ($this->dados->ingredientes as $ingrediente) { ?>
                        <?php $this->dados->dados_receita['ingredientes'] = isset($this->dados->dados_receita['ingredientes']) ? $this->dados->dados_receita['ingredientes'] : []; ?>
                        <?php if (in_array($ingrediente['id'], $this->dados->dados_receita['ingredientes'])) { ?>
                            <li>
                                <input type="checkbox" checked name="ingredientes[<?= $ingrediente['id'] - 1 ?>]" id="<?= $ingrediente['id'] ?>" value="<?= $ingrediente['id'] ?>">
                                <label for="<?= $ingrediente['id'] ?>"><?= $ingrediente['ingrediente'] ?></label>
                            </li>
                        <?php } else { ?>
                            <li>
                                <input type="checkbox" name="ingredientes[<?= $ingrediente['id'] - 1 ?>]" id="<?= $ingrediente['id'] ?>" value="<?= $ingrediente['id'] ?>">
                                <label for="<?= $ingrediente['id'] ?>"><?= $ingrediente['ingrediente'] ?></label>
                            </li>
                        <?php } ?>
                    <?php } ?>

                </ul>
                <label for="mododefazer"><strong>Modo de fazer:</strong></label>
                <textarea class="form-inputs" name="modo_de_fazer" id="modo_de_fazer" rows="12" placeholder="Descreva aqui o modo de fazer"><?php if (isset($this->dados->dados_receita['nome_receita'])){ echo $this->dados->dados_receita['modo_de_fazer']; } ?></textarea>

                <div class="porcoes-tempo">
                    <div class="porcoes">
                        <img src="../../../assets/images/icon-porcoes.png" width="60">
                        <div class="text-input-porcoes">
                            <label for="qtde_porcoes">Qtde. de porções:</label>
                            <input class="form-inputs" type="text" name="qtde_porcoes" id="qtde_porcoes" placeholder="Informe a quantidade" onfocus="(this.type='number')">
                        </div>
                    </div>

                    <div class="porcoes">
                        <img src="../../../assets/images/icon-timer.png" width="60">
                        <div class="text-input-porcoes">
                            <label for="tempo_preparo">Tempo de preparo:</label>
                            <input class="form-inputs" type="text" name="tempo_preparo" id="tempo_preparo" placeholder="Informe em minutos" onfocus="(this.type='number')">
                        </div>
                    </div>
                </div>

                <button class="btn-custom load-button" id="salvar" type="submit">
                    <span class="spinner-border-sm"></span>
                    <span class="loading">Salvar &raquo;</span>
                </button>
            </form>
        </div>

    </div>
</section>
