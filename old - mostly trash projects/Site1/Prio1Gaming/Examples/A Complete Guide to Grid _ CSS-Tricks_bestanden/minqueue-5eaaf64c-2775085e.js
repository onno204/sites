/*wp-polls, jetpack-live-comment-markdown, comment-reply, antispampro-script*/ var poll_id=0,poll_answer_id="",is_being_voted=!1;pollsL10n.show_loading=parseInt(pollsL10n.show_loading);pollsL10n.show_fading=parseInt(pollsL10n.show_fading);function poll_vote(b){jQuery(document).ready(function(a){is_being_voted?alert(pollsL10n.text_wait):(set_is_being_voted(!0),poll_id=b,poll_answer_id="",poll_multiple_ans_count=poll_multiple_ans=0,a("#poll_multiple_ans_"+poll_id).length&&(poll_multiple_ans=parseInt(a("#poll_multiple_ans_"+poll_id).val())),a("#polls_form_"+poll_id+" input:checkbox, #polls_form_"+poll_id+" input:radio, #polls_form_"+poll_id+" option").each(function(b){if(a(this).is(":checked")||a(this).is(":selected"))0<poll_multiple_ans?(poll_answer_id=a(this).val()+","+poll_answer_id,poll_multiple_ans_count++):poll_answer_id=parseInt(a(this).val())}),0<poll_multiple_ans?0<poll_multiple_ans_count&&poll_multiple_ans_count<=poll_multiple_ans?(poll_answer_id=poll_answer_id.substring(0,poll_answer_id.length-1),poll_process()):0==poll_multiple_ans_count?(set_is_being_voted(!1),alert(pollsL10n.text_valid)):(set_is_being_voted(!1),alert(pollsL10n.text_multiple+" "+poll_multiple_ans)):0<poll_answer_id?poll_process():(set_is_being_voted(!1),alert(pollsL10n.text_valid)))})}function poll_process(){jQuery(document).ready(function(b){poll_nonce=b("#poll_"+poll_id+"_nonce").val();pollsL10n.show_fading&&b("#polls-"+poll_id).fadeTo("def",0);pollsL10n.show_loading&&b("#polls-"+poll_id+"-loading").show();b.ajax({type:"POST",xhrFields:{withCredentials:!0},url:pollsL10n.ajax_url,data:"action=polls&view=process&poll_id="+poll_id+"&poll_"+poll_id+"="+poll_answer_id+"&poll_"+poll_id+"_nonce="+poll_nonce,cache:!1,success:poll_process_success})})}
function poll_result(b){jQuery(document).ready(function(a){is_being_voted?alert(pollsL10n.text_wait):(set_is_being_voted(!0),poll_id=b,poll_nonce=a("#poll_"+poll_id+"_nonce").val(),pollsL10n.show_fading&&a("#polls-"+poll_id).fadeTo("def",0),pollsL10n.show_loading&&a("#polls-"+poll_id+"-loading").show(),a.ajax({type:"POST",xhrFields:{withCredentials:!0},url:pollsL10n.ajax_url,data:"action=polls&view=result&poll_id="+poll_id+"&poll_"+poll_id+"_nonce="+poll_nonce,cache:!1,success:poll_process_success}))})}
function poll_booth(b){jQuery(document).ready(function(a){is_being_voted?alert(pollsL10n.text_wait):(set_is_being_voted(!0),poll_id=b,poll_nonce=a("#poll_"+poll_id+"_nonce").val(),pollsL10n.show_fading&&a("#polls-"+poll_id).fadeTo("def",0),pollsL10n.show_loading&&a("#polls-"+poll_id+"-loading").show(),a.ajax({type:"POST",xhrFields:{withCredentials:!0},url:pollsL10n.ajax_url,data:"action=polls&view=booth&poll_id="+poll_id+"&poll_"+poll_id+"_nonce="+poll_nonce,cache:!1,success:poll_process_success}))})}
function poll_process_success(b){jQuery(document).ready(function(a){a("#polls-"+poll_id).replaceWith(b);pollsL10n.show_loading&&a("#polls-"+poll_id+"-loading").hide();pollsL10n.show_fading&&a("#polls-"+poll_id).fadeTo("def",1);set_is_being_voted(!1)})}function set_is_being_voted(b){is_being_voted=b};;(function(window,$){'use strict';var jetpackLiveCommentMarkdownify=function(){var self=this,original_comment='',previewActive=false;self.init=function(){$("<div />",{'class':'preview-buttons','id':"preview-buttons",'html':'\
          <a href="#0" id="writeCommentButton" class="commentPreviewButton active">Write</a>\
          <a href="#0" id="previewCommentButton" class="commentPreviewButton">Preview</a>'}).insertAfter("#comment");$('<div />',{'id':"markdown_comment",'class':"comment-content markdown-comment-preview"}).insertAfter("#comment");$(".commentPreviewButton").on('click',self.tab);$("#previewCommentButton").on('click',self.serve);};self.serve=function(event){original_comment=$('#comment').val();if(previewActive){return false;}
$('#comment').hide();$('#markdown_comment').show().html('Combobulating comment preview...');$.post(markdownify.ajax_url,{action:'markdownify',nonce:markdownify.nonce,comment_content:original_comment},function(response){self.display(response);},'json');event.preventDefault();};self.tab=function(event){var clicked=$(this);if(!clicked.hasClass('active')){$('.commentPreviewButton').removeClass('active');clicked.addClass('active');if(this.id=='writeCommentButton'){$('#comment').val(original_comment).show();$('#markdown_comment').hide();previewActive=false;}}else{return;}
event.preventDefault();};self.display=function(response){if(response.success){$('#comment').hide();$('#markdown_comment').html(response.data).show();previewActive=true;}else{$('#comment').show();$('#markdown_comment').hide();}};$(function($){self.init();});}
window.jetpackLiveCommentMarkdownify=new jetpackLiveCommentMarkdownify();})(window,jQuery);;var addComment={moveForm:function(a,b,c,d){var e,f,g,h,i=this,j=i.I(a),k=i.I(c),l=i.I("cancel-comment-reply-link"),m=i.I("comment_parent"),n=i.I("comment_post_ID"),o=k.getElementsByTagName("form")[0];if(j&&k&&l&&m&&o){i.respondId=c,d=d||!1,i.I("wp-temp-form-div")||(e=document.createElement("div"),e.id="wp-temp-form-div",e.style.display="none",k.parentNode.insertBefore(e,k)),j.parentNode.insertBefore(k,j.nextSibling),n&&d&&(n.value=d),m.value=b,l.style.display="",l.onclick=function(){var a=addComment,b=a.I("wp-temp-form-div"),c=a.I(a.respondId);if(b&&c)return a.I("comment_parent").value="0",b.parentNode.insertBefore(c,b),b.parentNode.removeChild(b),this.style.display="none",this.onclick=null,!1};try{for(var p=0;p<o.elements.length;p++)if(f=o.elements[p],h=!1,"getComputedStyle"in window?g=window.getComputedStyle(f):document.documentElement.currentStyle&&(g=f.currentStyle),(f.offsetWidth<=0&&f.offsetHeight<=0||"hidden"===g.visibility)&&(h=!0),"hidden"!==f.type&&!f.disabled&&!h){f.focus();break}}catch(q){}return!1}},I:function(a){return document.getElementById(a)}};;(function($){function anti_spam_pro_init(){$('.antispam-group').hide();var answer=$('.antispam-group .antispam-control-a').val();$('.antispam-group-q .antispam-control-q').val(answer);$('.antispam-group-e .antispam-control-e').val('');var dynamic_control='<input type="hidden" name="antspmpro-q-'+antispampro_vars.input_name_suffix+'" class="antispam-control antispam-control-q" value="'+antispampro_vars.code+'" />';$.each($('#comments form'),function(index,commentForm){if($(commentForm).find('.antispam-control-q').length==0){$(commentForm).append(dynamic_control);}});$.each($('#respond form'),function(index,commentForm){if($(commentForm).find('.antispam-control-q').length==0){$(commentForm).append(dynamic_control);}});$.each($('form#commentform'),function(index,commentForm){if($(commentForm).find('.antispam-control-q').length==0){$(commentForm).append(dynamic_control);}});}
$(document).ready(function(){anti_spam_pro_init();});$(document).ajaxSuccess(function(){anti_spam_pro_init();});})(jQuery);