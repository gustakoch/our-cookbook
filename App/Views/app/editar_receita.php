<?php
    $ingredientesReceita = explode('-', $this->dados->receita['ingredientes']);
    $qtdeUnidades = explode('-', $this->dados->receita['quantidade_unidade']);
?>

<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">

        <div class="nova-receita" style="max-width:500px;">
            <h4>Editando receita "<?= $this->dados->receita['nome_receita']; ?>"</h4>

            <form id="form-atualizar-receita">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

                <label><strong>Imagem:</strong></label>
                <div class="box-image">

                    <?php if (!$this->dados->receita['nome_imagem']) { ?>
                        <img class="preview-img" src="../../../assets/images/sem-imagem.jpeg" height="248" width="500">
                    <?php } else { ?>
                        <img class="preview-img" src="../../../uploads/<?php echo $this->dados->receita['nome_imagem']; ?>" height="250" width="500">
                    <?php } ?>

                </div>

                <label id="img-label" for="imagem">Clique aqui para alterar a imagem</label>
                <input class="file-chooser" id="imagem" name="imagem" type="file" accept="image/*" hidden>

                <label for="nome_receita"><strong>Nome da receita:</strong></label>
                <input class="form-inputs" type="text" value="<?php echo $this->dados->receita['nome_receita']; ?>" name="nome_receita" id="nome_receita" placeholder="Digite o nome da receita">

                <label for="descricao" style="margin-top:10px;"><strong>Descrição da receita:</strong></label>
                <textarea class="form-inputs" name="descricao" id="descricao" rows="3" placeholder="Breve descrição da receita" maxlength="120"><?php echo $this->dados->receita['descricao']; ?></textarea>

                <label for="ingredientes" style="margin-top:10px;"><strong>Check In de ingredientes:</strong></label>
                <ul class="lista-ingredientes">

                    <?php foreach ($this->dados->ingredientes as $i => $ingrediente) { ?>
                        <?php if (in_array($ingrediente['id'], $ingredientesReceita)) { ?>
                            <li>
                                <?php for ($i = 0; $i < count($qtdeUnidades); $i++) { ?>
                                    <?php if ($ingredientesReceita[$i] == $ingrediente['id']) { ?>
                                        <input class="item-lista-ingredientes" type="checkbox" checked name="ingredientes[<?= $ingrediente['id'] - 1 ?>]" id="<?= $ingrediente['id'] ?>" value="<?= $ingrediente['id'] ?>">
                                        <label for="<?= $ingrediente['id'] ?>"><?= $ingrediente['ingrediente'] ?></label>
                                        <div id="div<?= $ingrediente['id'] ?>" class="custom-ingredientes fixed-div">
                                            <input type="text" name="quantidade[<?= $ingrediente['id'] - 1 ?>]" class="form-inputs" value="<?= $qtdeUnidades[$i]; ?>" placeholder="Informe a quantidade e unidade de medida">
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </li>
                        <?php } else { ?>
                            <li>
                                <input class="item-lista-ingredientes" type="checkbox" name="ingredientes[<?= $ingrediente['id'] - 1 ?>]" id="<?= $ingrediente['id'] ?>" value="<?= $ingrediente['id'] ?>">
                                <label for="<?= $ingrediente['id'] ?>"><?= $ingrediente['ingrediente'] ?></label>
                            </li>
                        <?php } ?>
                    <?php } ?>

                </ul>
                <label for="mododefazer"><strong>Modo de fazer:</strong></label>
                <textarea class="form-inputs" name="modo_de_fazer" id="modo_de_fazer" rows="12" placeholder="Descreva aqui o modo de fazer"><?php echo $this->dados->receita['modo_de_fazer']; ?></textarea>

                <div class="porcoes-tempo">
                    <div class="porcoes">
                        <img class="img-timer-porcoes" src="../../../assets/images/icon-porcoes.png">
                        <div class="text-input-porcoes">
                            <label for="qtde_porcoes">Qtde. de porções:</label>
                            <input class="form-inputs" type="text" name="qtde_porcoes" id="qtde_porcoes" placeholder="Informe a quantidade" onfocus="(this.type='number')" value="<?php echo $this->dados->receita['qtde_porcoes']; ?>">
                        </div>
                    </div>

                    <div class="porcoes">
                        <img class="img-timer-porcoes" src="../../../assets/images/icon-timer.png">
                        <div class="text-input-porcoes">
                            <label for="tempo_preparo">Tempo de preparo:</label>
                            <input class="form-inputs" type="text" name="tempo_preparo" id="tempo_preparo" placeholder="Informe em minutos" onfocus="(this.type='number')" value="<?php echo $this->dados->receita['tempo_preparo']; ?>">
                        </div>
                    </div>
                </div>

                <button class="btn-custom" id="atualizar-receita" type="submit">
                    <span class="spinner-border-sm"></span>
                    <span class="loading">Atualizar receita &raquo;</span>
                </button>
            </form>
        </div>

    </div>
</section>
