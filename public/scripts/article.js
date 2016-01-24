/**
 * ajax upload to server
 *
 * @param Object data
 *            data to be uploaded
 * @param String url
 *              the ajax upload url
 * @return jqXHR
 */
function ajaxUpload(url, data) {
    return $.ajax({
        method: 'POST',
        url: url,
        dataType: 'json',
        data: data
    });
}

$(function () {
    // click btn like
    $('#like').click(function () {
        // get articleId
        var articleId = $(this).data('articleId');
        // set postLikeUrl
        var postLikeUrl = '/laravel_date/public/article/p/ajax-like/' + articleId;
        // get _token
        var _token = $('input[name=_token]').val();
        // data
        var data = {'_token':_token};
        // ajaxUpload
        $.when(ajaxUpload(postLikeUrl,data))
            .always(function (data, status, jxhr) {
                // ajax success
                if (status == 'success') {
                    // error
                    if(data['error']){
                        alert(data['error']);
                    }
                    // no error
                    else{
                        alert(data['num_of_likes']);
                    }
                }
                // ajax fail
                else{
                    alert(status);
                    console.log(data.responseText);
                }
            });
    });
});