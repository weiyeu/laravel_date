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
    // smallProfileImg instance
    var smallProfileImg = $('#smallProfileImg');
    // smallProfileContainer
    var smallProfileContainer = $('.smallProfileContainer');
    // previewImg instance
    var previewImg = $('#previewImg');
    // previewContainer instance
    var previewContainer = $('.previewContainer');
    // get previewContainer width and height
    var preivewContainerWidth = previewContainer.width();
    var preivewContainerHeight = previewContainer.height();
    // get smallProfileContainer width and height
    var smallProfileContainerWidth = smallProfileContainer.width();
    var smallProfileContainerHeight = smallProfileContainer.height();

    // Jcrop API instance
    var profileImgJcrop;

    // Jcrop selection
    var selection;

    // Jcrop unscaled selection
    var unscaledSelection;

    // local imgSrc
    var localImgSrc;

    // set profileImg to Jcrop
    profileImg.Jcrop({
        aspectRatio: 1,
        boxWidth: jcropHolderWidth,
        keySupport: false,
        scaledSize: false,
        //setSelect: setSelectArr,
        onChange: preview,
        onSelect: preview,
        disabled: true,
    }, function () {
        profileImgJcrop = this;
    });

    // jcrop-holder instance
    var jcropHolder = $('.jcrop-holder');


    // set Jcrop align horizontal middle
    jcropHolder.css({
        'margin': 'auto',
    });

    // privew callback funtion
    function preview(c) {
        // set selection
        selection = c;

        // get scaled selection for preivew
        unscaledSelection = profileImgJcrop.tellScaled();

        // set previewImg
        var scaleX = preivewContainerWidth / (unscaledSelection.w || 1);
        var scaleY = preivewContainerHeight / (unscaledSelection.h || 1);

        previewImg.css({
            'width': Math.round(scaleX * jcropHolderWidth) + 'px',
            // 'height' : Math.round(scaleY * jcropHolder.height()) + 'px',
            'margin-left': '-' + Math.round(scaleX * unscaledSelection.x) + 'px',
            'margin-top': '-' + Math.round(scaleY * unscaledSelection.y) + 'px',
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
            // set localImgSrc
            localImgSrc = e.target.result;

            // reset Jcrop image
            profileImgJcrop.setImage(localImgSrc);

            // reset Jcrop select area
            profileImgJcrop.setSelect(setSelectArr);

            // set previewImg to uploaded img
            previewImg.each(function () {
                $(this).attr('src', localImgSrc);
            });

            // show previewImg
            $('.previewContainer.hidden').removeClass('hidden');

            // change selectUploadImg btn text
            $('#selectUploadImg').text('重新選擇圖片');

            // show confirmCrop btn
            $('#confirmCrop').removeClass('hidden');
        };
        reader.readAsDataURL(uploadImg);
    });

    /** select upload image from local **/
    $('#selectUploadImg').on('click', function () {
        // reset input file value to prevent onchange event not fired with the same file be selected
        // fire input file click
        $('#uploadImg')
            .val(null)
            .click();
    });
    /** confirm crop **/
    $('#confirmCrop').on('click', function () {
        // set the small profile image src
        $('#smallProfileImg').attr({
            'src' : localImgSrc,
        });

        // set the image scale and position
        var scaleX = smallProfileContainerWidth / (unscaledSelection.w || 1);
        var scaleY = smallProfileContainerHeight / (unscaledSelection.h || 1);
        smallProfileImg.css({
            'width': Math.round(scaleX * jcropHolderWidth) + 'px',
            // 'height' : Math.round(scaleY * jcropHolder.height()) + 'px',
            'margin-left': '-' + Math.round(scaleX * unscaledSelection.x) + 'px',
            'margin-top': '-' + Math.round(scaleY * unscaledSelection.y) + 'px',
        });

        // disable Jcrop selection
        profileImgJcrop.disable();

        // close modal
        $('button.close').click();

        // hide confirmCrop button
        $(this).addClass('hidden');

        // create imageCropRect for PHP imagecrop function
        var imageCropRect ={
            'x' : selection.x,
            'y' : selection.y,
            'width' : selection.w,
            'height' : selection.h,
        };

        // transfer to json
        var jsonSelection = JSON.stringify(imageCropRect);

        // set selection into input
        $('#jcropSelection').val(jsonSelection);
    });




    /** ajax upload image **/
    $('#confirmUploadImg').on('click', function () {
        // append waiting icon
        var confirmUploadImg = $(this);
        $(this).append(' <i class="fa fa-spinner fa-spin"></i>');
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
                    // disable jcrop select function
                    profileImgJcrop.disable();

                    // hide confirmUploadImg btn and remove wating icon
                    confirmUploadImg.addClass('hidden');
                    confirmUploadImg.text('確認上傳');

                    // close modal
                    setTimeout(function () {
                        $('button.close').click();
                    }, 1000);
                }
                // ajax fail
                else {
                    alert(status);
                    console.log(data);
                    console.log(jxhr);
                }
            });
    });
});
