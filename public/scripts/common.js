/**
 * validate email format
 * 
 * @param String email

 */
function validateEmail(email) {
	var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}
/**
 * Insert HTML element into the selected position
 * 
 * @param node
 *            An HTML element which is gonna be inserted
 * @param containerNode
 *			  Container node for the HTML element be instered
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
 $(function(){
 	/*set year select list*/
 	$('select#year').each(function(){
		// current year
		var currentYear = 2015;
		// append year to select list
		for(var i = 0; i < 90; i++){
			var year = currentYear - i;
			$(this).append('<option value=\'' + year + '\'>'+year+'</option>');
		}
	});
 	/*set month select list*/
 	$('select#month').each(function(){
		// month array
		var monthArr = ['一','二','三','四','五','六','七','八','九','十','十一','十二'];
		// get this
		var element = $(this);
		// month num
		var month = 1;
		// append month to select list
		monthArr.forEach(function(entry){
			element.append('<option value=\'' + month + '\'>'+entry+'</option>');
			month++;
		});
	});
 	/*set date select list*/
 	$('select#date').each(function(){
		// number of dates per month
		var numOfDates = 31;
		// append date to select list
		for(var i = 1; i <= numOfDates ; i++){
			$(this).append('<option value=\'' + i + '\'>'+i+'</option>');
		}
	});
 	/*slide-toggle effect*/
	// configuration variable
	var toggleTimeDuration = 500;
	// event handler
	$("[data-toggle='slide']").each(function(){
		$(this).click(function(){
			var targetId = $(this).attr('data-target');
			var target = $(targetId);
			target.slideToggle(toggleTimeDuration);
		});
	});
});
