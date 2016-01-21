/**
 * show image file on .drop-area element
 *
 * @param uploadImg
 *            An image file object that is gonna show on drop-area
 * @param imgSrcObj
 *              image src object that contain local image src link(for pointer purpose)
 */
function showImgOnDropArea(uploadImg, imgSrcObj) {
    var reader = new FileReader();
    reader.onload = function (e) {
        // get img src
        localImgSrc = e.target.result;
        imgSrcObj.localImgSrc = localImgSrc;
        // create img element
        var img = $('<img/>').css({
            'width': '95%',
            'margin': '10px 0px',
        });
        // set img src attr
        img.attr('src', localImgSrc);
        // create div container elemnet
        var imgContainer = $('<div></div>').css({
            'width': '100%',
            'display': 'table-cell',
            'vertical-align': 'middle',
        });
        // append img to container
        imgContainer.append(img);
        // hide all children in drop-area
        $('.drop-area')
            .children().hide()
        // append img to drop-area
        $('.drop-area').append(imgContainer);
        // disable img link input
        $('#uploadImgLink').attr('disabled', 'true');
    };
    reader.readAsDataURL(uploadImg);
}

/* document ready */
$(function () {
    /* turn off firefox default image resize function*/
    document.execCommand("enableObjectResizing", false, false);

    // ajax upload url
    var ajaxUploadUrl = 'http://localhost/laravel_date/public/users/ajax-upload-image';

    // imgSrcObj to make imgSrc like pointer
    var imgSrcObj = {localImgSrc: null};
    var linkImgSrc;
    var uploadImg;

    // reset uploadImg and drop area at openModal clicked
    $('#openModal').click(function () {
        // reset uploadImg
        uploadImg = null;

        // clear drop area
        $('.drop-area div').remove();

        // show hidden paragraph
        $('.drop-area p').show();
    });

    // input file changed
    $('input#uploadImg').change(function () {
        uploadImg = this.files[0];
        showImgOnDropArea(uploadImg, imgSrcObj);
    });

    // drop-area event handler
    $('.drop-area')
        .on('click', function () {
            $('input#uploadImg')[0].click();
        })
        .on('dragover', function (e) {
            // prevent openning image as a link
            e.preventDefault();
        })
        .on('drop', function (e) {
            // prevent openning image as a link
            e.preventDefault();
            uploadImg = e.originalEvent.dataTransfer.files[0];
            showImgOnDropArea(uploadImg, imgSrcObj);
        });

    // click image in contenteditable div
    $('#editableContent')
        .on('click', function (e) {
            // get clicked target
            var target = e.target;
            // wrap as jquery object
            jTarget = $(target);
            // make sure click on img.inserted
            if (target.tagName == 'IMG' && target.className == 'inserted') {
                // select img
                /*
                 var range = document.createRange();
                 range.selectNode(jTarget[0]);
                 window.getSelection().removeAllRanges();
                 window.getSelection().addRange(range);
                 */
                // get resizeable state flag
                var resizeable = jTarget.data('resizeable');
                // bind events handler to img.inserted if it is not in resizeable state
                if (!resizeable) {
                    var dragging = false;
                    var startX = 0;
                    var startY = 0;
                    var startWidth = 0;
                    jTarget
                        .on('mousedown touchstart', function (e) {
                            e.preventDefault();
                            dragging = true;
                            startX = e.pageX;
                            startY = e.pageY;
                            startWidth = $(this).width();
                        })
                        .css({
                            'border': '3px dashed lightgray',
                            'cursor': 'nw-resize',
                        });
                    $(this)
                        .on('mousemove touchmove', function (e) {
                            if (dragging) {
                                var moveX = e.pageX - startX;
                                var moveY = e.pageY - startY;
                                // resize insertedImg
                                jTarget.css({
                                    'width': (startWidth + moveX) + 'px',
                                });
                                // change cursor
                                $(this).css({
                                    'cursor': 'nw-resize',
                                })
                            }
                        })
                        .on('mouseup touchend', function (e) {
                            dragging = false;
                            // clear cursor
                            $(this).css({
                                'cursor': '',
                            });
                        });
                }
                // unbind event handlers and reset img.inserted if it is in resizable state
                else {
                    jTarget
                        .unbind('mousedown mouseup mousemove')
                        .css({
                            'border': '',
                            'cursor': 'pointer',
                        });
                    $(this)
                        .unbind('mousemove mouseup');
                }
                // toggle resizeable
                jTarget.data('resizeable', !resizeable);
            }
            // reset and unbind event handlers if img.inserted isn't clicked
            else {
                $('img.inserted').each(function () {
                    $(this)
                        .unbind('mousedown mouseup mousemove')
                        .data('resizeable', false)
                        .css({
                            'border': '',
                            'cursor': '',
                        });
                });
                $(this).unbind('mousemove mouseup');
            }
        }); // end of $('editableContent').on('click',function{})

    /* modal */
    // click insert img confirm
    $('#uploadImgConfirm').click(function () {
        // check user has chosen upload image or not
        if (!$('input#uploadImg').val()) {
            alert('妳/你還沒有選取任何圖片唷');
            return false;
        }

        // set waiting icon
        var confirmUploadImg = $(this);
        $(this).append(' <i class="fa fa-spinner fa-spin"></i>');

        /** ajax upload image **/
        // create formData
        var formData = new FormData();
        // get _token
        var _token = $('input[name=_token]').val();
        // append uploadImg file to formData
        formData.append('uploadImg', uploadImg);
        // append _token
        formData.append('_token', _token);
        // append destination
        formData.append('destination', 'article_img');
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

                        // create insertedImg
                        var insertedImg = $('<img/>').css({
                            'width': '100px',
                        });

                        // set inserted image src and class
                        insertedImg.attr({
                            'src': data['imgSrc'],
                            'class': 'inserted',
                        });

                        // get editableContent
                        var editableContent = $('#editableContent');

                        // insert into editableContent
                        if (imgSrcObj.localImgSrc) {
                            insertNodeOverSelection(insertedImg[0], editableContent[0]);
                        }

                        // close modal
                        setTimeout(function () {
                            $('button.close').click();
                        }, 1000);

                        alert(data['imgSrc']);
                        console.log(data['imgSrc']);
                    }


                }
                // ajax fail
                else {
                    alert(status);
                    console.log(data);
                    console.log(jxhr);
                }

                // clear waiting icon
                $('#uploadImgConfirm i').remove();
            });

    });

    /* submit */
    $('#submit').click(function () {
        // get the contentEditable html
        var editableContentHtml = $('#editableContent').html();

        // insert html into hidden input articleContent
        $('#articleContent').val(editableContentHtml);
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
        formData.append('destination', 'article_img');
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

                    //// close modal
                    //setTimeout(function () {
                    //    $('button.close').click();
                    //}, 1000);
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
