var AJAX_DELAY = 100;

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

function refreshQueryPage (params) {
    window.location.href = getQueryString(params);
}

function getQueryString (params) {
    var queryString = window.location.href;
    var regex = new RegExp(name + "=[^&#]*");

    for (var i in params) {
        if (params.hasOwnProperty(i)) {
            if (queryString.match(new RegExp(i + '='))) {
                regex = new RegExp(i + "=[^&#]*");
                queryString = queryString.replace(regex, i + '=' + params[i]);
            } else {
                if (queryString.split('?')[1] && queryString.split('?')[1].length) {
                    queryString += '&' + i + '=' + params[i];
                } else {
                    queryString += '?' + i + '=' + params[i];
                }
            }
        }
    }

    return queryString;
}

function modifyAjaxForm(form, attr) {
    var ajaxForm = $('#ajax-form');

    ajaxForm.attr({
        'action': form.attr('action'),
        'method': form.attr('method')
    });
}

function getFormItemValue ($form, name, type) {
    type = type || 'input';

    return $form.find(type + '[name="' + name + '"]').val();
}

function setFormItemValue($form, name, val, type) {
    type = type || 'input';

    return $form.find(type + '[name="' + name + '"]').val(val);
}

function setFormValue (form , data) {
    if (form.find('form').length) {
        form = form.find('form');
    }

    if (data) {
        for (var key in data) {
            var node = form.find('input[name="' + key + '"]');

            if (node.length) {
                node.val(data[key]);
            } else if (form.find('select[name="' + key + '"]').length) {
                if (data[key]) {
                    form.find('option[value="' + data[key] + '"]').attr('selected', 'selected');
                }
            } else {
                $('<input name="' + key + '" value="' + data[key] + '" />').appendTo(form);
            }
        }
    }
}

function ajaxSubmitForm(form, callback) {
    var formData = new FormData();
    var data = form.serializeArray();

    form.find('button[type="submit"]').attr('disabled', 'disabled');

    for (var i = 0, li = data.length; i < li; i++) {
        formData.append(data[i].name, data[i].value);
    }

    showLoading();
    setTimeout(function () {
        $.ajax({
            type: form[0].method,
            url: form[0].action,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data && typeof data == 'string') {
                    try {
                        data = JSON.parse(data);
                    } catch (e) {

                    }
                }

                callback && callback(data);
                form.find('button[type="submit"]').removeAttr('disabled');
                hideLoading();
            },
            error: function (err) {
                callback && callback();
                form.find('button[type="submit"]').removeAttr('disabled');
                hideLoading();
            }
        });
    }, 100);
}


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

//Dialog

function showDialog (opts) {
    var dialog = $('#' + opts.id), modal;
    var defaultOpts = {
        id: 'id',
        css: '',
        type: 'modal-info',
        header: {
            show: true
        },
        title: '提示',
        desc: '',
        btnClose: {
            show: false
        },
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
        footer: {
            show: true,
            css: 'text-center'
        },
        autoHide: {
            'onClickOk': true
        },
        callbacks: {
            'onClickOk': function (e, dialog) {

            },
            'onClickCancel': function (e, dialog) {

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
            + '<div class="modal-title dialog-title"></div></div>'
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

    if (opts.header.show) {
        if (opts.title) {
            dialog.find('.dialog-title').html(opts.title).show();
        } else {
            dialog.find('.dialog-title').hide();
        }
    } else {
        dialog.find('.modal-header').hide();
    }

    if (opts.desc) {
        dialog.find('.dialog-desc').html(opts.desc).show();
    } else {
        dialog.find('.dialog-desc').hide();
    }

    if (!opts.footer.show) {
        dialog.find('.modal-footer').hide();
    }
    
    if (opts.footer.css) {
        dialog.find('.modal-footer').addClass(opts.footer.css);
    }

    if (opts.btnClose.show) {
        dialog.find('button.close').show();
    }

    if (opts.btnOk) {
        if (opts.btnOk.show) {
            dialog.find('.btn-ok').html(opts.btnOk.label);
        } else {
            dialog.find('.btn-ok').remove();
        }
    }

    if (opts.btnCancel) {
        if (opts.btnCancel.show) {
            dialog.find('.btn-cancel').html(opts.btnCancel.label);
        } else {
            dialog.find('.btn-cancel').remove();
        }
    }

    modal = dialog.modal(opts.modal);

    dialog.find('.btn-ok').off('click').on('click', function (e) {
        opts.callbacks.onClickOk(e, dialog);
        opts.autoHide.onClickOk && dialog.modal('hide');
    });

    dialog.find('.btn-cancel').off('click').on('click', function (e) {
        opts.callbacks.onClickCancel(e);
        dialog.modal('hide');
    });

    dialog.find('button.close').off('click').on('click', function (e) {
        opts.callbacks.onClickCancel(e);
        dialog.modal('hide');
    });

    adjustDialog(modal);
}

function hideDialog (id) {
    $('#' + id).modal('hide');
}

function adjustDialog (modal) {
    var dialog = modal.find('.modal-dialog');

    if (dialog.height() < 10) {
        setTimeout(function () {
            adjustDialog(modal);
        }, 10);

        return false;
    }

    dialog.css({
        'margin-top': ($(window).height() - dialog.height()) / 2 - 30
    });
}

//info

function showInfo (tip) {
    showDialog({
        id: 'modal-info',
        css: 'modal-msg',
        type: 'modal-info',
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

function adjustMiddleContent() {
    var $sidebarHeight = $('.main-sidebar').height();

    if ($sidebarHeight > 800) {
        $('.middle-content').css({
            'min-height': $sidebarHeight
        });
    }
}

function go_back (default_url) {
    if (document.referrer && document.referrer.match(/zuigonghui/)) {
        history.back();
    } else {
        window.location.href = default_url;
    }
}

$(window).on('resize', function () {
    adjustMiddleContent();
});

$(document).ready(function () {
    adjustMiddleContent();

    $('.sort-item').on('click', function (e) {
        var $this = $(this);
        var sort = $this.attr('data-sort'), order = '';

        if ($this.hasClass('sort-both') || $this.hasClass('sort-asc')) {
            order = 'desc';
        } else {
            order = 'asc';
        }

        refreshQueryPage({
            'order': order,
            'sort': sort
        });
    });

    setTimeout(function () {
        if ($(window).height() == document.body.scrollHeight) {
            $('.main-footer').addClass('fixed');
        }
    }, 50);
});


