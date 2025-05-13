
function limpaErros() {
    $('[id^="error_"]').text('').hide();
    $('input, select, textarea').removeClass('is-invalid');
}

function exibeErros(errors) {
    $.each(errors, function (field, mensagens) {
        const $campo = $('[name="' + field + '"]');
        const $erro = $('#error_' + field);
        if ($campo.length) {
            $campo.addClass('is-invalid');
        }
        if ($erro.length) {
            $erro.text(mensagens.join(' ')).show();
        }
    });
}

let deleteUrl = '';
let afterDelete = null;

function confirmarExclusao(url, callback) {
    deleteUrl = url;
    afterDelete = callback || null;
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}

// Função global para voltar
function setPreviousUrl(url) {
    sessionStorage.setItem('previousUrl', url);
}

// Função global para voltar
function goBack() {
    const previousUrl = sessionStorage.getItem('previousUrl');
    if (previousUrl) {
        window.open(previousUrl, '_self');
    } else {
        window.history.back(); // Fallback se não houver URL anterior
    }
}

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="csrf_token"]').val()
        }
    });

    $('#btn-delete').on('click', function () {
        $('#alert-container').addClass('d-none');
        $.ajax({
            url: deleteUrl,
            method: 'DELETE',
            success: function () {
                if (typeof afterDelete === 'function') afterDelete();
            },
            error: function (xhr) {
                $('#alert-container').removeClass('d-none');
                $('#alert-message').html(xhr.responseJSON?.message || 'Erro ao excluir.');
                setTimeout(function () {
                    $('#alert-container').addClass('d-none');
                }, 20000)
            },
            complete: function () {
                bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
            }
        });
    });

})