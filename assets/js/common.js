//Loading

var loading = $('#loading');

function showLoading (tip) {
    if (!loading.length) {
        $('<div id="loading"><div class="loading-content"><div id="loading-center" class="loading-icon"></div>'
            + '</div><div id="loading-tip" class="row"></div></div>').appendTo($(document.body));
        loading = $('#loading');
    }

    $('#loading-tip').html(tip);
    loading.show();
}

function hideLoading () {
    loading.hide();
}

//Alert

function showAlert (tip) {
    showDialog({
        id: 'modal-alert',
        css: 'modal-warning',
        type: 'modal-alert',
        title: '提示',
        desc: tip,
        btnCancel: {
            show: false
        },
        callbacks: {
            'onClickOk': function (e, dialog) {
                dialog.modal('hide');
            }
        }
    });
}

//Dialog

function showDialog (opts) {
    var dialog = $('#' + opts.id), modal;
    var defaultOpts = {
        id: 'id',
        css: '',
        type: 'modal-info',
        title: '提示',
        desc: '',
        btnOk: {
            show: true,
            label: '确认'
        },
        btnCancel: {
            show: true,
            label: '取消'
        },
        modal: {
            backdrop: true, //布尔值或者字符串'static'
            show: true
        },
        callbacks: {
            'onClickOk': function (e, dialog) {

            },
            'onClickCancel': function (e, dialog) {

            },
            'modalBeforeShow': function (e, dialog) {

            },
            'modalAfterHide': function (e, dialog) {

            }
        }
    };

    if (!opts || !opts.id) {
        console.log('需要设定dialog的id');
        return;
    } else if (!dialog.length) {
        dialog = '<div class="modal fade">'
            + '<div class="modal-dialog"><div class="modal-content">'
            + '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="关闭"></button>'
            + '<h4 class="modal-title dialog-title"></h4></div>'
            + '<div class="modal-body dialog-desc"></div>'
            + '<div class="modal-footer"><button type="button" class="btn btn-outline btn-cancel" data-dismiss="modal">关闭</button>'
            + '<button type="button" class="btn btn-outline btn-ok">确认</button></div></div></div></div>';

        dialog = $(dialog).attr('id', opts.id);
        dialog.appendTo(document.body);
    }

    for (var key in defaultOpts) {
        if (defaultOpts.hasOwnProperty(key)) {
            if (typeof defaultOpts[key] == 'object') {
                if (opts[key] === undefined) {
                    opts[key] = defaultOpts[key];
                } else {
                    for (var _key in defaultOpts[key]) {
                        if (defaultOpts[key].hasOwnProperty(_key)) {
                            if (opts[key][_key] === undefined) {
                                opts[key][_key] = defaultOpts[key][_key];
                            }
                        }
                    }
                }
            } else {
                if (opts[key] === undefined) {
                    opts[key] = defaultOpts[key];
                }
            }
        }
    }

    dialog.addClass(opts.css);
    dialog.addClass(opts.type);

    if (opts.title) {
        dialog.find('.dialog-title').html(opts.title).show();
    } else {
        dialog.find('.dialog-title').hide();
    }

    if (opts.desc) {
        dialog.find('.dialog-desc').html(opts.desc).show();
    } else {
        dialog.find('.dialog-desc').hide();
    }

    if (opts.btnOk) {
        if (opts.btnOk.show) {
            dialog.find('.btn-ok').html(opts.btnOk.label);
        } else {
            dialog.find('.btn-ok').hide();
        }
    }

    if (opts.btnCancel) {
        if (opts.btnCancel.show) {
            dialog.find('.btn-cancel').html(opts.btnCancel.label);
        } else {
            dialog.find('.btn-cancel').hide();
        }
    }

    modal = dialog.modal(opts.modal);
    dialog.on('show.bs.modal', function (e) {
        opts.callbacks.modalBeforeShow(e, dialog);
    });
    dialog.on('hidden.bs.modal', function (e) {
        opts.callbacks.modalAfterHide(e, dialog);
    });

    dialog.find('.btn-ok').on('click', function (e) {
        opts.callbacks.onClickOk(e, dialog);
    });

    dialog.find('.btn-cancel').on('click', function (e) {
        opts.callbacks.onClickOk(e);
        dialog.modal('hide');
    });
}

function hideDialog (id) {
    $('#' + id).modal('hide');
}

function getParameterByName(name, href) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(href || window.location.href);

    if (results == null) {
        return "";
    } else {
        return decodeURIComponent(results[1].replace(/\+/g, " "));
    }
}



