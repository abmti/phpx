
function ajaxPhpx(form, options) {
	if(options["status"]){
		$('#dialogAjaxStatus').dialog('open');
	}
	var url = $("#"+form).attr('action');
	var params = "faces_ajax=true";
	if(options["ajaxSingle"]){
		params += "&faces_ViewState=" + document.forms[form]["faces_ViewState"].value;
	} else {	
		params += "&" + $(document.forms[form].elements).serialize();
	} 
	var parameters = options['parameters'];
	if(parameters != null){
		for(key in parameters) {
			params += "&" + parameters[key] + "=" + document.getElementById(parameters[key]).value;
		}
	}
	params += "&" + options["parentId"] + "=ajaxSupport";
	//alert(url);
	//alert(params);
	jQuery.post(url, 
			params,
			function(data, textStatus, jqXHR){
		
				//var string = (new XMLSerializer()).serializeToString(data);
				//alert(string);
		
				var reRenders = options['update'];
				if(reRenders != null){
					for(key in reRenders) {
						var reRender = reRenders[key];
						$(data).find("#"+reRender).each(function (index, domEle) {
					        // domEle == this
							//alert($(domEle).attr('id'));
							//alert($(domEle).html());
							$(document).find('#'+reRender).html($(domEle).html());
					    });
					}
				}
                var onComplete = options['onComplete'];
                if(onComplete != null){
                	setTimeout(onComplete, 10);
                }
			},
			"xml")
			.fail(function(xhr, textStatus, error){
				console.log(xhr);
				console.log(textStatus);
				console.log(error);
			})
			.done(function(data, textStatus, xhr) { 
				//console.log(data);
				//console.log(textStatus);
				//console.log(xhr);
				if(options["status"]){
					$('#dialogAjaxStatus').dialog('close');
				}
				//$(document).find('script').each(function() {
				//	eval($(this).text());
				//});
			});
	
	return false;
}

function openWin(data) {
	popupWin = window.open('','_blank','nomenubar,notoolbar,nolocation,nodirectories,nostatus,dependent,alwaysRaised=yes,scrollbars=yes,height=600,width=800');
	popupWin.focus();
	popupWin.document.write(data);
}


