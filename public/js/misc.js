function alertOk (titulo, message, callback) {
    swal({
        title: titulo,
        text: message,
        icon: "success",
        button: "Aceptar",
        closeOnClickOutside: false,

    }).then((value) => {
        if(typeof callback !== 'undefined')
            callback();
    });
}

function alertFail (titulo, message, callback) {
    swal({
        title: titulo,
        text: message,
        icon: "error",
        button: "Aceptar",
        closeOnClickOutside: false,
    }).then((value) => {
        if(typeof callback !== 'undefined')
            callback();
    });
}

function AlertLoading(titulo, message, callback){
    swal({
        title: titulo,
        text: message,
        icon: "info",
        button: false,
        closeOnClickOutside: false,
    }).then((value) => {
        if(typeof callback !== 'undefined')
            callback();
    });
}

function alertOkCallback (titulo, message, callback) {
    swal({
        title: titulo,
        text: message,
        icon: "error",
        button: "Aceptar",
        closeOnClickOutside: false,
    }).then((value) => {
        callback();
    });
}
