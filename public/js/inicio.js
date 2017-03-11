
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


var modalBs = $('#modalBs');
var modalBsContent = $('#modalBs').find(".modal-content");
$(function(){

handleAjaxModal();
});




function handleAjaxModal() {


    // Limpia los eventos asociados para elementos ya existentes, asi evita duplicación
    $("a[data-modal]").unbind("click");
    // Evita cachear las transaccione Ajax previas
    $.ajaxSetup({ cache: false });

    // Configura evento del link para aquellos para los que desean abrir popups
    $("a[data-modal]").on("click", function (e) {
        var dataModalValue = $(this).data("modal");

        modalBsContent.load(this.href, function (response, status, xhr) {
            switch (status) {
                case "success":
                    modalBs.modal({ backdrop: 'static', keyboard: false }, 'show');

                    if (dataModalValue == "modal-lg") {
                        modalBs.find(".modal-dialog").addClass("modal-lg");
                    } else {
                        modalBs.find(".modal-dialog").removeClass("modal-lg");
                    }

                    break;

                case "error":
                    var message = "Error de ejecución: " + xhr.status + " " + xhr.statusText;
                    if (xhr.status == 403) $.msgbox(response, { type: 'error' });
                    else $.msgbox(message, { type: 'error' });
                    break;
            }

        });
        return false;
    });
}


function EventoFormularioModal(modal, onSuccess) {
    modal.find('form').submit(function () {
        $.ajax({
            url: this.action,
            type: this.method,
            data: $(this).serialize(),
            success: function (result) {
                onSuccess(result);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var message = "Error de ejecución: " + textStatus + " " + errorThrown;
                $.msgbox(message, { type: 'error' });
                console.log("Error: ");
            }
        });
        return false;
    });
}

jQuery.fn.reset = function () {
    $(this).each (function() { this.reset(); });
}

function validarNumeros($texto)
{
    var filter6=/^[0-9\s\xF1\xD1]+$/;
    if (filter6.test($texto)){
        return true;
    }
    else{
        return false;
    }
}
function validarTexto($texto){
    var filter6=/^[A-Za-z\ \s\xF1\xD1]+$/;
    if (filter6.test($texto)){
        return true;
    }
    else{
        return false;
    }
}

$(function() {
    envttohs();
    var formulario = $("#formLogin");
    formulario.submit(function(e){
        e.preventDefault();
        $.ajax({
            type:"POST",
            context: document.body,
            url: rutaLogin,
            data:formulario.serialize(),
            success: function(data){
                if (data=="login exitoso") {
                    $('#iniciarSesion').modal('hide')
                    //modalBs.modal('hide');
                    window.location="jugador";
                    //window.location.reload();
                }
                else {
                    $("#error").text(data);
                    $("#error").css('display','block');

                }
            },
            error: function(data){
                console.log(data);
            }
        });
    });
});

function justNumbers(e)
{
    var keynum = window.event ? window.event.keyCode : e.which;
    if (keynum == 8)
        return true;
    return /\d/.test(String.fromCharCode(keynum));
}

function justletters(e) {
    var keynum = window.event ? window.event.keyCode : e.which;
    patron =/[A-Za-zñÑ\s]/;
    te = String.fromCharCode(keynum);
    return patron.test(te);
}

function formatHora(valor){
    valor = parseInt(valor);
    // console.log(valor);
    var respuesta = "";
    if(valor>12){
        if(valor<22)
            respuesta = "0"+((valor-2).toString().substr(-1))+":00 pm";
        else
            respuesta = "1"+((valor-2).toString().substr(-1))+":00 pm";
    }
    else if (valor==0)
        respuesta = "12:00 pm";
    else
        respuesta = valor+":00 am";
    return respuesta;
}

function touchHandler(event)
{
    var touches = event.changedTouches,
        first = touches[0],
        type = "";
    switch(event.type)
    {
        case "touchstart": type = "mousedown"; break;
        case "touchmove":  type="mousemove"; break;
        case "touchend":   type="mouseup"; break;
        default: return;
    }

    var simulatedEvent = document.createEvent("MouseEvent");
    simulatedEvent.initMouseEvent(type, true, true, window, 1,
        first.screenX, first.screenY,
        first.clientX, first.clientY, false,
        false, false, false, 0/*left*/, null);
    first.target.dispatchEvent(simulatedEvent);
    // event.preventDefault();
}

function envttohs()
{
    document.addEventListener("touchstart", touchHandler, true);
    document.addEventListener("touchmove", touchHandler, true);
    document.addEventListener("touchend", touchHandler, true);
    document.addEventListener("touchcancel", touchHandler, true);
}