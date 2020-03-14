<section class="content">
    <div class="col-md-12 d-flex justify-content-center mt-3">
        <div class="nova-receita" style="max-width:500px;">
            <h4>Cadastrar novo ingrediente</h4>
            <form>
                <input class="form-inputs" type="text" name="ingrediente" id="ingrediente" placeholder="Nome do ingrediente" autocomplete="off" value="<?php if ($this->dados->ingrediente) { echo $this->dados->ingrediente; } ?>">
                <button class="btn-custom" id="adicionar-ingrediente" type="submit">
                    <span class="spinner-border-sm"></span>
                    <span class="loading">Adicionar &raquo;</span>
                </button>
            </form>
        </div>
    </div>
</section>
