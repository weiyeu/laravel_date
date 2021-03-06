function ajaxValidate(url, data) {
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
    //
    var inputName = (nodeName == "Email") ? 'email' : 'nickname';
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
        // insert waiting icon into alert element
        cAlert.html('<i class="fa fa-spinner fa-spin"></i>');
        // ajax check variables
        var _token = $('input[name=_token]').val();
        var url = '/laravel_date/public/users/ajax-check-input-used';
        var inputUsed = false;
        var ajaxData = {
            '_token': _token,
            'inputUnderCheck': node.val(),
            'inputName' : inputName
        };
        // ajax check input data is used or not
        $.when(ajaxValidate(url, ajaxData))
            .always(function (data, status, jxhr) {
                // ajax succeed
                if (status == 'success') {
                    // input data is used
                    if (data['used']) {
                        // insert warnMessage into alert element
                        cAlert.html(warnMessage);
                        // set alert type
                        cAlert.addClass('c-alert-danger');
                    }
                    // input data is not used
                    else {
                        // insert successMessage into alert element
                        cAlert.html(successMessage);
                        // set alert type
                        cAlert.addClass('c-alert-success');
                    }
                // ajax fail
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

    /*set year select list*/
    $('select#year').each(function () {
        // current date object
        var date = new Date();
        // current year
        var currentYear = date.getFullYear();
        // append year to select list
        for (var i = 0; i < 90; i++) {
            var year = currentYear - i;
            $(this).append('<option value=\'' + year + '\'>' + year + '</option>');
        }
    });
    /*set month select list*/
    $('select#month').each(function () {
        // month array
        var monthArr = ['一', '二', '三', '四', '五', '六', '七', '八', '九', '十', '十一', '十二'];
        // get this
        var element = $(this);
        // month num
        var month = 1;
        // append month to select list
        monthArr.forEach(function (entry) {
            element.append('<option value=\'' + month + '\'>' + entry + '</option>');
            month++;
        });
    });
    /*set date select list*/
    $('select#date').each(function () {
        // number of dates per month
        var numOfDates = 31;
        // append date to select list
        for (var i = 1; i <= numOfDates; i++) {
            $(this).append('<option value=\'' + i + '\'>' + i + '</option>');
        }
    });
});
