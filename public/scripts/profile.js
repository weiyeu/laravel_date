/**
 * ajax upload image to server
 *
 * @param FormData formData
 *            data to be uploaded which contain uploadImg
 * @param String url
 *              the ajax upload url
 * @return jqXHR
 */
function ajaxUploadImg(formData, url) {
    return $.ajax({
        method: 'POST',
        url: url,
        datatype: 'json',
        data: formData,
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
    });
}

$(function () {
    /* configurations */
    // ajax upload url
    var ajaxUploadUrl = 'http://localhost/laravel_date/public/users/ajax-upload-profile_image';
    // boxWidth in px
    var jcropHolderWidth = 500;
    var setSelectArr = [150, 100, 350, 300];
    // profileImg instance
    var profileImg = $('#profileImg');
    // previewImg instance
    var previewImg = $('#previewImg');
    // previewContainer instance
    var previewContainer = $('.previewContainer');
    // get previewContainer width and height
    var preivewContainerWidth = previewContainer.width();
    var preivewContainerHeight = previewContainer.height();

    // set profileImg to Jcrop
    var profileImgJcrop;

    profileImg.Jcrop({
        aspectRatio: 1,
        boxWidth: jcropHolderWidth,
        keySupport: false,
        scaledSize: true,
        //setSelect: setSelectArr,
        onChange: preview,
        onSelect: preview,
        disabled: true,
    }, function(){
        profileImgJcrop = this;
    });

    // jcrop-holder instance
    var jcropHolder = $('.jcrop-holder');



    // set Jcrop align horizontal middle
    jcropHolder.css({
        'margin': 'auto',
    });

    // privew callback funtion
    function preview(selection) {
        var scaleX = preivewContainerWidth / (selection.w || 1);
        var scaleY = preivewContainerHeight / (selection.h || 1);
        previewImg.each(function () {
            $(this).css({
                'width': Math.round(scaleX * jcropHolderWidth) + 'px',
                // 'height' : Math.round(scaleY * jcropHolder.height()) + 'px',
                'margin-left': '-' + Math.round(scaleX * selection.x) + 'px',
                'margin-top': '-' + Math.round(scaleY * selection.y) + 'px',
            });
        });
    }

    /** upload image for preview**/
    var uploadImg;
    $('#uploadImg').change(function (e) {
        // get selected files for further ajax use
        uploadImg = this.files[0];

        // instance FileReader
        var reader = new FileReader();

        // onload handler
        reader.onload = function (e) {
            // reset Jcrop image
            profileImgJcrop.setImage(e.target.result);

            // reset Jcrop select area
            profileImgJcrop.setSelect(setSelectArr);

            // set previewImg to uploaded img
            previewImg.each(function () {
                $(this).attr('src', e.target.result);
            });

            // show previewImg
            $('.previewContainer.hidden').removeClass('hidden');

            // show confirmUpload btn
            $('#confirmUploadImg').removeClass('hidden');
        };
        reader.readAsDataURL(uploadImg);
    });

    /** select upload image from local **/
    $('#selectUploadImg').on('click',function(){
        $('#uploadImg').click();
    });

    /** ajax upload image **/
    $('#confirmUploadImg').on('click', function () {
        // create formData
        var formData = new FormData();
        // get _token
        var _token = $('input[name=_token]').val();
        // append uploadImg file to formData
        formData.append('uploadImg', uploadImg);
        // append _token
        formData.append('_token', _token);
        // append destination
        formData.append('destination', 'profile_image');
        // ajax upload
        $.when(ajaxUploadImg(formData, ajaxUploadUrl, _token))
            .always(function (data, status, jxhr) {
                // ajax succeed
                if (status == 'success') {
                    // image check fail
                    if (data['error']) {
                        alert(data['error']);
                    }
                    // image check succeed
                    else {
                        alert(data['imgSrc']);
                        console.log(data['imgSrc']);
                    }
                    // hide jcrop and prview img
                    // add cropped img into modal
                    // close modal
                    setTimeout(function(){
                        $('button.close').click();
                    },1000);
                }
                // ajax fail
                else {
                    alert(status);
                    console.log(data);
                    console.log(jxhr);
                }
            });
    });
    // event handler
    // $("button[data-toggle='modal']").click(function(){
    // 	profileImg.data('Jcrop').setSelect(setSelectArr);
    // });

});
