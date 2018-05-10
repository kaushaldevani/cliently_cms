

var chunks = [];
var main_url = "http://wpstaging.cliently.io/cliently_cms";
var autho_img__url = '~/../uploads/Images/';
$( document ).ready(function() {


	$('#mainAddActionLink').click(function(){


		// open modal Window as per selction in drop down
		if($("#action_selector").val()!= null && $("#action_selector").val()!= undefined)
		{
			$('#' + $("#action_selector").val()).trigger('click');

			switch($("#action_selector").val())
			{
				case "email_opener" :
			         $('#work-pane-email-send').find('.btn-save').css('display','none');
			         $('#work-pane-email-send').find('.btn-add').css('display','inline-block');
				     break;
				case "wait_opener":
					 $('#work-pane-event-time-delay').find('.btn-save').css('display','none');
					 $('#work-pane-event-time-delay').find('.btn-add').css('display','inline-block');
			     break;
				case "video_opener":
					 $('#work-pane-email-video').find('.btn-save').css('display','none');
					 $('#work-pane-email-video').find('.btn-add').css('display','inline-block');
					 initializeVideo()
			     break;
				case "post_card_opener":
					 $('#work-pane-postcard').find('.btn-save').css('display','none');
					 $('#work-pane-postcard').find('.btn-add').css('display','inline-block');
			     break;
				case "handwritten_note_opener" :
					$('#handwritten_notes').find('.btn-save').css('display','none');
					$('#handwritten_notes').find('.btn-add').css('display','inline-block');
			     break;
				case "gift_opener" :
					$('#gifting').find('.btn-save').css('display','none');
					$('#gifting').find('.btn-add').css('display','inline-block');
			     break;
				case "linkedin_opener" :
					$('#linkedin').find('.btn-save').css('display','none');
					$('#linkedin').find('.btn-add').css('display','inline-block');
			     break;
				case "twitter_opener" :
					$('#twitter-follow').find('.btn-save').css('display','none');
					$('#twitter-follow').find('.btn-add').css('display','inline-block');
			     break;

			}
		}

	});

	$("#connect_or_inmail_linkedin").change(function(){

		if($(this).val() == "INMAIL")
		{
			$("#linkedin_inmail_subject").css("display","block");
		}
		else
		{
			$("#linkedin_inmail_subject").css("display","none");
		}
	});

	var editor_video = new wysihtml5.Editor("editor", { // id of textarea element
		  toolbar:      "editor-toolbar", // id of toolbar element
		  parserRules:  wysihtml5ParserRules, // defined in parser rules set
		  style:        true,
		  composerClassName:  "wysihtml5-editor-for-email",// Class name which should be set on the contentEditable element in the created sandbox iframe, can be styled via the 'stylesheets' option
		  bodyClassName:      "wysihtml5-supported-email", // Class name to add to the body when the wysihtml5 editor is supported
		  stylesheets: "css/add.css"

	});

	var editor_video = new wysihtml5.Editor("editor-for-video-Email", { // id of textarea element
		  toolbar:      "editor-toolbar-2", // id of toolbar element
		  parserRules:  wysihtml5ParserRules, // defined in parser rules set
		  style:        true,
		  composerClassName:  "wysihtml5-editor-for-video-email",// Class name which should be set on the contentEditable element in the created sandbox iframe, can be styled via the 'stylesheets' option
		  bodyClassName:      "wysihtml5-supported-for-video-email", // Class name to add to the body when the wysihtml5 editor is supported
		  stylesheets: "css/add.css"
	});

	var editor_video = new wysihtml5.Editor("editor-toolbar-for-tips", { // id of textarea element
		  toolbar:      "editor-toolbar-3", // id of toolbar element
		  parserRules:  wysihtml5ParserRules, // defined in parser rules set
		  style:        true,
		  composerClassName:  "wysihtml5-editor-for-tips",// Class name which should be set on the contentEditable element in the created sandbox iframe, can be styled via the 'stylesheets' option
		  bodyClassName:      "wysihtml5-supported-tips", // Class name to add to the body when the wysihtml5 editor is supported
		  stylesheets: "css/add.css"

	});


	 $('.btn-toolbar > .token-dropdown > ul > li > a').click(function(event){


	    	$(this).closest('.work-creation-wizard-step').find('div.token-dropdown').removeClass('open');
	    	$(this).closest('.work-creation-wizard-step').find('a.dropdown-toggle btn-xs').attr('aria-expanded',false);
	    	var step = $(this).closest('.work-creation-wizard-step').attr('data-step');
	    	insertAtCursor('wysihtml5-sandbox' , "{" + $(this).attr('data-token') +"}", null, step );
	        event.stopPropagation();
	        event.preventDefault();

	    });

	    $('div').on('click','.tkn-drp-subject > ul > li >a',function(event){

	    	$(this).closest('.work-creation-wizard-step').find('div.token-dropdown').removeClass('open');
	    	$(this).closest('.work-creation-wizard-step').find('a.dropdown-toggle btn-xs').attr('aria-expanded',false);
	    	var caretPos = $(this).closest('.work-creation-wizard-step').find('input.email-sub')[0].selectionStart;
	        var textAreaTxt =  $(this).closest('.work-creation-wizard-step').find('input.email-sub').val();
	        var txtToAdd = "{" + $(this).attr('data-token') +"}";
	        $(this).closest('.work-creation-wizard-step').find('input.email-sub').val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
	    	event.stopPropagation();
	        event.preventDefault();

	    });

	    $('ul.dropdown-menu-right > li > a').click(function(event){

	    	$(this).closest('.work-creation-wizard-step').find('div.token-dropdown').removeClass('open');
	    	$(this).closest('.work-creation-wizard-step').find('a.dropdown-toggle btn-xs').attr('aria-expanded',false);
	    	var caretPos = document.getElementById("postcard_message").selectionStart;
	        var textAreaTxt = jQuery("#postcard_message").val();
	        var txtToAdd = "{" + $(this).attr('data-token') +"}";
	        jQuery("#postcard_message").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
	        textareaLineCountResize(document.getElementById("postcard_message"), 8, 20);
	    	event.stopPropagation();
	        event.preventDefault();
	    });

	    $('input.email-sub').focus(function(event){

	    	if(!$(this).parent('span#email-sub-spn').has('div.tkn-drp-subject').length > 0)
	    	{
	    		$(this).after('<div style="background-color: white;" class="btn-toolbar tkn-drp-subject btn-group dropdown token-dropdown" > <a class="btn dropdown-toggle btn-xs" title="Insert Token" data-toggle="dropdown">{-}</a><ul class="dropdown-menu drp-token-email-sub" role="menu"><li role="presentation"><a data-token="MySignature" href="#MySignature">My Signature</a></li><li role="presentation"><a data-token="MyFirstName" href="#MyFirstName">My First Name</a></li><li role="presentation"><a data-token="MyLastName" href="#MyLastName">My Last Name</a></li><li role="presentation"><a data-token="FirstName" href="#FirstName">First Name</a></li><li role="presentation"><a data-token="LastName" href="#LastName">Last Name</a></li><li role="presentation"><a data-token="FullName" href="#FullName">Full Name</a></li><li role="presentation"><a data-token="CompanyName" href="#CompanyName">Company Name</a></li><li role="presentation"><a data-token="JobTitle" href="#JobTitle">Job Title</a></li><li role="presentation"><a data-token="StreetAddress" href="#StreetAddress">Street Address</a></li><li role="presentation"><a data-token="City" href="#City">City</a></li><li role="presentation"><a data-token="State" href="#State">State</a></li><li role="presentation"><a data-token="ZipCode" href="#ZipCode">Zip Code</a></li></ul></div>');
	    	}

	    });

	    $('input.email-sub').blur( function(event) {

	        $obj= $(this)
	    	setTimeout(function() {
	    		if(document.activeElement.tagName == 'IFRAME' && document.activeElement.className == 'wysihtml5-sandbox')
	    		{
	    			$obj.parent('span').find('div.tkn-drp-subject').remove();
	    		}
	    	}, 50);

	    });


	    $('#postcard_message').keypress(function (event) {
	        var textarea = $(this),
	            text = textarea.val(),
	            numberOfLines = (text.match(/\n/g) || []).length + 1,
	            maxRows = 10;

	        if (event.which === 13 && numberOfLines === maxRows ) {

	        	alert("You have reached the limit to the number of lines you are allowed.");
	        	return false;
	        }
	    });


	    $('div.card-message').on('input', '#postcard_message', function(e) {
	        textareaLineCountResize(this, 8, 20);
	    });



	    function textareaLineCountResize (element, limit, lineHeight) {
	        var carretPos = element.selectionStart;
	        element.style.height = lineHeight + 'px';
	        var lineCount = Math.round(element.scrollHeight / lineHeight);
	        if (lineCount > limit) {
	            var prevValue = $(element).data('prev-value');
	            var prevCarretPos = $(element).data('prev-carret-pos');
	            if (prevValue != null) {
	                if (element.value === prevValue) {
	                    element.value = '';
	                } else {
	                    element.value = prevValue;
	                    element.value = prevValue;
	                }
	            }
	            element.style.height = limit * lineHeight + 'px';
	            element.selectionStart = prevCarretPos;
	            element.selectionEnd = prevCarretPos;
	        } else {
	            element.style.height = lineCount * lineHeight + 'px';
	            $(element).data('prev-value', element.value);
	            $(element).data('prev-carret-pos', carretPos);
	        }
	    }



	   function insertAtCursor(iframename, text, replaceContents,step) {
	       var modal = '';
		   if(replaceContents==null)
	        {
	        	replaceContents=false;
	        }
	        if(step == 'work-pane-email-send')
	        {
	        	modal = 'work-creation-wizard-step-work-pane-email-send';
	        }
	        else if(step == 'work-pane-email-video')
	        {
	        	modal = 'work-creation-wizard-step-work-pane-email-video';
	        }
	        else if (step == 'work-pane-tips')
	        {
	        	modal = 'work-pane-tips';
	        }

	        if(!replaceContents) //collapse selection:
	        {
	        	var sel = $('#'+modal).find('iframe.'+iframename)[0].contentWindow.getSelection();
	            sel.collapseToStart()
	        }
	        $('#'+modal).find('iframe.'+iframename)[0].contentWindow.document.execCommand('insertHTML', false, text);
	  };

	$("#sim_camp_add_link").click(function(){


		addDiv = $(".similar_campaigns_template").clone(true,true);
		$(addDiv).removeClass('similar_campaigns_template');
		$(addDiv).addClass('similar_campaigns');
		$(addDiv).css('display','inline-block');

		var position = $(".similar_campaigns_template").parent().children('.similar_campaigns').length;
		$(addDiv).attr('position',position + 1);


		$('.sim_camp').append(addDiv);

	});

	$('.sim_camp_delete').click(function(){

		var parent =$(this).parent();
		$(parent).nextAll('div.similar_campaigns').each(function(){

			$(this).attr('position', $(this).attr('position') - 1);

		});
		$(this).parent('div').remove();
	});

	// onDelete action
	$('.delete_action').click(function(){


		var parent =$(this).parent().parent('.action-in-flow');
		$(parent).nextAll('div.action-in-flow').each(function(){

			$(this).find('.action-details > .action-name').text('STEP ' + ($(this).attr('position') - 1) + ' - ' + $(this).attr('action_class'));
			$(this).attr('position', $(this).attr('position') - 1);



		});
		$(this).parent().parent('div.action-in-flow').remove();
	});


	$("#front_img_btn").click(function(event){

		event.stopPropagation();
        event.preventDefault();
		$('#postcard_front_img_input').trigger('click');
	});
	$("#back_img_btn").click(function(event){

		event.stopPropagation();
        event.preventDefault();
		$('#postcard_back_img_input').trigger('click');
	});

	$("#gifting_img_btn").click(function(event){

		event.stopPropagation();
        event.preventDefault();
		$('#gifting_img_input').trigger('click');
	});

	$("#postcard_front_img_input").change(function(){
		readURL(this,'front');
	});
	$("#postcard_back_img_input").change(function(){
		readURL(this,'back');
	});

	$("#author_img_input").change(function(){
		readURL(this,'auth_img');
	});
	$("#gifting_img_input").change(function(){
		readURL(this,'gifting');
	});


	function readURL(input , bywhom)
	{
        if (input.files && input.files[0])
        {
            var reader = new FileReader();

            reader.onload = function (e) {
            	switch (bywhom)
        		{
	            	case "auth_img":
	            		 $('#author_img').attr('src', e.target.result);
	            		 break;
	            	case "front":
	            		 $('#postcard_front_img').attr('src', e.target.result);
	            		 break;
	            	case "back":
	            		 $('#postcard_back_img').attr('src', e.target.result);
	            		 break;
	            	case "video_action":
	            		 $('#video_email_video').attr('src', e.target.result);
	            		 break;
	            	case "gifting":
	            		 $('#gifting_img').attr('src', e.target.result);
	            		 break;
	            	default:

        		}

            };

            reader.readAsDataURL(input.files[0]);
        }
    }
	$('.modal-footer > button.btn-save').click(function(){

	   var action_name = $($(this).closest('.modal-dialog').parent()).attr('id');

	   if(action_name != 'work-pane-tips')
	   {
		var update_at = $($(this).closest('.modal-dialog').parent()).attr('update_at')
	    var position = update_at.substring(update_at.lastIndexOf("_")+1);
		action_detail ='';

		 updateDiv = $('div.action-in-flow[position ="'+ position +'"]');
		 switch (action_name)
			{
		       	case "work-pane-email-send":

					  action_detail= $(this).closest('.modal-dialog').find('input.email-sub').val() ;
					  $(updateDiv).find('div.hidden_data_for_action > textarea.email_body ').val($(this).closest('.modal-dialog').find('textarea#editor').val());
					  $(updateDiv).find('div.hidden_data_for_action > input.email_sub ').val(action_detail);

		       		  break;

		       	case "work-pane-event-time-delay":

					  action_detail="Wait " + $('input#wait_day').val() +' Days' ;
					  $(updateDiv).find('div.hidden_data_for_action > input.days_val ').val($('input#wait_day').val());
					  $(updateDiv).find('div.hidden_data_for_action > input.only_weekend_check ').val($('input[name=only_weekend]:checked').val());

		       		  break;
		    	case "work-pane-email-video":

					  action_detail= $(this).closest('.modal-dialog').find('input.email-sub').val() ;
					  $(updateDiv).find('div.hidden_data_for_action > input.video_email_sub').val(action_detail);
					  $(updateDiv).find('div.hidden_data_for_action > textarea.videoemail_body').val($(this).closest('.modal-dialog').find('textarea#editor-for-video-Email').val());
					  var video_name = $(updateDiv).find('div.hidden_data_for_action > input.video_email_name').val();
					  var video_src =  $(this).closest('.modal-dialog').find('#video_email_video').attr('src');
					  if(video_name != video_src.substring(video_src.lastIndexOf('/')+1))
					  {
						  var video_actual_name = uploadVideo();
						  if(video_actual_name != '' && video_actual_name != false	 )
						  {
							  $(updateDiv).find('div.hidden_data_for_action > input.video_email_name').val(video_actual_name)
						  }
						  else
						  {
							  alert('Something went wrong while saving Video')
							  return "";
						  }
					  }
					  break;

		    	case "work-pane-postcard":

				      action_detail = "Templated Design";

					  var front_image = uploadPostCardImage('front');
		    		  var back_image = uploadPostCardImage('back');
		    		  if(front_image != '' && front_image != false  && back_image != '' && back_image != false )
		    		  {
		    			  $(updateDiv).find('div.hidden_data_for_action > input.frnt_img').val(front_image);
					      $(updateDiv).find('div.hidden_data_for_action > input.bck_img').val(back_image);
						  $(updateDiv).find('div.hidden_data_for_action > textarea.postcard_msg').val($(this).closest('.modal-dialog').find("#message_for_postcard").val());

						  $(updateDiv).find('div.hidden_data_for_action > input.to_fullname').val($(this).closest('.modal-dialog').find("#to_full_name").val());
						  $(updateDiv).find('div.hidden_data_for_action > input.to_companyname').val($(this).closest('.modal-dialog').find("#to_company").val());
						  $(updateDiv).find('div.hidden_data_for_action > input.to_line1').val($(this).closest('.modal-dialog').find("#to_line1").val());
						  $(updateDiv).find('div.hidden_data_for_action > input.to_line2').val($(this).closest('.modal-dialog').find("#to_line2").val());

						  $(updateDiv).find('div.hidden_data_for_action > input.from_fullname').val($(this).closest('.modal-dialog').find("#from_full_name").val());
						  $(updateDiv).find('div.hidden_data_for_action > input.from_companyname').val($(this).closest('.modal-dialog').find("#from_company").val());
						  $(updateDiv).find('div.hidden_data_for_action > input.from_line1').val($(this).closest('.modal-dialog').find("#from_line1").val());
						  $(updateDiv).find('div.hidden_data_for_action > input.from_line2').val($(this).closest('.modal-dialog').find("#from_line2").val());

		    		  }
		    		  else
		    		  {
		    			  return false;
		    		  }



		       		  break;
		    	case "handwritten_notes":

				      action_detail = "Notes"

                      $(updateDiv).find('div.hidden_data_for_action > textarea.hwnote_msg').val($(this).closest('.modal-dialog').find("#message_for_handWrittent_note").val());

                      $(updateDiv).find('div.hidden_data_for_action > input.hdnote_script').val($(this).closest('.modal-dialog').find("#script_for_handWrittent_note").val());
                      $(updateDiv).find('div.hidden_data_for_action > input.hdnote_ink_color').val($(this).closest('.modal-dialog').find("#ink_color_for_handWrittent_note").val());
                      $(updateDiv).find('div.hidden_data_for_action > input.hdnote_envelop_ink_color').val($(this).closest('.modal-dialog').find("#envelop_ink_color_for_handWrittent_note").val());

					  $(updateDiv).find('div.hidden_data_for_action > input.hwnote_to_fullname').val($(this).closest('.modal-dialog').find("#to_full_name").val());
					  $(updateDiv).find('div.hidden_data_for_action > input.hwnote_to_companyname').val($(this).closest('.modal-dialog').find("#to_company").val());
					  $(updateDiv).find('div.hidden_data_for_action > input.hwnote_to_line1').val($(this).closest('.modal-dialog').find("#to_line1").val());
					  $(updateDiv).find('div.hidden_data_for_action > input.hwnote_to_line2').val($(this).closest('.modal-dialog').find("#to_line2").val());

					  $(updateDiv).find('div.hidden_data_for_action > input.hwnote_from_fullname').val($(this).closest('.modal-dialog').find("#from_full_name").val());
					  $(updateDiv).find('div.hidden_data_for_action > input.hwnote_from_companyname').val($(this).closest('.modal-dialog').find("#from_company").val());
					  $(updateDiv).find('div.hidden_data_for_action > input.hwnote_from_line1').val($(this).closest('.modal-dialog').find("#from_line1").val());
					  $(updateDiv).find('div.hidden_data_for_action > input.hwnote_from_line2').val($(this).closest('.modal-dialog').find("#from_line2").val());

		       		  break;

		    	case "gifting":

				      action_detail = "GIFT";

				      var gift_image = uploadGiftImage();
		    		  if(gift_image != '' && gift_image != false  && gift_image != '' && gift_image != false )
		    		  {

		    			  $(updateDiv).find('div.hidden_data_for_action > input.gifting_image').val(gift_image);
					      $(updateDiv).find('div.hidden_data_for_action > textarea.gift_msg').val($(this).closest('.modal-dialog').find("#message_for_gifting").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_script').val($(this).closest('.modal-dialog').find("#script_for_gifting").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_ink_color').val($(this).closest('.modal-dialog').find("#ink_color_for_gifting").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.gift_card_script').val($(this).closest('.modal-dialog').find("#gift_card").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.ammount_for_gifting').val($(this).closest('.modal-dialog').find("#ammount_for_gifting").val());

	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_to_fullname').val($(this).closest('.modal-dialog').find("#to_full_name").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_to_companyname').val($(this).closest('.modal-dialog').find("#to_company").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_to_line1').val($(this).closest('.modal-dialog').find("#to_line1").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_to_line2').val($(this).closest('.modal-dialog').find("#to_line2").val());

	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_from_fullname').val($(this).closest('.modal-dialog').find("#from_full_name").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_from_companyname').val($(this).closest('.modal-dialog').find("#from_company").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_from_line1').val($(this).closest('.modal-dialog').find("#from_line1").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_from_line2').val($(this).closest('.modal-dialog').find("#from_line2").val());
	                      $(updateDiv).find('div.hidden_data_for_action > input.gifting_envelop_ink_color').val($(this).closest('.modal-dialog').find("#envelop_ink_color_for_gifting").val());
		    		  }
		    		  else
		    		  {
		    			  return false;
		    		  }

		       		  break;

		    	case "linkedin":

			   		  var type ='';

			   	      if($(this).closest('.modal-dialog').find("#connect_or_inmail_linkedin").val() =='INMAIL')
			   	      {
			   	    	  action_detail =  $(this).closest('.modal-dialog').find('#linkedin_inmail_subject').val();
			   	    	  type ='INMAIL';
			   	      }
			   	      else
			   	      {
			   	    	  action_detail =  'CONNECT';
			   	    	  type ='CONNECT';
			   	      }

			   	      if(type == 'INMAIL')
			   	      {
			   	    	  $(updateDiv).find('div.hidden_data_for_action > input.linedinmailsub').val(action_detail);
			   	      }
			   	      else
			   	      {
			   	    	   $(updateDiv).find('div.hidden_data_for_action > input.linedinmailsub').val('');
			   	      }

	                  $(updateDiv).find('div.hidden_data_for_action > input.linkedin_type').val(type);
	                  $(updateDiv).find('div.hidden_data_for_action > textarea.linkedin_msg').val($(this).closest('.modal-dialog').find('#message_for_linkedin').val());

		   		      break;

		   case "twitter-follow":

			     action_detail=$('input[name=radio_twitter]:checked').val();
		   	     $(updateDiv).find('div.hidden_data_for_action > input.follow_unfollow').val(action_detail);

		   		 break;
		   	default:

			}

		     $(updateDiv).find('.action-detail').text(action_detail);

	     }
		 $(this).closest('.modal-dialog').find('.close').trigger('click');


	});

	$('.modal-footer > button.btn-add').click(function(){

	   var action_name = $($(this).closest('.modal-dialog').parent()).attr('id');
	   if(action_name != 'work-pane-tips')
	   {
		   var addDiv, stepname ,imgpath ,action_detail;

		   addDiv = $('div#action_template > div.action-in-flow').clone(true, true);
		   var index = $(".flow-action").children().not('#action_template').length;
		   action_position =index +1;


		   switch (action_name)
			{
		       	case "work-pane-email-send":

		       		  stepname = 'EMAIL';
					  imgpath  = "~/../images/email.svg";
					  action_detail= $(this).closest('.modal-dialog').find('input.email-sub').val() ;
					  var msg_body =  $('<textarea class="email_body" />');
					  var email_sub = $('<input class="email_sub" />');
					  msg_body.val($(this).closest('.modal-dialog').find('textarea#editor').val());
					  email_sub.val(action_detail);
		       		  $(addDiv).find('.hidden_data_for_action').append(msg_body, email_sub);

		       		  break;

		       	case "work-pane-event-time-delay":


		       		  stepname = 'WAIT';
		       		  imgpath  = "~/../images/wait.svg";
					  action_detail="Wait " + $('input#wait_day').val() +' Days' ;
					  var only_weekend = $('<input class="only_weekend_check" />');
					  var days_val = $('<input class="days_val" />');
					  only_weekend.val( $('input[name=only_weekend]:checked').val());
					  days_val.val($('input#wait_day').val());
					  $(addDiv).find('.hidden_data_for_action').append(only_weekend,days_val);

		       		  break;
		    	case "work-pane-email-video":

		    		  var video_actual_name = uploadVideo();
					  if(video_actual_name != '' && video_actual_name != false	 )
					  {
			    		  stepname = 'VIDEO-MESSAGE';
						  imgpath  = "~/../images/videomessage.svg";
						  action_detail= $(this).closest('.modal-dialog').find('input.email-sub').val() ;
						  var video_msg_body =  $('<textarea class="videoemail_body" />');
						  var video_email_sub = $('<input class="video_email_sub" />');
						  video_msg_body.val($(this).closest('.modal-dialog').find('textarea#editor-for-video-Email').val());
						  video_email_sub.val(action_detail);
						  var video_name = $('<input class="video_email_name" />');
						  video_name.val(video_actual_name);

						  $(addDiv).find('.hidden_data_for_action').append(video_email_sub,video_name,video_msg_body);

					  }
					  else
					  {
						  return false;
					  }
		       		  break;

		    	case "work-pane-postcard":

		    		  var front_image = uploadPostCardImage('front');
		    		  var back_image = uploadPostCardImage('back');
		    		  if(front_image != '' && front_image != false  && back_image != '' && back_image != false )
		    		  {
		    			  stepname = 'POSTCARD';
					      imgpath  = "~/../images/postcard.svg";
					      action_detail = "Templated Design"
						  var postcard_msg =  $('<textarea class="postcard_msg" />');
					      var frnt_img =  $('<input class="frnt_img" />');
					      var bck_img =  $('<input class="bck_img" />');
					      var to_fullname =  $('<input class="to_fullname" />');
					      var to_companyname =  $('<input class="to_companyname" />');
					      var to_line1 =  $('<input class="to_line1" />');
					      var to_line2 =  $('<input class="to_line2" />');
					      var from_fullname =  $('<input class="from_fullname" />');
					      var from_companyname =  $('<input class="from_companyname" />');
					      var from_line1 =  $('<input class="from_line1" />');
					      var from_line2 =  $('<input class="from_line2" />');


					      postcard_msg.val($(this).closest('.modal-dialog').find("#message_for_postcard").val());
					      frnt_img.val(front_image);
					      bck_img.val(back_image);
					      to_fullname.val($(this).closest('.modal-dialog').find("#to_full_name").val());
					      to_companyname.val($(this).closest('.modal-dialog').find("#to_company").val());
					      to_line1.val($(this).closest('.modal-dialog').find("#to_line1").val());
					      to_line2.val($(this).closest('.modal-dialog').find("#to_line2").val());


					      from_fullname.val($(this).closest('.modal-dialog').find("#from_full_name").val());
					      from_companyname.val($(this).closest('.modal-dialog').find("#from_company").val());
					      from_line1.val($(this).closest('.modal-dialog').find("#from_line1").val());
					      from_line2.val($(this).closest('.modal-dialog').find("#from_line2").val());

						  $(addDiv).find('.hidden_data_for_action').append(postcard_msg,frnt_img , bck_img,to_fullname,to_companyname,to_line1,to_line2,from_fullname,from_companyname,from_line1,from_line2);

		    		  }
		    		  else
		    		  {

		    			  return false;
		    		  }


		       		  break;
		    	case "handwritten_notes":

		    		  stepname = 'Handwritten_Notes';
				      imgpath  = "~/../images/hwnote.svg";
				      action_detail = "Notes"
					  var hwnote_msg =  $('<textarea class="hwnote_msg" />');
				      var hdnote_script = $('<input class="hdnote_script" />');
				      var hdnote_ink_color = $('<input class="hdnote_ink_color" />');

				      var hwnote_to_fullname =  $('<input class="hwnote_to_fullname" />');
				      var hwnote_to_companyname =  $('<input class="hwnote_to_companyname" />');
				      var hwnote_to_line1 =  $('<input class="hwnote_to_line1" />');
				      var hwnote_to_line2 =  $('<input class="hwnote_to_line2" />');
				      var hwnote_from_fullname =  $('<input class="hwnote_from_fullname" />');
				      var hwnote_from_companyname =  $('<input class="hwnote_from_companyname" />');
				      var hwnote_from_line1 =  $('<input class="hwnote_from_line1" />');
				      var hwnote_from_line2 =  $('<input class="hwnote_from_line2" />');

				      var hdnote_envelop_ink_color = $('<input class="hdnote_envelop_ink_color" />');

				      hwnote_msg.val($(this).closest('.modal-dialog').find("#message_for_handWrittent_note").val());
				      hdnote_script.val($(this).closest('.modal-dialog').find("#script_for_handWrittent_note").val());
				      hdnote_ink_color.val($(this).closest('.modal-dialog').find("#ink_color_for_handWrittent_note").val());


				      hwnote_to_fullname.val($(this).closest('.modal-dialog').find("#to_full_name").val());
				      hwnote_to_companyname.val($(this).closest('.modal-dialog').find("#to_company").val());
				      hwnote_to_line1.val($(this).closest('.modal-dialog').find("#to_line1").val());
				      hwnote_to_line2.val($(this).closest('.modal-dialog').find("#to_line2").val());


				      hwnote_from_fullname.val($(this).closest('.modal-dialog').find("#from_full_name").val());
				      hwnote_from_companyname.val($(this).closest('.modal-dialog').find("#from_company").val());
				      hwnote_from_line1.val($(this).closest('.modal-dialog').find("#from_line1").val());
				      hwnote_from_line2.val($(this).closest('.modal-dialog').find("#from_line2").val());

				      hdnote_envelop_ink_color.val($(this).closest('.modal-dialog').find("#envelop_ink_color_for_handWrittent_note").val());

					  $(addDiv).find('.hidden_data_for_action').append(hwnote_msg, hdnote_script ,hdnote_ink_color,hdnote_envelop_ink_color, hwnote_to_fullname,hwnote_to_companyname,hwnote_to_line1,hwnote_to_line2,hwnote_from_fullname,hwnote_from_companyname,hwnote_from_line1,hwnote_from_line2);

		       		  break;

		    	case "gifting":

		    		  stepname = 'Gifting';
				      imgpath  = "~/../images/gift.svg";
				      action_detail = "GIFT";


			    	  var gift_image = uploadGiftImage();
		    		  if(gift_image != '' && gift_image != false  && gift_image != '' && gift_image != false )
		    		  {

		    			  var gifting_image =  $('<input class="gifting_image" />');
		    			  var gift_card_script = $('<input class="gift_card_script" />');
					      var ammount_for_gifting = $('<input class="ammount_for_gifting" />');

					      var gift_msg =  $('<textarea class="gift_msg" />');
					      var gifting_script = $('<input class="gifting_script" />');
					      var gifting_ink_color = $('<input class="gifting_ink_color" />');

					      var gifting_to_fullname =  $('<input class="gifting_to_fullname" />');
					      var gifting_to_companyname =  $('<input class="gifting_to_companyname" />');
					      var gifting_to_line1 =  $('<input class="gifting_to_line1" />');
					      var gifting_to_line2 =  $('<input class="gifting_to_line2" />');
					      var gifting_from_fullname =  $('<input class="gifting_from_fullname" />');
					      var gifting_from_companyname =  $('<input class="gifting_from_companyname" />');
					      var gifting_from_line1 =  $('<input class="gifting_from_line1" />');
					      var gifting_from_line2 =  $('<input class="gifting_from_line2" />');

					      var gifting_envelop_ink_color = $('<input class="gifting_envelop_ink_color" />');


					      gifting_image.val(gift_image);

					      gift_card_script.val($(this).closest('.modal-dialog').find("#gift_card").val());
					      ammount_for_gifting.val($(this).closest('.modal-dialog').find("#ammount_for_gifting").val())

					      gift_msg.val($(this).closest('.modal-dialog').find("#message_for_gifting").val());
					      gifting_script.val($(this).closest('.modal-dialog').find("#script_for_gifting").val());
					      gifting_ink_color.val($(this).closest('.modal-dialog').find("#ink_color_for_gifting").val());


					      gifting_to_fullname.val($(this).closest('.modal-dialog').find("#to_full_name").val());
					      gifting_to_companyname.val($(this).closest('.modal-dialog').find("#to_company").val());
					      gifting_to_line1.val($(this).closest('.modal-dialog').find("#to_line1").val());
					      gifting_to_line2.val($(this).closest('.modal-dialog').find("#to_line2").val());


					      gifting_from_fullname.val($(this).closest('.modal-dialog').find("#from_full_name").val());
					      gifting_from_companyname.val($(this).closest('.modal-dialog').find("#from_company").val());
					      gifting_from_line1.val($(this).closest('.modal-dialog').find("#from_line1").val());
					      gifting_from_line2.val($(this).closest('.modal-dialog').find("#from_line2").val());

					      gifting_envelop_ink_color.val($(this).closest('.modal-dialog').find("#envelop_ink_color_for_gifting").val());

						  $(addDiv).find('.hidden_data_for_action').append(gifting_image,gift_card_script,ammount_for_gifting,gift_msg,gifting_script,gifting_ink_color,gifting_to_fullname,gifting_to_companyname,gifting_to_line1,gifting_to_line2,gifting_from_fullname,gifting_from_companyname,gifting_from_line1,gifting_from_line2,gifting_envelop_ink_color);
		    		  }

		    		  else
		    		  {
		    			  return false;
		    		  }
		       		  break;

		   case "linkedin":

		   		  var type ='';
		   		  stepname = 'LinkedIn';
		   	      imgpath  = "~/../images/linkedin.svg";

		   	      if($(this).closest('.modal-dialog').find("#connect_or_inmail_linkedin").val() =='INMAIL')
		   	      {
		   	    	  action_detail =  $(this).closest('.modal-dialog').find('#linkedin_inmail_subject').val();
		   	    	  type ='INMAIL';
		   	      }
		   	      else
		   	      {
		   	    	  action_detail =  'CONNECT';
		   	    	  type ='CONNECT';
		   	      }
		   	       var linedinmailsub = $('<input class="linedinmailsub" />');
		   	       var linkedin_type = $('<input class="linkedin_type" />');
		   	       var linkedin_msg = $('<textarea class="linkedin_msg" />');

		   	       linkedin_type.val(type);
		   	       linkedin_msg.val($(this).closest('.modal-dialog').find('#message_for_linkedin').val());
		   	       if(type == 'INMAIL')
		   	       {
		   	    	   linedinmailsub.val(action_detail);
		   	       }
		   	       else
		   	       {
		   	    	   linedinmailsub.val('');
		   	       }
		   	      $(addDiv).find('.hidden_data_for_action').append(linkedin_type,linkedin_msg,linedinmailsub);

		   		break;

		   case "twitter-follow":

			     stepname = 'TWITTER';
				 imgpath  = "~/../images/twitter.svg";
			     action_detail=$('input[name=radio_twitter]:checked').val();

				 var follow_unfollow = $('<input class="follow_unfollow" />');
				 follow_unfollow.val(action_detail);

		   	     $(addDiv).find('.hidden_data_for_action').append(follow_unfollow);

		   		break;


		       	default:

			}

		   $(addDiv).find('div.action-flow-image >img').attr('src',imgpath);
		   $(addDiv).find('div.action-details >  div.action-name').text('STEP ' + (index + 1) +' - '+stepname);
		   $(addDiv).find('div.action-details >  div.action-detail').text(action_detail);
		   $(addDiv).attr('action_class', stepname );
		   $(addDiv).attr('position', action_position);
		   $(".flow-action").append(addDiv);

	   }
	   $(this).closest('.modal-dialog').find('.close').trigger('click');

	});

	 $('.close').click(function(){

		 removeDataFromForm($(this).closest('.modal').attr('id'));

	 });

	 $('.modal-footer > button.btn-danger').click(function(){

		    $(this).closest('.modal-dialog').find('.close').trigger('click')
	 });


	 $( "div.flow-action" ).sortable({items: "> div.action-in-flow"});

	 //sortstop
	 $( "div.flow-action" ).on( "sortupdate", function( event, ui ) {

		 var count = 0;
		 var totallist = $('div.flow-action > div.action-in-flow');

		 for(var i=0 ; i<  totallist.length ; i++)
		 {
			 $(totallist[i]).attr('position', i+1);
			 $(totallist[i]).find('.action-details > .action-name').text('STEP ' + (i+1) + ' - ' + $(totallist[i]).attr('action_class'));
		 }

	 });

		var creatXhrRequest = function(method, url, isasynch, RequestHeaders,withCredentials)
		{
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open(method, url, isasynch);
			if (withCredentials)
			{
				xmlhttp.withCredentials = true;
			}
			for ( var key in RequestHeaders)
			{
				xmlhttp.setRequestHeader(key, RequestHeaders[key]);
			}
			return xmlhttp;
		}


     $('.action-in-flow').click(function(){

    	var action = $(this).attr('action_class');
    	var position = $(this).attr('position');
    	var hidden = $(this).find('.hidden_data_for_action');
    	switch(action)
    	{
    		case 'EMAIL':
    			  $('#work-pane-email-send').find('input.email-sub').val($(hidden).find('.email_sub').val());
    			  $("#work-pane-email-send").find('.wysihtml5-sandbox')[0].contentDocument.body.innerHTML = $(hidden).find('.email_body').val()
                  $('button#email_opener').trigger('click');
    			  $('#work-pane-email-send').find('.btn-save').css('display','inline-block');
			      $('#work-pane-email-send').find('.btn-add').css('display','none');
			      $('#work-pane-email-send').attr('update_at' , action + '_'+ position);
    			  break;
    		case 'WAIT':
 			      $('#work-pane-event-time-delay').find('input#wait_day').val($(hidden).find('input.days_val').val());
 			      var weekend_check =$(hidden).find('input.only_weekend_check').val();
 			      $('#work-pane-event-time-delay').find('input[name="only_weekend"][value='+ weekend_check +']').prop('checked',true);
                  $('button#wait_opener').trigger('click');
                  $('#work-pane-event-time-delay').find('.btn-save').css('display','inline-block');
			      $('#work-pane-event-time-delay').find('.btn-add').css('display','none');
			      $('#work-pane-event-time-delay').attr('update_at' , action + '_'+ position);
 			  break;
    		case 'VIDEO-MESSAGE':
			      $('#work-pane-email-video').find('input.email-sub').val($(hidden).find('input.video_email_sub').val());
			      $("#work-pane-email-video").find('.wysihtml5-sandbox')[0].contentDocument.body.innerHTML = $(hidden).find('textarea.videoemail_body').val()
                  $("#work-pane-email-video").find('#video_email_video').attr('src' , '~/../uploads/Video_email/' + $(hidden).find('input.video_email_name').val());
			      $("#work-pane-email-video").find('#video_email_video').attr('controls','');
			      $("#work-pane-email-video").find('#video_start').attr('disabled',true);
			      $('button#video_opener').trigger('click');
			      $('#work-pane-email-video').find('.btn-save').css('display','inline-block');
			      $('#work-pane-email-video').find('.btn-add').css('display','none');
			      $('#work-pane-email-video').attr('update_at' , action + '_'+ position);

			  break;
    	    case 'POSTCARD':
			      $('#work-pane-postcard').find('img#postcard_front_img').attr('src',autho_img__url + $(hidden).find('input.frnt_img').val());
			      $('#work-pane-postcard').find('img#postcard_back_img').attr('src',autho_img__url + $(hidden).find('input.bck_img').val());
			      $('#work-pane-postcard').find('textarea#message_for_postcard').val($(hidden).find('textarea.postcard_msg').val());
			      $('#work-pane-postcard').find('input#to_full_name').val($(hidden).find('input.to_fullname').val());
			      $('#work-pane-postcard').find('input#to_company').val($(hidden).find('input.to_companyname').val());
			      $('#work-pane-postcard').find('input#to_line1').val($(hidden).find('input.to_line1').val());
			      $('#work-pane-postcard').find('input#to_line2').val($(hidden).find('input.to_line2').val());
			      $('#work-pane-postcard').find('input#from_full_name').val($(hidden).find('input.from_fullname').val());
			      $('#work-pane-postcard').find('input#from_company').val($(hidden).find('input.from_companyname').val());
			      $('#work-pane-postcard').find('input#from_line1').val($(hidden).find('input.from_line1').val());
			      $('#work-pane-postcard').find('input#from_line2').val($(hidden).find('input.from_line2').val());
                  $('button#post_card_opener').trigger('click');
			      $('#work-pane-postcard').find('.btn-save').css('display','inline-block');
			      $('#work-pane-postcard').find('.btn-add').css('display','none');
			      $('#work-pane-postcard').attr('update_at' , action + '_'+ position);
			  break;
    	    case 'Handwritten_Notes':
			      $('#handwritten_notes').find('textarea#message_for_handWrittent_note').val($(hidden).find('textarea.hwnote_msg').val());
			      $('#handwritten_notes').find('select#script_for_handWrittent_note').val($(hidden).find('input.hdnote_script').val());
			      $('#handwritten_notes').find('select#ink_color_for_handWrittent_note').val($(hidden).find('input.hdnote_ink_color').val());
			      $('#handwritten_notes').find('select#envelop_ink_color_for_handWrittent_note').val($(hidden).find('input.hdnote_envelop_ink_color').val());

			      $('#handwritten_notes').find('input#to_full_name').val($(hidden).find('input.hwnote_to_fullname').val());
			      $('#handwritten_notes').find('input#to_company').val($(hidden).find('input.hwnote_to_companyname').val());
			      $('#handwritten_notes').find('input#to_line1').val($(hidden).find('input.hwnote_to_line1').val());
			      $('#handwritten_notes').find('input#to_line2').val($(hidden).find('input.hwnote_to_line2').val());
			      $('#handwritten_notes').find('input#from_full_name').val($(hidden).find('input.hwnote_from_fullname').val());
			      $('#handwritten_notes').find('input#from_company').val($(hidden).find('input.hwnote_from_companyname').val());
			      $('#handwritten_notes').find('input#from_line1').val($(hidden).find('input.hwnote_from_line1').val());
			      $('#handwritten_notes').find('input#from_line2').val($(hidden).find('input.hwnote_from_line1').val());
                  $('button#handwritten_note_opener').trigger('click');
			      $('#handwritten_notes').find('.btn-save').css('display','inline-block');
			      $('#handwritten_notes').find('.btn-add').css('display','none');
			      $('#handwritten_notes').attr('update_at' , action + '_'+ position);
			  break;


    	    case 'Gifting':


    	    	  $('#gifting').find('img#gifting_img').attr('src', autho_img__url + $(hidden).find('input.gifting_image').val());
    	    	  $('#gifting').find('select#gift_card').val($(hidden).find('input.gift_card_script').val());
    	    	  $('#gifting').find('input#ammount_for_gifting').val($(hidden).find('input.ammount_for_gifting	').val());
    	    	  $('#gifting').find('textarea#message_for_gifting').val($(hidden).find('textarea.gift_msg').val());

			      $('#gifting').find('select#script_for_gifting').val($(hidden).find('input.gifting_script').val());
			      $('#gifting').find('select#ink_color_for_gifting').val($(hidden).find('input.gifting_ink_color').val());
			      $('#gifting').find('select#envelop_ink_color_for_gifting').val($(hidden).find('input.gifting_envelop_ink_color').val());

			      $('#gifting').find('input#to_full_name').val($(hidden).find('input.gifting_to_fullname').val());
			      $('#gifting').find('input#to_company').val($(hidden).find('input.gifting_to_companyname').val());
			      $('#gifting').find('input#to_line1').val($(hidden).find('input.gifting_to_line1').val());
			      $('#gifting').find('input#to_line2').val($(hidden).find('input.gifting_to_line2').val());
			      $('#gifting').find('input#from_full_name').val($(hidden).find('input.gifting_from_fullname').val());
			      $('#gifting').find('input#from_company').val($(hidden).find('input.gifting_from_companyname').val());
			      $('#gifting').find('input#from_line1').val($(hidden).find('input.gifting_from_line1').val());
			      $('#gifting').find('input#from_line2').val($(hidden).find('input.gifting_from_line2').val());
                  $('button#gift_opener').trigger('click');
                  $('#gifting').find('.btn-save').css('display','inline-block');
			      $('#gifting').find('.btn-add').css('display','none');
			      $('#gifting').attr('update_at' , action + '_'+ position);
			  break;
    	   case 'LinkedIn':
    		   	  $('#linkedin').find('select#connect_or_inmail_linkedin').val($(hidden).find('input.linkedin_type').val());
  	    	      $('#linkedin').find('input#linkedin_inmail_subject').val($(hidden).find('input.linedinmailsub	').val());
  	    	      $('#linkedin').find('textarea#message_for_linkedin').val($(hidden).find('textarea.linkedin_msg').val());
  	    	      if($(hidden).find('input.linkedin_type').val() == "INMAIL")
  	    	      {
  	    	    	$("#linkedin_inmail_subject").css("display","block");
  	    	      }
  	    	      else
  	    	      {
  	    	    	$("#linkedin_inmail_subject").css("display","none");
  	    	      }
                  $('button#linkedin_opener').trigger('click');
                  $('#linkedin').find('.btn-save').css('display','inline-block');
			      $('#linkedin').find('.btn-add').css('display','none');
			      $('#linkedin').attr('update_at' , action + '_'+ position);
			  break;
    	   case 'TWITTER':
    		      var follow_unfollow =$(hidden).find('input.follow_unfollow').val();
			      $('#twitter-follow').find('input[name="radio_twitter"][value='+ follow_unfollow +']').prop('checked',true);
                  $('button#twitter_opener').trigger('click');
                  $('#twitter-follow').find('.btn-save').css('display','inline-block');
			      $('#twitter-follow').find('.btn-add').css('display','none');
			      $('#twitter-follow').attr('update_at' , action + '_'+ position);

			  break;
    	}

     });

	 $("button#add_page").click(function(){

		 if(validationsForMainPage())
		 {

			 var image_name = uploadAuthorImage();
			 var data  = new Object();
			 data.Page_name = $("#page_name").val();
			 data.Written_by = $("#written_by").val();
			 data.Job_title = $("#Job_title").val();
			 data.tips = $("#editor-toolbar-for-tips").val();

			 if(image_name != '')
			 {
				 data.author_image = image_name ; //$("#author_img").attr('src');
			 }
			 else if(image_name == false)
			 {
				 return;
			 }

			 var Actions = getactionsdata();
			 var Similar_camp = getsimilarCamaigns()

			 data.action_data = Actions;
			 data.similar_camps = Similar_camp;

			  var RequestHeaders = [];
		      RequestHeaders['Content-Type'] = 'application/json';
	          var url =  "/cliently_cms/api/add.php";
		      var xhr = creatXhrRequest("POST", url, false, RequestHeaders, false);
		      xhr.send(JSON.stringify(data));

		      var jsonResponse = JSON.parse(xhr.responseText);
		      if (xhr.status == 200)
		      {

		    	  alert(jsonResponse.status_message);
		    	  window.location.href = "/cliently_cms/home.php";

		      }
		      else
		      {
				//alert('Error oucurred While sync Pleas try again');
				alert(jsonResponse.data);
		      }

		 }


	 });

	 $("button#update_page").click(function(){

		 if(validationsForMainPage())
		 {
			 var image_name = uploadAuthorImage();
			 var id = $(this).attr('page_id');
			 var data  = new Object();
			 data.wp_id = $(this).attr('wp_id');
			 data.Page_name = $("#page_name").val();
			 data.Written_by = $("#written_by").val();
			 data.Job_title = $("#Job_title").val();
			 data.tips = $("#editor-toolbar-for-tips").val();
			 if(image_name != '')
			 {
				 data.author_image = image_name ; //$("#author_img").attr('src');
			 }
			 else if(image_name == false)
			 {
				 return;
			 }


			 var Actions = getactionsdata();
			 var Similar_camp = getsimilarCamaigns()

			 data.action_data = Actions;
			 data.similar_camps = Similar_camp;

			  var RequestHeaders = [];
		      RequestHeaders['Content-Type'] = 'application/json';
	          var url = "/cliently_cms/api/update.php?id=" + id;
		      var xhr = creatXhrRequest("POST", url, false, RequestHeaders, false);
		      xhr.send(JSON.stringify(data));

		      var jsonResponse = JSON.parse(xhr.responseText);
		      if (xhr.status == 200)
		      {

		    	  alert(jsonResponse.status_message);
		    	  window.location.href = "/cliently_cms/home.php";

		      }
		      else
		      {
				//alert('Error oucurred While sync Pleas try again');
				alert(jsonResponse.data);
		      }

		 }
	 });



	 var uploadAuthorImage = function() {


		 if($('#author_img_input')[0].files[0] != undefined)
		 {
			    var url = '/cliently_cms/api/upload.php';

				var RequestHeaders = [];
				RequestHeaders['Content-Type'] = 'multipart/form-data';
				RequestHeaders['X-Requested-With'] = 'XMLHttpRequest';


				var formData = new FormData();
				formData.append('photo',$('#author_img_input')[0].files[0].name);
				//formData.append('class', uploadtype);
				formData.append('photo', $('#author_img_input')[0].files[0]);

				var xhr = creatXhrRequest('POST', url, false, null, true);
				xhr.send(formData);

				if (xhr.status == 200)
				{
					var jsonResponse = JSON.parse(xhr.responseText);
					console.log(jsonResponse);

					if(jsonResponse.data)
					{
						return jsonResponse.data;
					}
				}
				else if (xhr.status == 400)
				{
					var jsonResponse = JSON.parse(xhr.responseText);
					console.log(jsonResponse);

					if(jsonResponse.data)
					{
						alert(jsonResponse.data)
						return  false;
					}
				}
				else
				{
					return "";
				}
			}
		 	else
		 	{
		 		return  $('img#author_img').attr('src').substring($('img#author_img').attr('src').lastIndexOf("/")+1);
		 	}
		}

      var uploadPostCardImage = function(type) {

  	     var url = '/cliently_cms/api/upload.php';

		 var RequestHeaders = [];
		 RequestHeaders['Content-Type'] = 'multipart/form-data';
   		 RequestHeaders['X-Requested-With'] = 'XMLHttpRequest';

		 if(type == "front")
		 {
			 if($('#postcard_front_img_input')[0].files[0] != undefined)
			 {
					var formData = new FormData();
					formData.append('photo',$('#postcard_front_img_input')[0].files[0].name);
					//formData.append('class', uploadtype);
					formData.append('photo', $('#postcard_front_img_input')[0].files[0]);

					var xhr = creatXhrRequest('POST', url, false, null, true);
					xhr.send(formData);
			 }
		 	else if($('img#postcard_front_img').attr('src') != null && $('img#postcard_front_img').attr('src') != undefined )
		 	{
		 		if($('img#postcard_front_img').attr('src').substring($('img#postcard_front_img').attr('src').lastIndexOf("/")+1) != "profile-blank.png")
		 		{
		 			return  $('img#postcard_front_img').attr('src').substring($('img#postcard_front_img').attr('src').lastIndexOf("/")+1);
		 		}
		 		else
		 		{
		 			alert("Upload Front Image");
		 		}
		 	}
		 	else
		 	{
		 		alert("Upload Front Image");
		 	}
		 }
		 else if(type == "back")
		 {

			 if($('#postcard_back_img_input')[0].files[0] != undefined)
			 {
				var formData = new FormData();
				formData.append('photo',$('#postcard_back_img_input')[0].files[0].name);
				//formData.append('class', uploadtype);
				formData.append('photo', $('#postcard_back_img_input')[0].files[0]);

				var xhr = creatXhrRequest('POST', url, false, null, true);
				xhr.send(formData);
			 }
		 	 else if($('img#postcard_back_img').attr('src') != null && $('img#postcard_back_img').attr('src') != undefined )
		 	 {

		 		if($('img#postcard_back_img').attr('src').substring($('img#postcard_back_img').attr('src').lastIndexOf("/")+1) != "profile-blank.png")
		 		{
		 			return  $('img#postcard_back_img').attr('src').substring($('img#postcard_back_img').attr('src').lastIndexOf("/")+1);
		 		}
		 		else
		 		{
		 			alert("Upload Back Image");
		 		}
		 	 }
		 	 else
		 	 {
		 		alert("Upload Back Image");
		 	 }

		 }

		 if (xhr.status == 200)
		 {
			var jsonResponse = JSON.parse(xhr.responseText);
			console.log(jsonResponse);

			if(jsonResponse.data)
			{
				return jsonResponse.data;
			}
		 }
		 else if (xhr.status == 400)
		 {
			 var jsonResponse = JSON.parse(xhr.responseText);
			 console.log(jsonResponse);

			 if(jsonResponse.data)
			 {
				alert(jsonResponse.data)
				return  false;
			 }
		 }
		 else
		 {
			 return "";
		 }
	}

	var uploadGiftImage = function()
	{
		var url = '/cliently_cms/api/upload.php';

			 var RequestHeaders = [];
			 RequestHeaders['Content-Type'] = 'multipart/form-data';
	   		 RequestHeaders['X-Requested-With'] = 'XMLHttpRequest';

		if($('#gifting_img_input')[0].files[0] != undefined)
		 {
			var formData = new FormData();
			formData.append('photo',$('#gifting_img_input')[0].files[0].name);
			//formData.append('class', uploadtype);
			formData.append('photo', $('#gifting_img_input')[0].files[0]);

			var xhr = creatXhrRequest('POST', url, false, null, true);
			xhr.send(formData);
		 }
	 	 else if($('img#gifting_img').attr('src') != null && $('img#gifting_img').attr('src') != undefined )
	 	 {

	 		if($('img#gifting_img').attr('src').substring($('img#gifting_img').attr('src').lastIndexOf("/")+1) != "profile-blank.png")
	 		{
	 			return  $('img#gifting_img').attr('src').substring($('img#gifting_img').attr('src').lastIndexOf("/")+1);
	 		}
	 		else
	 		{
	 			alert("Upload Image");
	 		}
	 	 }
	 	 else
	 	 {
	 		alert("Upload Image");
	 	 }




		 if (xhr.status == 200)
		 {
			var jsonResponse = JSON.parse(xhr.responseText);
			console.log(jsonResponse);

			if(jsonResponse.data)
			{
				return jsonResponse.data;
			}
		 }
		 else if (xhr.status == 400)
		 {
			 var jsonResponse = JSON.parse(xhr.responseText);
			 console.log(jsonResponse);

			 if(jsonResponse.data)
			 {
				alert(jsonResponse.data)
				return  false;
			 }
		 }
		 else
		 {
			 return "";
		 }
	}

	var getactionsdata = function()
	{
		var Actions  =  []
		$('div.flow-action > div.action-in-flow').each(function(){

			 var action  = new Object();
			 action.class_name = $(this).attr('action_class');
			 action.position = $(this).attr('position');

			 var hidden_data = $(this).find(".hidden_data_for_action");

			 switch (action.class_name)
				{
			       	case "EMAIL":

			       		  action.email_subject = $(hidden_data).find('.email_sub').val();
			       		  action.email_body = $(hidden_data).find('.email_body').val();

			              break;
			       	case "WAIT":
			       		  action.days = $(hidden_data).find('.days_val').val();
			       		  action.weekend_check = $(hidden_data).find('.only_weekend_check').val();

			              break;
			       	case "VIDEO-MESSAGE":

			       	      action.video_email_subject = $(hidden_data).find('.video_email_sub').val();
		       		      action.video_email_body = $(hidden_data).find('.videoemail_body').val();
		       		      action.video_name = $(hidden_data).find('.video_email_name').val();
			              break;
			       	case "POSTCARD":
			       		  action.front_image = $(hidden_data).find('.frnt_img').val();
			       	      action.back_image = $(hidden_data).find('.bck_img').val();
			       	      action.postcard_msg = encodeURIComponent($(hidden_data).find('.postcard_msg').val());


			       	      var To = Object();
			       	      To.full_name =  $(hidden_data).find('.to_fullname').val();
			       	      To.companyname =  $(hidden_data).find('.to_companyname').val();
			       	      To.line1 =  $(hidden_data).find('.to_line1').val();
			       	      To.line2 =  $(hidden_data).find('.to_line2').val();
			       	      action.to = To
			       	      var From = Object();
			       	      From.full_name =  $(hidden_data).find('.from_fullname').val();
			       	      From.companyname =  $(hidden_data).find('.from_companyname').val();
			       	      From.line1 =  $(hidden_data).find('.from_line1').val();
			       	      From.line2 =  $(hidden_data).find('.from_line2').val();
			       	      action.from = From

			              break;
			       	case "Handwritten_Notes":

			       		  action.hwnote_msg = encodeURIComponent($(hidden_data).find('.hwnote_msg').val());
			       		  action.hdnote_script = $(hidden_data).find('.hdnote_script').val();
			       		  action.hdnote_ink_color = $(hidden_data).find('.hdnote_ink_color').val();
			       		  action.hdnote_envelop_ink_color = $(hidden_data).find('.hdnote_envelop_ink_color').val();

			       	      var To = Object();
			       	      To.full_name =  $(hidden_data).find('.hwnote_to_fullname').val();
			       	      To.companyname =  $(hidden_data).find('.hwnote_to_companyname').val();
			       	      To.line1 =  $(hidden_data).find('.hwnote_to_line1').val();
			       	      To.line2 =  $(hidden_data).find('.hwnote_to_line2').val();
			       	      action.to = To
			       	      var From = Object();
			       	      From.full_name =  $(hidden_data).find('.hwnote_from_fullname').val();
			       	      From.companyname =  $(hidden_data).find('.hwnote_from_companyname').val();
			       	      From.line1 =  $(hidden_data).find('.hwnote_from_line1').val();
			       	      From.line2 =  $(hidden_data).find('.hwnote_from_line2').val();
			       	      action.from = From




			              break;
			       	case "Gifting":

			       		  action.gift_image = $(hidden_data).find('.gifting_image').val();
				       	  action.gift_card_script = $(hidden_data).find('.gift_card_script').val();
				       	  action.ammount_for_gifting = $(hidden_data).find('.ammount_for_gifting').val();
				          action.gift_msg = encodeURIComponent ($(hidden_data).find('.gift_msg').val());
				       	  action.gifting_script = $(hidden_data).find('.gifting_script').val();
				       	  action.gifting_ink_color = $(hidden_data).find('.gifting_ink_color').val();
				       	  action.gifting_envelop_ink_color = $(hidden_data).find('.gifting_envelop_ink_color').val();

				       	  var To = Object();
			       	      To.full_name =  $(hidden_data).find('.gifting_to_fullname').val();
			       	      To.companyname =  $(hidden_data).find('.gifting_to_companyname').val();
			       	      To.line1 =  $(hidden_data).find('.gifting_to_line1').val();
			       	      To.line2 =  $(hidden_data).find('.gifting_to_line2').val();
			       	      action.to = To
			       	      var From = Object();
			       	      From.full_name =  $(hidden_data).find('.gifting_from_fullname').val();
			       	      From.companyname =  $(hidden_data).find('.gifting_from_companyname').val();
			       	      From.line1 =  $(hidden_data).find('.gifting_from_line1').val();
			       	      From.line2 =  $(hidden_data).find('.gifting_from_line2').val();
			       	      action.from = From


			              break;
			       	case "LinkedIn":
						  action.linkedin_type  =  $(hidden_data).find('.linkedin_type').val();
						  action.linkedin_msg  =  encodeURIComponent($(hidden_data).find('.linkedin_msg').val());
						  action.linedinmailsub  =  $(hidden_data).find('.linedinmailsub').val();

			              break;
			       	case "TWITTER":
			       		  action.follow_unfollow = $(hidden_data).find('.follow_unfollow').val()
			              break;


			         default:

				}

			 Actions.push(action);

		});

		return Actions;
	}

	var getsimilarCamaigns = function()
	{
		var Camaigns = [];
		$('div.sim_camp > div.similar_campaigns').each(function(){

			 var camp  = new Object();
			 camp.title = $(this).find('.camp_title').val();
			 camp.url = encodeURIComponent($(this).find('.camp_url').val());
			 camp.position = $(this).attr('position');
			 Camaigns.push(camp);

		});

		return Camaigns;

	}

	var removeDataFromForm = function(action)
	{
		switch(action)
    	{
    		case 'work-pane-email-send':
    			  $('#work-pane-email-send').find('input.email-sub').val('');
    			  $("#work-pane-email-send").find('.wysihtml5-sandbox')[0].contentDocument.body.innerHTML = ''
			      $('#work-pane-email-send').removeAttr('update_at');
    			  break;
    		case 'work-pane-event-time-delay':
 			      $('#work-pane-event-time-delay').find('input#wait_day').val('');
 			      $('#work-pane-event-time-delay').find('input[name="only_weekend"]').prop('checked',false);
			      $('#work-pane-event-time-delay').removeAttr('update_at');
 			  break;
    		case 'work-pane-email-video':
			      $('#work-pane-email-video').find('input.email-sub').val('');
			      $("#work-pane-email-video").find('.wysihtml5-sandbox')[0].contentDocument.body.innerHTML = '';
			      $("#work-pane-email-video").find('#video_email_video').removeAttr('controls','');
			      $("#work-pane-email-video").find('#video_email_video')[0].pause();
			      $("#work-pane-email-video").find('#video_start').removeAttr('disabled');
			      $('#work-pane-email-video').removeAttr('update_at');


			  break;
    	    case 'work-pane-postcard':
			      $('#work-pane-postcard').find('img#postcard_front_img').attr('src','~/../images/profile-blank.png');
			      $('#work-pane-postcard').find('img#postcard_back_img').attr('src','~/../images/profile-blank.png');
			      $('#work-pane-postcard').find('textarea#message_for_postcard').val('');
			      $('#work-pane-postcard').find('input#to_full_name').val('');
			      $('#work-pane-postcard').find('input#to_company').val('');
			      $('#work-pane-postcard').find('input#to_line1').val('');
			      $('#work-pane-postcard').find('input#to_line2').val('');
			      $('#work-pane-postcard').find('input#from_full_name').val('');
			      $('#work-pane-postcard').find('input#from_company').val('');
			      $('#work-pane-postcard').find('input#from_line1').val('');
			      $('#work-pane-postcard').find('input#from_line2').val('');
			      $('#work-pane-postcard').attr('update_at');
			  break;
    	    case 'handwritten_notes':
			      $('#handwritten_notes').find('textarea#message_for_handWrittent_note').val('');
			      $('#handwritten_notes').find('select#script_for_handWrittent_note').val('PRINT');
			      $('#handwritten_notes').find('select#ink_color_for_handWrittent_note').val('BLACK');
			      $('#handwritten_notes').find('select#envelop_ink_color_for_handWrittent_note').val('WHITE w BLACK INK');

			      $('#handwritten_notes').find('input#to_full_name').val('');
			      $('#handwritten_notes').find('input#to_company').val('');
			      $('#handwritten_notes').find('input#to_line1').val('');
			      $('#handwritten_notes').find('input#to_line2').val('');
			      $('#handwritten_notes').find('input#from_full_name').val('');
			      $('#handwritten_notes').find('input#from_company').val('');
			      $('#handwritten_notes').find('input#from_line1').val('');
			      $('#handwritten_notes').find('input#from_line2').val('');
			      $('#handwritten_notes').attr('update_at');
			  break;


    	    case 'gifting':
    	    	  $('#gifting').find('select#gift_card').val('print');
    	    	  $('#gifting').find('input#ammount_for_gifting').val('');
    	    	  $('#gifting').find('textarea#message_for_gifting').val('');
    	    	  $('#gifting').find('img#gifting_img').attr('src','~/../images/profile-blank.png');

			      $('#gifting').find('select#script_for_gifting').val('PRINT');
			      $('#gifting').find('select#ink_color_for_gifting').val('BLACK');
			      $('#gifting').find('select#envelop_ink_color_for_gifting').val('WHITE w BLACK INK');

			      $('#gifting').find('input#to_full_name').val('');
			      $('#gifting').find('input#to_company').val('');
			      $('#gifting').find('input#to_line1').val('');
			      $('#gifting').find('input#to_line2').val('');
			      $('#gifting').find('input#from_full_name').val('');
			      $('#gifting').find('input#from_company').val('');
			      $('#gifting').find('input#from_line1').val('');
			      $('#gifting').find('input#from_line2').val('');
			      $('#gifting').attr('update_at');
			  break;
    	   case 'linkedin':
    		   	  $('#linkedin').find('select#connect_or_inmail_linkedin').val('CONNECT');
  	    	      $('#linkedin').find('input#linkedin_inmail_subject').val();
  	    	      $('#linkedin').find('textarea#message_for_linkedin').val('');
			      $('#linkedin').attr('update_at');
			  break;
    	   case 'twitter-follow':
			      $('#twitter-follow').find('input[name="radio_twitter"]').prop('checked',false);
			      $('#twitter-follow').attr('update_at');

			  break;
    	}


	}

	var initializeVideo = function()
	{

		 navigator.mediaDevices.getUserMedia({
		      video: true,
		      audio: true
		    })
		    .then(stm => {
		      stream = stm;
		      $("#video_email_video	").attr('src', URL.createObjectURL(stream));
		    }).catch(e => console.error(e));
	}

	$("#video_start").click(function(event){

		$(this).attr('disabled',true)
		event.stopPropagation();
        event.preventDefault();
		startRecording();
	});
	$("#video_stop").click(function(event){

		event.stopPropagation();
        event.preventDefault();
		stopRecording();
	});
     $("#video_restart").click(function(event){

    	 event.stopPropagation();
	        event.preventDefault();
    	 restartRecording();
	});

	function startRecording()
	{

	  recorder = new MediaRecorder(stream, { mimeType: 'video/webm',audioBitsPerSecond : 128000,
	      videoBitsPerSecond : 2500000, });
	  recorder.start();
	}



	function stopRecording()
	{
	  recorder.ondataavailable = e => {
	   // a.href = URL.createObjectURL(e.data);
	    $("#video_email_video").attr('src',URL.createObjectURL(e.data));
	    $("#video_email_video").attr('controls','');
	    chunks = []
	    chunks.push(e.data)
	    console.log(chunks);
	  };
	  recorder.stop();
	}

	function restartRecording()
	{

		$("#video_email_video").removeAttr('controls');
		navigator.mediaDevices.getUserMedia({
		      video: true,
		      audio: true
		    })
		    .then(stm => {
		      stream = stm;
		      $("#video_email_video").attr('src', URL.createObjectURL(stream));
		      $('#video_emil_file').val('');
		      recorder = new MediaRecorder(stream, { mimeType: 'video/webm' });
			  recorder.start();
		    }).catch(e => console.error(e));

	}

	$("#video_emil_file").change(function(){

		console.log("changed");
		readURL(this,'video_action');


	});

	var uploadVideo = function()
	{
		var newblob  = new Blob(chunks, { 'type' : 'video/webm' , 'filename' : 'abc.webm' });
		if($('#video_emil_file')[0].files[0] != undefined  || newblob.size > 0)
		{

			var url =   '/cliently_cms/api/upload.php';
			var RequestHeaders = [];
			RequestHeaders['Content-Type'] = 'multipart/form-data';
			RequestHeaders['X-Requested-With'] = 'XMLHttpRequest';

			if($('#video_emil_file')[0].files[0])
			{
				var v_name = $('#video_emil_file')[0].files[0].name;
				var v_formate = v_name.substring(v_name.lastIndexOf(".")+1);
				var formData = new FormData();
				formData.append('video-formate',v_formate);
				formData.append('video', $('#video_emil_file')[0].files[0]);
			}
			else if(newblob.size > 0)
			{
				var formData = new FormData();
				formData.append('video-formate','webm');
				formData.append('video', newblob);
			}

			var xhr = creatXhrRequest('POST', url, false, null, true);
			xhr.send(formData);

			if (xhr.status == 200)
			{
				var jsonResponse = JSON.parse(xhr.responseText);
				console.log(jsonResponse);

				if(jsonResponse.data)
				{
					return jsonResponse.data;
				}
			}
			else
			{
				return "";
			}
		}
		else
		{
			alert("Please record or Upload Video");
			return false;
		}

	}





	var validationsForMainPage = function()
	{

		if( !$('input#page_name').val() )
		{
			alert('Please enter Page Name.');
			return false;
		}
		else if($('div.flow-action').children().not('#action_template').length <= 0 )
		{
			alert('Please add some action');
			return false;
		}
		else if(!$('textarea#editor-toolbar-for-tips').val())
		{
			alert('Please enter Tips.');
			return false;
		}
		else if(!$('input#written_by').val())
		{
			alert('Please enter Author Name.');
			return false;
		}
		else if(!$('input#Job_title').val())
		{
			alert('Please enter Author\'s Job Title.');
			return false;
		}
		else if(!$('input#Job_title').val())
		{
			alert('Please enter Author\'s Job Title.');
			return false;
		}
		else if($('img#author_img').attr('src') == '~/../images/profile-blank.png')
		{
			alert('Please add Author\'s Image');
		}
		else
		{
			return true;
		}

	}




});

var  addaction =  function (action)
{
	var action_name = action.class_name;
		 var addDiv, stepname ,imgpath ,action_detail;

     addDiv = $('div#action_template > div.action-in-flow').clone(true, true);
     action_position = action.position;
		switch (action_name)
		{
	       	 case 'EMAIL':

	       		  stepname = 'EMAIL';
				  imgpath  = '~/../images/email.svg';
				  action_detail= action.email_subject ;
				  var msg_body =  $('<textarea class=\'email_body\' />');
				  var email_sub = $('<input class=\'email_sub\' />');
				  msg_body.val(action.email_body);
				  email_sub.val(action_detail);
                  $(addDiv).find('.hidden_data_for_action').append(msg_body, email_sub);
		          break;

			 case 'WAIT':
	       		  stepname = 'WAIT';
	       		  imgpath  = '~/../images/wait.svg';
				  action_detail='Wait ' + action.days +' Days' ;
				  var only_weekend = $('<input class=\'only_weekend_check\' />');
				  var days_val = $('<input class=\'days_val\' />');
				  only_weekend.val(action.weekend_check);
				  days_val.val(action.days);
				  $(addDiv).find('.hidden_data_for_action').append(only_weekend,days_val);

				  break;

			 case "VIDEO-MESSAGE":

	    		  stepname = 'VIDEO-MESSAGE';
				  imgpath  = "~/../images/videomessage.svg";
				  action_detail= action.video_email_subject ;
				  var video_msg_body =  $('<textarea class="videoemail_body" />');
				  var video_email_sub = $('<input class="video_email_sub" />');
				  var video_email_name = $('<input class="video_email_name" />');
				  video_msg_body.val(action.video_email_body);
				  video_email_sub.val(action_detail);
				  video_email_name.val(action.video_name);
				  $(addDiv).find('.hidden_data_for_action').append(video_email_sub,video_email_name,video_msg_body);

	       		  break;
	    	 case "POSTCARD":

	    		  stepname = 'POSTCARD';
			      imgpath  = "~/../images/postcard.svg";
			      action_detail = "Templated Design"
				  var postcard_msg =  $('<textarea class="postcard_msg" />');
			      var frnt_img =  $('<input class="frnt_img" />');
			      var bck_img =  $('<input class="bck_img" />');
			      var to_fullname =  $('<input class="to_fullname" />');
			      var to_companyname =  $('<input class="to_companyname" />');
			      var to_line1 =  $('<input class="to_line1" />');
			      var to_line2 =  $('<input class="to_line2" />');
			      var from_fullname =  $('<input class="from_fullname" />');
			      var from_companyname =  $('<input class="from_companyname" />');
			      var from_line1 =  $('<input class="from_line1" />');
			      var from_line2 =  $('<input class="from_line2" />');


			      postcard_msg.val(decodeURIComponent(action.postcard_msg));
			      frnt_img.val(action.front_image);
			      bck_img.val(action.back_image );
			      to_fullname.val(action.to.full_name);
			      to_companyname.val(action.to.companyname);
			      to_line1.val(action.to.line1);
			      to_line2.val(action.to.line2);


			      from_fullname.val(action.from.full_name);
			      from_companyname.val(action.from.companyname);
			      from_line1.val(action.from.line1);
			      from_line2.val(action.from.line2);

				  $(addDiv).find('.hidden_data_for_action').append(postcard_msg,frnt_img , bck_img,to_fullname,to_companyname,to_line1,to_line2,from_fullname,from_companyname,from_line1,from_line2);

	       		  break;
	    	 case "Handwritten_Notes":

	    		  stepname = 'Handwritten_Notes';
			      imgpath  = "~/../images/hwnote.svg";
			      action_detail = "Notes"
				  var hwnote_msg =  $('<textarea class="hwnote_msg" />');
			      var hdnote_script = $('<input class="hdnote_script" />');
			      var hdnote_ink_color = $('<input class="hdnote_ink_color" />');

			      var hwnote_to_fullname =  $('<input class="hwnote_to_fullname" />');
			      var hwnote_to_companyname =  $('<input class="hwnote_to_companyname" />');
			      var hwnote_to_line1 =  $('<input class="hwnote_to_line1" />');
			      var hwnote_to_line2 =  $('<input class="hwnote_to_line2" />');
			      var hwnote_from_fullname =  $('<input class="hwnote_from_fullname" />');
			      var hwnote_from_companyname =  $('<input class="hwnote_from_companyname" />');
			      var hwnote_from_line1 =  $('<input class="hwnote_from_line1" />');
			      var hwnote_from_line2 =  $('<input class="hwnote_from_line2" />');

			      var hdnote_envelop_ink_color = $('<input class="hdnote_envelop_ink_color" />');

			      hwnote_msg.val(decodeURIComponent(action.hwnote_msg));
			      hdnote_script.val(action.hdnote_script);
			      hdnote_ink_color.val(action.hdnote_ink_color);

			      hwnote_to_fullname.val(action.to.full_name);
			      hwnote_to_companyname.val(action.to.companyname);
			      hwnote_to_line1.val(action.to.line1);
			      hwnote_to_line2.val(action.to.line2);

			      hwnote_from_fullname.val(action.from.full_name);
			      hwnote_from_companyname.val(action.from.companyname);
			      hwnote_from_line1.val(action.from.line1);
			      hwnote_from_line2.val(action.from.line2);

			      hdnote_envelop_ink_color.val(action.hdnote_envelop_ink_color);

				  $(addDiv).find('.hidden_data_for_action').append(hwnote_msg, hdnote_script ,hdnote_ink_color,hdnote_envelop_ink_color, hwnote_to_fullname,hwnote_to_companyname,hwnote_to_line1,hwnote_to_line2,hwnote_from_fullname,hwnote_from_companyname,hwnote_from_line1,hwnote_from_line2);

	       		  break;

	    	 case "Gifting":

	    		  stepname = 'Gifting';
			      imgpath  = "~/../images/gift.svg";
			      action_detail = "GIFT";

			      var gifting_image  = $('<input class="gifting_image" />');
			      var gift_card_script = $('<input class="gift_card_script" />');
			      var ammount_for_gifting = $('<input class="ammount_for_gifting" />');

			      var gift_msg =  $('<textarea class="gift_msg" />');
			      var gifting_script = $('<input class="gifting_script" />');
			      var gifting_ink_color = $('<input class="gifting_ink_color" />');

			      var gifting_to_fullname =  $('<input class="gifting_to_fullname" />');
			      var gifting_to_companyname =  $('<input class="gifting_to_companyname" />');
			      var gifting_to_line1 =  $('<input class="gifting_to_line1" />');
			      var gifting_to_line2 =  $('<input class="gifting_to_line2" />');
			      var gifting_from_fullname =  $('<input class="gifting_from_fullname" />');
			      var gifting_from_companyname =  $('<input class="gifting_from_companyname" />');
			      var gifting_from_line1 =  $('<input class="gifting_from_line1" />');
			      var gifting_from_line2 =  $('<input class="gifting_from_line2" />');

			      var gifting_envelop_ink_color = $('<input class="gifting_envelop_ink_color" />');

			      gifting_image.val(action.gift_image);
			      gift_card_script.val(action.gift_card_script);
			      ammount_for_gifting.val(action.ammount_for_gifting);

			      gift_msg.val(decodeURIComponent(action.gift_msg));
			      gifting_script.val(action.gifting_script);
			      gifting_ink_color.val(action.gifting_ink_color);

			      gifting_to_fullname.val(action.to.full_name);
			      gifting_to_companyname.val(action.to.companyname);
			      gifting_to_line1.val(action.to.line1);
			      gifting_to_line2.val(action.to.line2);

			      gifting_from_fullname.val(action.from.full_name);
			      gifting_from_companyname.val(action.from.companyname);
			      gifting_from_line1.val(action.from.line1);
			      gifting_from_line2.val(action.from.line2);

			      gifting_envelop_ink_color.val(action.gifting_envelop_ink_color);

				  $(addDiv).find('.hidden_data_for_action').append(gifting_image,gift_card_script,ammount_for_gifting,gift_msg,gifting_script,gifting_ink_color,gifting_to_fullname,gifting_to_companyname,gifting_to_line1,gifting_to_line2,gifting_from_fullname,gifting_from_companyname,gifting_from_line1,gifting_from_line2,gifting_envelop_ink_color);

	       		  break;
	    	 case "LinkedIn":

		   		  var type ='';
		   		  stepname = 'LinkedIn';
		   	      imgpath  = "~/../images/linkedin.svg";

		   	      if(action.linkedin_type =='INMAIL')
		   	      {
		   	    	  action_detail = action.linedinmailsub ;
		   	    	  type ='INMAIL';
		   	      }
		   	      else
		   	      {
		   	    	  action_detail =  'CONNECT';
		   	    	  type ='CONNECT';
		   	      }
		   	       var linedinmailsub = $('<input class="linedinmailsub" />');
		   	       var linkedin_type = $('<input class="linkedin_type" />');
		   	       var linkedin_msg = $('<textarea class="linkedin_msg" />');

		   	       linkedin_type.val(action.linkedin_type);
		   	       linkedin_msg.val(decodeURIComponent(action.linkedin_msg));
		   	       if(type == 'INMAIL')
		   	       {
		   	    	   linedinmailsub.val(action_detail);
		   	       }
		   	       else
		   	       {
		   	    	   linedinmailsub.val('');
		   	       }
		   	      $(addDiv).find('.hidden_data_for_action').append(linkedin_type,linkedin_msg,linedinmailsub);

		   		break;

	    	 case "TWITTER":

			     stepname = 'TWITTER';
				 imgpath  = "~/../images/twitter.svg";
			     action_detail = action.follow_unfollow;

				 var follow_unfollow = $('<input class="follow_unfollow" />');
				 follow_unfollow.val(action_detail);

		   	     $(addDiv).find('.hidden_data_for_action').append(follow_unfollow);

		   		break;

		   	 default :

        }

	   $(addDiv).find('div.action-flow-image >img').attr('src',imgpath);
	   $(addDiv).find('div.action-details >  div.action-name').text('STEP ' + action_position +' - '+stepname);
	   $(addDiv).find('div.action-details >  div.action-detail').text(action_detail);
	   $(addDiv).attr('action_class', stepname );
	   $(addDiv).attr('position', action_position);
	   $(".flow-action").append(addDiv);


}

var addCampaign = function(camp)
{

    console.log(camp);
    addDiv = $(".similar_campaigns_template").clone(true,true);
	$(addDiv).removeClass('similar_campaigns_template');
	$(addDiv).addClass('similar_campaigns');
	$(addDiv).css('display','inline-block');

	var position = camp.position;
	$(addDiv).attr('position',position);
	$(addDiv).find('input.camp_title').val(camp.title)
	$(addDiv).find('input.camp_url').val(decodeURIComponent(camp.url))


	$('.sim_camp').append(addDiv);

}

