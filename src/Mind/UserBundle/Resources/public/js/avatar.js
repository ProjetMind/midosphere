
$(document).ready(function() { 
    
     var options = { 
        success:       showResponseAvatar,
        beforeSend: function() {
            var bar = $('.bar');
            var percent = $('.percent');
            var status = $('#status');
            var progressBarAvatar = $('#progressBarAvatar');
    
                                    progressBarAvatar.removeClass('hide');
                                    status.empty();
                                    var percentVal = '0%';
                                    bar.width(percentVal)
                                    percent.html(percentVal);
                                },
        uploadProgress: function(event, position, total, percentComplete) {
            var bar = $('.bar');
            var percent = $('.percent');
            
                                    var percentVal = percentComplete + '%';
                                    bar.width(percentVal);
                                    percent.html(percentVal);
                                }, 
        complete: function(xhr) {
            var progressBarAvatar = $('#progressBarAvatar');
                progressBarAvatar.addClass('hide');
		//status.html(xhr.responseText);
	},                        
        delegation: true,
        clearForm: true,        
        resetForm: true        
 
    }; 
    
    $('#formAvatar').ajaxForm(options); 
    
    
});


// post-submit callback 
function showResponseAvatar(responseText, statusText, xhr, $form)  {
    var bar = $('.bar');
    var percent = $('.percent');
    var percentVal = '100%';
    bar.width(percentVal);
    percent.html(percentVal); 
    $("#divAvatar").html(responseText);
}
