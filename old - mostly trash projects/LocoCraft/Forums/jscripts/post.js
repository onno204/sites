var Post = {
	init: function()
	{
		$(document).ready(function(){
		});
	},

	loadMultiQuoted: function()
	{
		if(use_xmlhttprequest == 1)
		{
			tid = document.input.tid.value;
			
			$.ajax(
			{
				url: 'xmlhttp.php?action=get_multiquoted&tid='+tid,
				type: 'get',
				complete: function (request, status)
				{
					Post.multiQuotedLoaded(request, status);
				}
			});
			
			return false;
		}
		else
		{
			return true;
		}
	},

	loadMultiQuotedAll: function()
	{
		if(use_xmlhttprequest == 1)
		{
			$.ajax(
			{
				url: 'xmlhttp.php?action=get_multiquoted&load_all=1',
				type: 'get',
				complete: function (request, status)
				{
					Post.multiQuotedLoaded(request, status);
				}
			});
			
			return false;
		}
		else
		{
			return true;
		}
	},

	multiQuotedLoaded: function(request)
	{
		var json = $.parseJSON(request.responseText);
		if(typeof response == 'object')
		{
			if(json.hasOwnProperty("errors"))
			{
				$.each(json.errors, function(i, message)
				{
					$.jGrowl(lang.post_fetch_error + ' ' + message, {theme:'jgrowl_error'});
				});
				return false;
			}
		}

		var id = 'message';
		if(typeof $('textarea').sceditor != 'undefined')
		{
			$('textarea').sceditor('instance').insert(json.message);
		}
		else
		{
			if($('#' + id).value)
			{
				$('#' + id).value += "\n";
			}
			$('#' + id).val($('#' + id).val() + json.message);
		}
		
		$('#multiquote_unloaded').hide();
		document.input.quoted_ids.value = 'all';
	},
	
	clearMultiQuoted: function()
	{
		$('#multiquote_unloaded').hide();
		Cookie.unset('multiquote');
	},
	
	removeAttachment: function(aid)
	{
		$.prompt(removeattach_confirm, {
			buttons:[
					{title: yes_confirm, value: true},
					{title: no_confirm, value: false}
			],
			submit: function(e,v,m,f){
				if(v == true)
				{
					document.input.attachmentaid.value = aid;
					document.input.attachmentact.value = "remove";
					
					$("input[name=rem]").parents('form').append('<input type="submit" id="rem_submit" class="hidden" />');
					$('#rem_submit').click();
				}
			}
		});
		
		return false;
	},

	attachmentAction: function(aid,action)
	{
		document.input.attachmentaid.value = aid;
		document.input.attachmentact.value = action;
	}
};

Post.init();