function ajaxValidate(url, _token, data) {
    return $.ajax({
        method: 'POST',
        url: url,
        dataType: 'json',
        data: data
    });
}
/**
 * check the input name is empty or used or if email, check email format
 *
 * @param node
 *            input node which should be checked
 * @param String nodeNmae
 *              the name of the input node
 * @param String warnIcon
 *              warning icon
 * @param String sucessIcon
 *              success icon
 */
function validateInput(node, nodeName, warnIcon, successIcon) {
    // node id
    var id = '#' + node.attr('id');
    // alert element
    var cAlert = $(id + ' + .c-alert');
    // emptyMessage
    var emptyMessage = '<strong>' + warnIcon + ' ' + nodeName + '不可以空白唷' + '</strong>';
    // notValidMessage
    var notValidMessage = '<strong>' + warnIcon + ' ' + nodeName + '格式不太對唷' + '</strong>';
    // warnMessage
    var warnMessage = '<strong>' + warnIcon + ' 這個' + nodeName + '已被使用' + '</strong>';
    // successMessage
    var successMessage = '<strong>' + successIcon + ' 這個' + nodeName + '讚喔' + '</strong>';
    // errorMessage
    var errorMessage = '<strong>' + warnIcon + ' 連不上線耶' + '</strong>';
    // formatValid flag
    var formatValid = (nodeName == 'Email') ? checkEmailFormat(node.val()) : true;
    // reset alert classes
    cAlert.removeClass('c-alert-danger c-alert-success');
    // if empty
    if (node.val().length < 1) {
        // insert warnMessage into alert element
        cAlert.html(emptyMessage);
        // set alert type
        cAlert.addClass('c-alert-danger');
    }
    // check input format
    else if (!formatValid) {
        // insert warnMessage into alert element
        cAlert.html(notValidMessage);
        // set alert type
        cAlert.addClass('c-alert-danger');
    }
    //pass initial check
    else {
        cAlert.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
        // ajax check input valid or not
        var _token = $('input[name=_token]').val();
        var url = '/laravel_date/public/users/ajax-check-email';
        var emailUsed = false;
        var ajaxData = {
            '_token': _token,
            'email': node.val()
        };
        $.when(ajaxValidate(url, _token, ajaxData))
            .always(function (data, status, jxhr) {
                if (status == 'success') {
                    if (data['used']) {
                        // insert warnMessage into alert element
                        cAlert.html(warnMessage);
                        // set alert type
                        cAlert.addClass('c-alert-danger');
                    }
                    else {
                        // insert successMessage into alert element
                        cAlert.html(successMessage);
                        // set alert type
                        cAlert.addClass('c-alert-success');
                    }
                } else {
                    // insert warnMessage into alert element
                    cAlert.html(errorMessage);
                    // set alert type
                    cAlert.addClass('c-alert-danger');
                }
            });
    }
    // slide down warnMessage to show it
    cAlert.slideDown(500);
}
$(function () {
    // configuration variables
    var warnIcon = '<i class="fa fa-exclamation-triangle"></i>';
    var successIcon = '<i class="fa fa-check"></i>';
    /*nickName blur*/
    $('#nickName').blur(function () {
        // check nickName
        validateInput($(this), '暱稱', warnIcon, successIcon);
    });
    /*Email blur*/
    $('#email').blur(function () {
        // check Eamil
        validateInput($(this), 'Email', warnIcon, successIcon);
    });
    /*click submit*/
    $('#submit').click(function () {
        var passwordId = '#password';
        var password = $(passwordId);
        var confirmPasswordId = '#confirmPassword';
        var confirmPassword = $(confirmPasswordId);
        var confirmPasswordAlert = $(confirmPasswordId + ' + .c-alert');
        /*check password confirm*/
        if (password.val() != confirmPassword.val()) {
            // process warnMessage
            warnMessage = '<strong>' + warnIcon + ' 跟密碼不一致唷' + '</strong>';
            // insert warnMessage into alert element
            confirmPasswordAlert.html(warnMessage);
            // set alert type
            confirmPasswordAlert.addClass('c-alert-danger');
            // slide down warnMessage to show it
            confirmPasswordAlert.slideDown(500);

            return false;
        }
        else {
            confirmPasswordAlert.slideUp(500);
        }
    });
});
