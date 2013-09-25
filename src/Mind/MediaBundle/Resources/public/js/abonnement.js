
$(document).ready(function() { 

     var optionsAbonnement = { 
        //target:        '#groupCommentaires',   // target element(s) to be updated with server response 
        //beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponseAbonnement,  // post-submit callback 
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        clearForm: false,        // clear all form fields after successful submit 
        resetForm: false        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
    
    $('#formAbonnement').ajaxForm(optionsAbonnement); 
});


// post-submit callback 
function showResponseAbonnement(responseText, statusText, xhr, $form)  { 
 
    $("#formAbonnement").html(responseText);
}

