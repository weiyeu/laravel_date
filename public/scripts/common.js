/**
 * check email format
 *
 * @param String email

 */
function checkEmailFormat(email) {
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

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

/**
 * Insert HTML element into the selected position
 *
 * @param node
 *            An HTML element which is gonna be inserted
 * @param containerNode
 *              Container node for the HTML element be instered
 */
function insertNodeOverSelection(node, containerNode) {
    var sel, range, html, str;


    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            if (isOrContainsNode(containerNode, range.commonAncestorContainer)) {
                range.deleteContents();
                range.insertNode(node);
            } else {
                containerNode.appendChild(node);
            }
        }
    } else if (document.selection && document.selection.createRange) {
        range = document.selection.createRange();
        if (isOrContainsNode(containerNode, range.parentElement())) {
            html = (node.nodeType == 3) ? node.data : node.outerHTML;
            range.pasteHTML(html);
        } else {
            containerNode.appendChild(node);
        }
    }
}
function isOrContainsNode(ancestor, descendant) {
    var node = descendant;
    while (node) {
        if (node === ancestor) {
            return true;
        }
        node = node.parentNode;
    }
    return false;
}
/* on document ready */
$(function () {
    /*slide-toggle effect*/
    // configuration variable
    var toggleTimeDuration = 500;
    // event handler
    $("[data-toggle='slide']").each(function () {
        $(this).click(function () {
            var targetId = $(this).attr('data-target');
            var target = $(targetId);
            target.slideToggle(toggleTimeDuration);
        });
    });
});
