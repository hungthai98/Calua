(function( $ ) {	
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip(
		{
			animated: 'fade',
			placement: 'right',
			html: true
		}
	  );
	});
	
	jQuery(document).ready(function() {
		jQuery('#frm_mbwphOptions').submit(function() {
			jQuery('#mbwphLoader').append("<div class='loader mbwph-loader'> <div class='loader-outter'></div> <div class='loader-inner'></div></div>");
			$('#mbwphLoader').modal('show');
			jQuery(this).ajaxSubmit({			
				success: function(){
				$('#mbwphLoader').modal('hide');
				jQuery('#mbwphResult').html("<div id='mbwphPopup' class='modal'><div id='saveMessage' class='successModal'></div></div>");
				jQuery('#saveMessage').append("<span>Đã lưu cài đặt</span>");				
				$('#mbwphPopup').modal('show');
				}, 
				timeout: 5000
			  });
			setTimeout(function() { $('#mbwphPopup').modal('hide'); }, 4000);
			return false; 
	   });
	});
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.color-field').wpColorPicker();
    });
	//remove preview image
	$('.mbwph-image-preview').on('click', '.img-remove', function( event ){	
		  event.preventDefault();
		  var id = $(this).closest("div").attr("id");
		  $("#" + id).find(" .imgpreview_" + id).remove();
		  $("#" + id).find(" i.img-remove").remove();
		  $("#" + id).find(" .mbwph_image_url").val("");
		  $("#" + id).find(" .image_id").val("");
		  $(this).find().remove();
		  return false;
	  });
	// Uploading files v2
	var file_frame;

	  $('.mbwph-image-preview').on('click', function( event ){
		event.preventDefault();
		var divid = $(this).attr("id");
		//alert(divid);
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
		title: 'Select Image',
		button: {
			text: 'Choose'
		},
		multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			var selection = file_frame.state().get('selection');

			selection.map( function( attachment ) {
				//alert(divid);
				attachment = attachment.toJSON();				
				$("#" + divid + " .imgpreview_" + divid).remove();
				$("#" + divid).find(" i.img-remove").remove();
				$("#" + divid).append('<i class="dashicons dashicons-no-alt img-remove"></i><img class="imgpreview_' + divid + '" src="' + attachment.url + '" />');
				$("#" + divid + " .mbwph_image_url").val(attachment.url);
				$("#" + divid + " .image_id").val(attachment.id);
			});
		 
		});

		// Finally, open the modal
		file_frame.open();
	  });
	//Show/Hide Password
	$("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
		
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password span').addClass( "dashicons-hidden" );
            $('#show_hide_password span').removeClass( "dashicons-visibility" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password span').removeClass( "dashicons-hidden" );
            $('#show_hide_password span').addClass( "dashicons-visibility" );
        }
    });
	
	//Accordion
	var acc = document.getElementsByClassName("mwph-accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
		event.preventDefault();
		this.classList.toggle("active");
		var panel = this.nextElementSibling;
		if (panel.style.maxHeight) {
			panel.style.maxHeight = null;
		} else {
			panel.style.maxHeight = panel.scrollHeight + "px";
		} 
		});
	}
	   
	//jQuery Number Slider
	$("#frm_login_top_margin").slider();
		$("#frm_login_top_margin").on("slide", function(slideEvt) {
			$("#marginVal").val(slideEvt.value);
	});	
	$("#frm_login_width").slider();
		$("#frm_login_width").on("slide", function(slideEvt) {
			$("#widthVal").val(slideEvt.value);
	});
	$("#set_logo_size").slider();
		$("#set_logo_size").on("slide", function(slideEvt) {
			$("#logoSizeVal").val(slideEvt.value);
	});
	$("#set_logo_height").slider();
		$("#set_logo_height").on("slide", function(slideEvt) {
			$("#logoHeightVal").val(slideEvt.value);
	});
	
	//Fixed on scroll
	$(window).scroll(function() {
		if($(this).scrollTop()>50) {
			$( ".savebutton" ).addClass("fixed-me");
		} else {
			$( ".savebutton" ).removeClass("fixed-me");
		}
	});

})( jQuery );
