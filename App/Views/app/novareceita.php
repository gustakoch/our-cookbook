<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">

        <div class="nova-receita" style="max-width:500px;">
            <h4>Cadastrar nova receita</h4>

            <form id="form-nova-receita">
                <label><strong>Imagem:</strong></label>
                <div class="box-image">
                    <img class="preview-img" src="../../../assets/images/cam.png" height="40" width="40">
                </div>

                <label id="img-label" for="imagem">Clique aqui para selecionar a imagem</label>
                <input class="file-chooser" id="imagem" name="imagem" type="file" accept="image/*" hidden>

                <label for="nome_receita"><strong>Nome da receita:</strong></label>
                <input class="form-inputs" type="text" name="nome_receita" id="nome_receita" placeholder="Digite o nome da receita" autocomplete="off">

                <label for="descricao" style="margin-top:10px;"><strong>Descrição da receita:</strong></label>
                <textarea class="form-inputs" name="descricao" id="descricao" rows="3" placeholder="Breve descrição da receita" maxlength="120"></textarea>

                <label for="ingredientes" style="margin-top:10px;"><strong>Selecione os ingredientes:</strong></label>
                <ul class="lista-ingredientes">

                    <?php if (count($this->dados->ingredientes) > 0) { ?>
                        <?php foreach ($this->dados->ingredientes as $ingrediente) { ?>
                            <li id="lista-<?= $ingrediente['id']; ?>">
                                <input class="item-lista-ingredientes" type="checkbox" name="ingredientes[<?= $ingrediente['id'] - 1 ?>]" id="<?= $ingrediente['id'] ?>" value="<?= $ingrediente['id'] ?>">
                                <label for="<?= $ingrediente['id'] ?>"><?= $ingrediente['ingrediente'] ?></label>
                            </li>
                        <?php } ?>
                    <?php } else { ?>
                        <small style="font-weight: bold;color:#f44;margin-left:-7px;">Você não possui ingredientes cadastrados!</small>
                    <?php } ?>

                </ul>
                <label for="mododefazer"><strong>Modo de fazer:</strong></label>
                <textarea class="form-inputs" name="modo_de_fazer" id="modo_de_fazer" rows="12" placeholder="Descreva aqui o modo de fazer"><?php if (isset($this->dados->dados_receita['nome_receita'])){ echo $this->dados->dados_receita['modo_de_fazer']; } ?></textarea>

                <div class="porcoes-tempo">
                    <div class="porcoes">
                        <img src="../../../assets/images/icon-porcoes.png" width="60">
                        <div class="text-input-porcoes">
                            <label for="qtde_porcoes">Qtde. de porções:</label>
                            <input class="form-inputs" type="text" name="qtde_porcoes" id="qtde_porcoes" placeholder="Informe a quantidade" onfocus="(this.type='number')" autocomplete="off">
                        </div>
                    </div>

                    <div class="porcoes">
                        <img src="../../../assets/images/icon-timer.png" width="60">
                        <div class="text-input-porcoes">
                            <label for="tempo_preparo">Tempo de preparo:</label>
                            <input class="form-inputs" type="text" name="tempo_preparo" id="tempo_preparo" placeholder="Informe em minutos" onfocus="(this.type='number')" autocomplete="off">
                        </div>
                    </div>
                </div>

                <button class="btn-custom" id="salvar-receita" type="submit">
                    <span class="spinner-border-sm"></span>
                    <span class="loading">Salvar &raquo;</span>
                </button>
            </form>
        </div>

    </div>
</section>
