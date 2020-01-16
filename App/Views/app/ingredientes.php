<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita" style="max-width:500px;">
            <h4>Ingredientes cadastrados</h4>

            <?php if (count($this->dados->ingredientes) > 0) { ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center;">#</th>
                            <th scope="col">Nome do ingrediente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->dados->ingredientes as $ingrediente) { ?>
                            <tr>
                                <td style="text-align: center;"><?= $ingrediente['id']; ?></td>
                                <td><?= $ingrediente['ingrediente']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <span><em>Não há registros de ingredientes. </em> <i class="fas fa-frown text-danger"></i></span>
            <?php } ?>

            <a href="/cadastros/novoingrediente" class="btn-custom btn-ingrediente">Cadastrar novo ingrediente &raquo;</a>
        </div>
    </div>
</section>
