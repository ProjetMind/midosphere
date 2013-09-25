/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() { 

    //Options Informations personelles
     var optionsEditInfos = { 
        //target:        '#groupCommentaires',   // target element(s) to be updated with server response 
        //beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponseEditInfos,  // post-submit callback 
 
        //other available options: 
        //url:       url         // override for form's 'action' attribute 
        type:      'POST',        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        clearForm: true,        // clear all form fields after successful submit 
        resetForm: true,        // reset the form after successful submit 
        delegation: true
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
    
    //options localisation
    var optionsEditInfosLocalisation = { 
        //target:        '#groupCommentaires',   // target element(s) to be updated with server response 
        //beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponseEditInfosLocalisation,  // post-submit callback 
 
        //other available options: 
        //url:       url         // override for form's 'action' attribute 
        type:      'POST',        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        clearForm: true,        // clear all form fields after successful submit 
        resetForm: true,        // reset the form after successful submit 
        delegation: true
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
    
    //Options Informations personelles
     var optionsEditParametresConnexion = { 
        //target:        '#groupCommentaires',   // target element(s) to be updated with server response 
        //beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponseEditParametresConnexion,  // post-submit callback 
 
        //other available options: 
        //url:       url         // override for form's 'action' attribute 
        type:      'POST',        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        clearForm: true,        // clear all form fields after successful submit 
        resetForm: true,        // reset the form after successful submit 
        delegation: true
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 
    
    //Soumission des formulaire avec jquery ajax
    $('#formInfosPersosCompteEdit').ajaxForm(optionsEditInfos); 
    $('#formInfosPersosLocalisationCompteEdit').ajaxForm(optionsEditInfosLocalisation);
    $('#formParametresConnexionCompteEdit').ajaxForm(optionsEditParametresConnexion);
    
        
});




//Fonction exécuté après la modification des infos(clique sur le submit et non le btn annuler)
function showResponseEditInfos(responseText, statusText, xhr, $form)  { 
    $("#informationsPersonelles").html(responseText);
}
function showResponseEditInfosLocalisation(responseText, statusText, xhr, $form)  { 
    $("#localisation").html(responseText);
}
function showResponseEditParametresConnexion(responseText, statusText, xhr, $form)  { 
    $("#parametresConnexion").html(responseText);
}

//Annuler la modifications des informations du user
function annulerEditInfos(idReplace){
    
                var url = Routing.generate('mind_user_compte_render_replace', {'idReplace': idReplace});
                $.ajax({
                type: "GET",
                url: url,
                cache: false,
                success: function(data){
                   $('#'+idReplace).html(data);
                        }
                });    
            return false;
    
}

function hoverBlockEditClick(idReplace, parentContainerId){
    
        
        parentContainer = document.getElementById(parentContainerId);
        
        $('#'+parentContainerId).removeClass('hoverBlock');
        $('#'+parentContainerId).css({'background-color': '#77B5FE'});
        
    
        switch(idReplace){
            
            case 'informationsPersonelles':
                
                var url = Routing.generate('mind_user_compte_edit_infos_persos');
                $.ajax({
                type: "GET",
                url: url,
                cache: false,
                success: function(data){
                   $('#'+idReplace).html(data);
                        }
                });    
            
           break;
           
           case 'localisation':
               
               var url = Routing.generate('mind_user_compte_edit_localisation');
                $.ajax({
                type: "GET",
                url: url,
                cache: false,
                success: function(data){
                   $('#'+idReplace).html(data);
                        }
                }); 
               
               break;
               
            case 'parametresConnexion':

                   var url = Routing.generate('mind_user_compte_edit_parametres_connexion');
                    $.ajax({
                    type: "GET",
                    url: url,
                    cache: false,
                    success: function(data){
                       $('#'+idReplace).html(data);
                            }
                    }); 

                   break;
             
        };
        return false;
}

function hoverBlock(){
    
     
         
             $(".hoverBlock").hover(function(){

            blockParentContainerId = this.id;
            blockId = "#"+blockParentContainerId+" > .hoverHeaderTop > .blockEdit ";
            hoverEdit = blockId;

            //On applique le hover
            $(this).css({
                            'background-color': '#77B5FE'
                        });

            $(blockId).removeClass('hide');

        },function(){
            $(this).css({
                            'background-color': '#FFF'
                        });

            $(blockId).addClass('hide');

        });
    
}


$(function(){
    
    hoverBlock();
    
});



