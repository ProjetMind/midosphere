

function supprimer(idAvis){
    
    var options = { 
        success:       showResponseSupprimer,
        dataType:  'json'
        
    }; 
    
    $('#form'+idAvis).ajaxForm(options); 
}

// post-submit callback 
function showResponseSupprimer(data)  {
    $('#'+data.id).remove();
}