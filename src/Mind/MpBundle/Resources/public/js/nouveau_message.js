$(document).ready(function() { 

     var optionsMessage = { 
        //target:        '#groupCommentaires',   // target element(s) to be updated with server response 
        //beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponseMessage,  // post-submit callback 
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        clearForm: true,        // clear all form fields after successful submit 
        resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
    
    $('#formNouveauMessage').ajaxForm(optionsMessage); 
});


// post-submit callback 
function showResponseMessage(responseText, statusText, xhr, $form)  { 
 
    $("#msgContent").append(responseText);
}