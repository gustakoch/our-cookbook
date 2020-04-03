<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita" style="max-width:500px;">
            <h4>Ingredientes cadastrados</h4>

            <?php if (count($this->dados->ingredientes) > 0) { ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Nome do ingrediente</th>
                            <th scope="col" style="text-align: center; width: 94px;">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->dados->ingredientes as $ingrediente) { ?>
                            <tr>
                                <?php if ($ingrediente['ativo'] == 1) { ?>
                                    <td id="ingrediente<?= $ingrediente['id']; ?>"><?= $ingrediente['ingrediente']; ?></td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button class="btn-edicao-ingrediente" id="<?= $ingrediente['id']; ?>" title="Editar ingrediente">
                                            <i class="fas fa-edit text-success"></i>
                                        </button>
                                        <a class="btn-inativar-ingrediente" id="<?= $ingrediente['id']; ?>" title="Inativar ingrediente" style="cursor: pointer;">
                                            <i class="fas fa-power-off text-warning"></i>
                                        </a>
                                    </td>
                                <?php } else { ?>
                                    <td id="ingrediente<?= $ingrediente['id']; ?>">
                                        <del style="color: #ddd"><?= $ingrediente['ingrediente']; ?></del>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button style="cursor: not-allowed; border: 0; background: none">
                                            <i class="fas fa-edit text-gray"></i>
                                        </button>
                                        <a style="cursor: not-allowed">
                                            <i class="fas fa-power-off text-gray"></i>
                                        </a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <span><em>Não há registros de ingredientes. </em> <i class="fas fa-frown text-danger"></i></span>
            <?php } ?>

            <hr>

            <div class="nova-receita" style="max-width:500px;">
                <h4>Cadastro rápido</h4>
                <form>
                    <input class="form-inputs" type="text" name="ingrediente" id="ingrediente" placeholder="Nome do ingrediente" autocomplete="off" value="<?php if ($this->dados->ingrediente) { echo $this->dados->ingrediente; } ?>">
                    <button class="btn-custom" id="adicionar-ingrediente" type="submit">
                        <span class="spinner-border-sm"></span>
                        <span class="loading">Adicionar ingrediente &raquo;</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>
