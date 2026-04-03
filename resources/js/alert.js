import $ from "jquery";
window.jQuery = window.$ = $;
import jQueryConfirm from "jquery-confirm";
window.jQuery.alert = window.$.alert = jQueryConfirm;
window.jQuery.confirm = window.$.confirm = jQueryConfirm;

export function cAlert(type, title, content, reload, redirect) {
    if (type == "green") {
        var icon = "fa-solid fa-check";
    } else if (type == "orange" || type == "red" || type == "blue") {
        var icon = "fa-solid fa-triangle-exclamation";
    } else {
        var icon = "fa-solid fa-check";
    }
    if (reload === true) {
        $.alert({
            type: type,
            icon: icon,
            title: title,
            content: content,
            useBootstrap: false,
            onDestroy: function () {
                location.reload();
            },
        });
    } else {
        $.alert({
            type: type,
            icon: icon,
            title: title,
            content: content,
            useBootstrap: false,
            onDestroy: function () {
                window.location.href = redirect;
            },
        });
    }
}
export function oAlert(type, title, content) {
    if (type == "green") {
        var icon = "fa-solid fa-check";
    } else if (type == "orange" || type == "red" || type == "blue") {
        var icon = "fa-solid fa-triangle-exclamation";
    } else {
        var icon = "fa-solid fa-check";
    }
    $.alert({
        type: type,
        icon: icon,
        title: title,
        content: content,
        useBootstrap: false,
    });
}
export function cConfirm(title, content, cFunction) {
    var icon = "fa-solid fa-triangle-exclamation";
    $.confirm({
        type: "orange",
        icon: icon,
        title: title,
        content: content,
        autoClose: "cancel|8000",
        useBootstrap: false,
        buttons: {
            ok: {
                text: "Confirm",
                action: function () {
                    cFunction();
                },
            },
            cancel: {
                text: "Cancel",
            },
        },
    });
}
