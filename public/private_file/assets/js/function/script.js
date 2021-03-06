function SeePassword(params) {
    let password = params.idPassword;
    let button = params.idButton;
    let type= $(`#${password}`).attr('type')
    if(type == 'password'){
        $(`#${password}`).attr('type', 'text');
        $(`#${button}`).html('<i class="fas fa-eye"></i>')
    }else{
        $(`#${password}`).attr('type', 'password');
        $(`#${button}`).html('<i class="fas fa-eye-slash"></i>')
    }
}

function ConfirmPassword(params) {
    let password = $(`#${params.idPassword}`).val()
    let confirmPassword = $(`#${params.idConfirmPassword}`).val()

    if (password == confirmPassword) {
        return 1;
    }else{
        return 0;
    }
}

function Table(data) {
    $(data.table).DataTable().destroy();
    if (data.callbackButton) {
        if(data.parm){
            $(data.table).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: data.url,
                    data:data.parm
                },
                language: {
                    "search": "Search Data:",
                    'searchPlaceholder' : 'Search'
                },
                columns: data.data,
                fnDrawCallback: function() {
                    $(`${data.callbackButton.id}`).bootstrapToggle({
                        size:data.callbackButton.size,
                        on:data.callbackButton.on,
                        onstyle:data.callbackButton.onstyle,
                        offstyle:data.callbackButton.offstyle,
                        off:data.callbackButton.off,
                    });
                },
            });
        }else{
            $(data.table).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: data.url
                },
                 language: {
                    "search": "Search Data:",
                    'searchPlaceholder' : 'Search'
                },
                columns: data.data,
                fnDrawCallback: function() {
                    $(`${data.callbackButton.id}`).bootstrapToggle({
                        size:data.callbackButton.size,
                        on:data.callbackButton.on,
                        onstyle:data.callbackButton.onstyle,
                        offstyle:data.callbackButton.offstyle,
                        off:data.callbackButton.off,
                    });
                },
            });
        }
    } else {
        if(data.parm){
            $(data.table).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: data.url,
                    data:data.parm
                },
                 language: {
                    "search": "Search Data:",
                    'searchPlaceholder' : 'Search'
                },
                columns: data.data,
                fnDrawCallback: function() {
                    $('.input-toggle').bootstrapToggle({
                        size:'small',
                        on:'<i class="fas fa-check"></i> Active',
                        onstyle : 'success',
                        off:'<i class="fas fa-times"></i> Inactive',
                        offstyle:'danger',
                    });
                },
            });
        }else{
            $(data.table).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: data.url
                },
                 language: {
                    "search": "Search Data:",
                    'searchPlaceholder' : 'Search'
                },
                columns: data.data,
                fnDrawCallback: function() {
                    $('.input-toggle').bootstrapToggle({
                        size:'small',
                        on:'<i class="fas fa-check"></i> Active',
                        onstyle : 'success',
                        off:'<i class="fas fa-times"></i> Inactive',
                        offstyle:'danger',
                    });
                },
            });
        }
    }

    $(`${data.table}_filter input`).removeClass('form-control-sm')
}

function SweetAlert(data){
    let status, title

    Swal.fire(data.status, data.message, data.status)
}

function RefreshTable(data) {
    table = $(`#${data}`).DataTable();
    table.ajax.reload()
}

function checkbox_all(val){
    var checkbox = $('#table input[name="id-checkbox"]');
    if ( checkbox.length > 0 ) {
        for (i = 0; i < checkbox.length; i++) {
            if ( val.checked ) {
                checkbox[i].checked = true;
                value_checkbox.push(checkbox[i].value)
            }
            else {
                checkbox[i].checked = false;
                 var index = value_checkbox.indexOf(checkbox[i].value);

                if (index > -1) {
                    value_checkbox.splice(index, 1);
                }
            }
        }
    }
    else {
        if ( val.checked ) {
            checkbox.checked = true;
        }
        else {
            checkbox.checked = false;
        }
    }

}

function checkbox_this(val) {
    if ( val.checked ) {
        $(this).checked = true;
        value_checkbox.push(val.value)
    }
    else {
        $(this).checked = false;
        var index = value_checkbox.indexOf(val.value);

        if (index > -1) {
            value_checkbox.splice(index, 1);
        }
    }
}

function SweetQuestions(data){
    Swal.fire({
        title: data.title,
        text: data.subtitle,
        icon:'question',
        showCancelButton: false,
        showDenyButton: true,
        confirmButtonText: data.buttonConfirm,
        denyButtonText: data.buttonDeny,
        reverseButtons:false,
    }).then((result) => {
        if (result.isConfirmed) {
            if (data.confirm == 'ajax') {
                if (data.ajax.contentType != null) {
                    $.ajax({
                        url:data.ajax.url,
                        type:data.ajax.type,
                        data:data.ajax.data,
                        processData:data.ajax.processData,
                        contentType:data.ajax.contentType,
                        headers:data.ajax.headers,
                        success:data.ajax.success,
                        error:data.ajax.error
                    })
                }else{
                    $.ajax({
                        url:data.ajax.url,
                        type:data.ajax.type,
                        data:data.ajax.data,
                        headers:data.ajax.headers,
                        success:data.ajax.success,
                        error:data.ajax.error
                    })
                }
            }else{

            }
        } else if (result.isDenied) {
            Swal.fire(data.deny.title, ' ', data.deny.icon)
        }
    })
}

