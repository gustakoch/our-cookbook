$(document).ready(function() {
    $('.load-button-busca').click(function() {
        let spinner = $(this).children('.spinner-border-sm');
        let button = $(this).children('.loading');
        $(button).html('Buscando...');
        $(spinner).addClass('spinner-border');
    });

    $('.refresh-fav').click(function(e) {
        e.preventDefault();
        location.reload();
    });

    $('#telefone').mask('(00) 00009-0000');

    function loadButton() {
        $('.load-button').click(function() {
            let spinner = $(this).children('.spinner-border-sm');
            let button = $(this).children('.loading');
            $(button).html('Processando... aguarde!');
            $(spinner).addClass('spinner-border');
        });
    }

    function customizarIngredienteAoCadastrar() {
        if ($('.fixed-div').is(':checked')) {
            console.log('hello');
        }

        const id = $(this).attr('id');
        const li = $(this).parent();

        if ($(this).is(':checked')) {
            let div = $('<div>', {
                id: 'div' + id,
                class: 'custom-ingredientes'
            });
            let input = $('<input>', {
                name: `quantidade[${id -1}]`,
                type: 'text',
                class: 'form-inputs',
                placeholder: 'Informe a quantidade e unidade de medida'
            });

            $(input).appendTo(div);
            $(div).appendTo(li);
        } else {
            $('#div' + id).remove();
        }
    }
    $('li').on('change', '.item-lista-ingredientes', customizarIngredienteAoCadastrar);

    function carregarModal() {
        $('.img-receita').click(function(e) {
            e.preventDefault();
            let idReceita = $(this).attr('id');

            $.ajax({
                type: "post",
                url: "/buscarreceitaporid",
                dataType: 'json',
                data: {
                    id: idReceita
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Oops...',
                        text: 'Não foi possível recuperar as informações',
                        confirmButtonText: 'Fechar',
                        footer: 'Erro: ' + error
                    })
                    console.log(status, error);
                },
                success: function(result) {
                    const dados = result.dados_receita[0];
                    const todosIngredientes = result.todos_ingredientes;

                    $('#main-modal').modal('show');

                    const partes = dados.cadastrado_em.split(' ');
                    const data = partes[0].split('-');
                    const dataCompleta = `${data[2]}/${data[1]}/${data[0]}`;
                    const hora = partes[1].split(':');
                    const horaAbreviada = `${hora[0]}:${hora[1]}`;

                    const ingredientes = dados.ingredientes.split('-');
                    const qtde_unidade = dados.quantidade_unidade.split('-');

                    for (var i in qtde_unidade) {
                        qtde_unidade[i] = qtde_unidade[i].charAt(0).toUpperCase() + qtde_unidade[i].slice(1);
                    }

                    $('#lista-ingredientes').html('');

                    arrIngredientes = [];
                    arrUnidades = [];
                    todosIngredientes.forEach(ingrediente => {
                        if (ingredientes.includes(ingrediente.id)) {
                            arrIngredientes.push(ingrediente.ingrediente);
                        }
                    });

                    for (let i = 0; i < arrIngredientes.length; i++) {
                        li = $('<li>');
                        $(li).appendTo('#lista-ingredientes');
                        $(li).append(`<i class="fas fa-angle-right"></i> ${arrIngredientes[i]} (<small>${qtde_unidade[i]}</small>)`);
                    }

                    $('.modal-title').html(dados.nome_receita);

                    if (!dados.nome_imagem) {
                        $('#img-receita-modal').attr('src', '../../assets/images/sem-imagem.jpeg');
                    } else {
                        $('#img-receita-modal').attr('src', '../../uploads/' + dados.nome_imagem);
                    }

                    $('#publicacao-receita').html(`Publicado em ${dataCompleta} às ${horaAbreviada}`);
                    $('#criacao-receita').html(`Criado por ${dados.nome}`);

                    let modoDeFazer = dados.modo_de_fazer.split('\n').join('<br />');
                    $('#modo-de-preparo').html(modoDeFazer);

                    let porcoes = dados.qtde_porcoes > 1 ? 'porções' : 'porção';
                    $('#qtde-porcoes').html(`Rende ${dados.qtde_porcoes} ${porcoes}`);

                    $('#preparo').html(`Preparado em ${dados.tempo_preparo} minutos`);
                }
            });
        });
    }

    function alteraStatusUsuario() {
        const elements = $('.onoffelement');

        elements.map((index, element) => {
            if (element.value == '1') {
                $(element).prop('checked', true);
            } else if (element.value == '0') {
                $(element).prop('checked', false);
            }

            $('#' + element.id).change(function(e) {
                $.ajax({
                    type: "POST",
                    url: "/update_status_usuario",
                    data: {
                        id: element.id,
                        status: element.value
                    },
                    success: function(result) {
                        //
                    },
                    error: function(xhr, status, error) {
                        //
                    }
                });
            });
        });
    }

    function customizarIngredientes() {
        const checkboxes = $('.item-lista-ingredientes');
        $(checkboxes).change(function() {

        });
    }

    function favoritarReceita() {
        $('.btn-fav').click(function(e) {
            let idReceita = $(this).attr('id');
            let texto = $(this).html();
            $(this).addClass('bounceIn');

            setTimeout(() => {
                $(this).removeClass('bounceIn');
            }, 300);

            if (texto.indexOf('far') != -1) {
                $(this).html('<i class="fas fa-thumbs-up text-primary fa-lg"></i>');
            } else {
                $(this).html('<i class="far fa-thumbs-up fa-lg"></i>');
            }

            $.ajax({
                url: '/favoritos',
                type: 'post',
                dataType: 'json',
                data: {
                    id_receita: idReceita
                }
            });
        });
    }

    function geraPreviewImagem() {
        const previewImg = document.querySelector('.preview-img');
        const fileChooser = document.querySelector('.file-chooser');

        if (!fileChooser) {
            return false;
        }

        fileChooser.onchange = e => {
            const fileToUpload = e.target.files.item(0);
            const reader = new FileReader();

            reader.onload = e => previewImg.src = e.target.result;
            reader.readAsDataURL(fileToUpload);

            const imageLoaded = document.querySelector('.preview-img');
            imageLoaded.classList.add('img-loaded');
        };
    }

    function setCapsLockMessage() {
        const inputSenha = document.querySelector('#senha');
        const inputConfirmarSenha = document.querySelector('#confirmar_senha');
        const text = document.querySelector('#txtcapslock');
        const text2 = document.querySelector('#txtcapslock2');

        if (inputSenha === null || inputConfirmarSenha === null)
            return false;

        inputSenha.addEventListener('keyup', function(e) {
            if (e.getModifierState('CapsLock')) {
                text.style.display = 'block';
            } else {
                text.style.display = 'none';
            }
        });

        inputConfirmarSenha.addEventListener('keyup', function(e) {
            if (e.getModifierState('CapsLock')) {
                text2.style.display = 'block';
            } else {
                text2.style.display = 'none';
            }
        });
    }

    function showHidePasswordText() {
        $('#btn-password').click(function(e) {
            const passwordField = $('#senha');
            const passwordFieldType = passwordField.attr('type');

            if (passwordFieldType == 'password') {
                $(passwordField).attr('type', 'text');
                $(this).html('<i class="fas fa-eye-slash"></i>');
            } else {
                $(passwordField).attr('type', 'password');
                $(this).html('<i class="fas fa-eye"></i>');
            }
        });

        $('#btn-password-confirmar').click(function(e) {
            const passwordField = $('#confirmar_senha');
            const passwordFieldType = passwordField.attr('type');

            if (passwordFieldType == 'password') {
                $(passwordField).attr('type', 'text');
                $(this).html('<i class="fas fa-eye-slash"></i>');
            } else {
                $(passwordField).attr('type', 'password');
                $(this).html('<i class="fas fa-eye"></i>');
            }
        });

        $('.btn-excluir').click(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Você tem certeza disso?',
                text: "Essa ação não poderá ser desfeita.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sim, pode remover!',
            })
            .then((result) => {
                if (result.value) {
                    let idReceita = $(this).attr('id');

                    $.ajax({
                        url: '/excluir?id=' + idReceita,
                        type: 'post',
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire(response.title, response.msg, 'success');
                            $('.swal2-confirm').click(function(e) {
                                e.preventDefault();
                                window.location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Erro!', 'Não foi possível remover a receita.', 'error');
                        }
                    });
                }
            });
        });

        $('.btn-inativar-ingrediente').click(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Você tem certeza disso?',
                text: "Essa ação não poderá ser desfeita.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sim, pode inativar!',
            })
            .then((result) => {
                if (result.value) {
                    let id = $(this).attr('id');

                    $.ajax({
                        url: '/inativaringrediente?id=' + id,
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire(response.title, response.msg, 'success');
                            $('.swal2-confirm').click(function(e) {
                                e.preventDefault();
                                window.location.reload();
                            })
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Erro!', 'Não foi possível remover o ingrediente.', 'error');
                        }
                    });
                }
            });
        });

        $('.btn-edicao-ingrediente').click(function(e) {
            let id = $(this).attr('id');
            let tdIngrediente = $('#ingrediente' + id);
            let textoIngrediente = $('#ingrediente' + id).html();

            $(tdIngrediente).html('');

            $(this).attr('disabled', 'disabled');
            $(this).children('.text-success').addClass('text-gray');
            $(this).children('.text-success').removeClass('text-success');

            let form = $('<form>', {
                class: 'form-edicao-ingrediente'
            });
            let input = $('<input>', {
                type: 'text',
                name: 'ingrediente',
                class: 'form-inputs'
            });
            let inputHidden = $('<input>', {
                type: 'hidden',
                name: 'id',
                value: id
            });
            let buttonAtualizar = $('<button>', {
                type: 'submit',
                text: 'Ok',
                title: 'Atualizar ingrediente',
                class: 'btn-confirma-edicao-ingrediente'
            });
            let buttonCancelar = $('<button>', {
                type: 'button',
                text: 'Cancelar',
                title: 'Cancelar edição',
                class: 'btn-confirma-edicao-ingrediente'
            });

            $(input).val(textoIngrediente);
            $(inputHidden).appendTo(form);
            $(input).appendTo(form);
            $(buttonAtualizar).appendTo(form);
            $(buttonCancelar).appendTo(form);
            $(form).appendTo(tdIngrediente);

            $(buttonCancelar).on('click', function(e) {
                $(tdIngrediente).html(textoIngrediente);

                $('#' + id).removeAttr('disabled', 'disabled');
                $('#' + id).children('.text-gray').addClass('text-success');
                $('#' + id).children('.text-success').removeClass('text-gray');
            });

            $(buttonAtualizar).on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '/editaringrediente',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        id: id,
                        ingrediente: $("[name='ingrediente']").val()
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Erro!', 'Não foi possível editar o ingrediente.', 'error');
                    },
                    success: function(response) {
                        if (response.ok) {
                            Swal.fire(response.title, response.msg, 'success');
                            $('.swal2-confirm').click(function(e) {
                                e.preventDefault();
                                $(tdIngrediente).html(response.nome_ingrediente);

                                $('#' + id).removeAttr('disabled', 'disabled');
                                $('#' + id).children('.text-gray').addClass('text-success');
                                $('#' + id).children('.text-success').removeClass('text-gray');
                            })
                        } else {
                            Swal.fire(response.title, response.msg, 'error');
                        }
                    }
                });
            }) ;
        });

        $('#salvar-receita').click(function(e) {
            e.preventDefault();

            let spinner = $('.btn-custom').children('.spinner-border-sm');
            let button = $('.btn-custom').children('.loading');

            let form = $('#form-nova-receita')[0];
            let data = new FormData(form);

            $.ajax({
                url: '/cadastronovareceita',
                enctype: 'multipart/form-data',
                type: 'post',
                dataType: 'json',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 5000,
                beforeSend: function() {
                    $(button).html('Processando... aguarde!');
                    $(spinner).addClass('spinner-border');
                },
                complete: function() {
                    $(spinner).removeClass('spinner-border');
                    $(button).html('Salvar »');
                },
                error: function(xhr, status, error) {
                    //
                },
                success: function(response) {
                    if (response.ok) {
                        Swal.fire(response.title, response.msg, 'success');
                        $('.swal2-confirm').click(function(e) {
                            e.preventDefault();
                            window.location.reload();
                        });
                    } else {
                        Swal.fire(response.title, response.msg, 'error');
                    }
                }
            });
        });

        $('#atualizar-receita').click(function(e) {
            e.preventDefault();

            let spinner = $('.btn-custom').children('.spinner-border-sm');
            let button = $('.btn-custom').children('.loading');

            let form = $('#form-atualizar-receita')[0];
            let data = new FormData(form);

            $.ajax({
                url: '/atualizarreceita',
                enctype: 'multipart/form-data',
                type: 'post',
                dataType: 'json',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 5000,
                beforeSend: function() {
                    $(button).html('Processando... aguarde!');
                    $(spinner).addClass('spinner-border');
                },
                complete: function() {
                    $(spinner).removeClass('spinner-border');
                    $(button).html('Atualizar receita »');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                },
                success: function(response) {
                    if (response.ok) {
                        Swal.fire(response.title, response.msg, 'success');
                        $('.swal2-confirm').click(function(e) {
                            e.preventDefault();
                            window.location.href = 'http://localhost:3334/receitas';
                        });
                    } else {
                        Swal.fire(response.title, response.msg, 'error');
                    }
                }
            });
        });

        $('#adicionar-ingrediente').click(function(e) {
            e.preventDefault();

            let spinner = $('.btn-custom').children('.spinner-border-sm');
            let button = $('.btn-custom').children('.loading');

            $.ajax({
                url: '/novoingrediente',
                type: 'post',
                dataType: 'json',
                data: {
                    'ingrediente': $('#ingrediente').val()
                },
                timeout: 5000,
                beforeSend: function() {
                    $(button).html('Processando... aguarde!');
                    $(spinner).addClass('spinner-border');
                },
                complete: function() {
                    $(spinner).removeClass('spinner-border');
                    $(button).html('Adicionar »');
                },
                error: function(xhr, status, error) {
                    //
                },
                success: function(response) {
                    if (response.ok) {
                        Swal.fire(response.title, response.msg, 'success');
                        $('.swal2-confirm').click(function(e) {
                            e.preventDefault();
                            window.location.href = 'http://localhost:3334/ingredientes';
                        });
                    } else {
                        Swal.fire(response.title, response.msg, 'error');
                    }
                }
            });
        });

    }

    loadButton();
    customizarIngredientes();
    alteraStatusUsuario();
    geraPreviewImagem();
    carregarModal();
    favoritarReceita();
    showHidePasswordText();
    setCapsLockMessage();
});
