

function newDestinataire(emailCount, ui){
   
            var emailList = jQuery('#participants-fields-list');

            // parcourt le template prototype
            var newWidget = emailList.attr('data-prototype');
            // remplace les "__name__" utilisés dans l'id et le nom du prototype
            // par un nombre unique pour chaque email
            // le nom de l'attribut final ressemblera à name="contact[emails][2]"
            newWidget = newWidget.replace(/__name__/g, emailCount);
            emailCount++;

            // créer une nouvelle liste d'éléments et l'ajoute à notre liste
            var newLi = jQuery('<li></li>').html(newWidget);
            newLi.appendTo(jQuery('#participants-fields-list'));

            $('#participants-fields-list > li:last > input').attr('value', ui.item.idUser);
            
            return emailCount;
    
};

function newDestinataireDeletable(emailCount, ui){
    
    var destinataireName = ui.item.value;
    var parentUl = document.getElementById('ulInputAutocomplete');
    var firstChild = parentUl.firstElementChild;
    var btnClosing = '<button id="'+emailCount+'" type="button" class="close" data-dismiss="alert">×</button>'
                       + destinataireName;
    var newDestinataire = jQuery('<li class="alert alert-success"></li>').html(btnClosing);
    
    //ADD
    jQuery(newDestinataire).insertBefore(firstChild);
    
    return false;
}

function deleteDestinataire(){
    
    jQuery('#ulInputAutocomplete').on('click', 'button[class="close"]', function(){
        
        var idInput = 'mind_mpbundle_conversationtype_tabParticipants_'+this.id;
        jQuery('#'+idInput).parent().remove();
        this.parent().remove();
        
        //$(document).on('click.alert.data-api', dismiss, Alert.prototype.close)
        return false;
    });
}

function split( val ) {
    
    return val.split( /,\s*/ );

}

function extractLast( term ) {
    
    return split( term ).pop();

}

jQuery(function(){
    deleteDestinataire();
});
               
$(function() {



$( "#tabDestinataires" )
// don't navigate away from the field on tab when selecting an item
    .bind( "keydown", function( event ) {
        
        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "ui-autocomplete" ).menu.active ) {
        
           //event.preventDefault();
        }
    }).autocomplete({

        minLength: 1,
        
        source: function( request, response ) {
            
            var url = Routing.generate('mind_message_nouveau_conversation_object', {'terms': extractLast(request.term)});
            
            return $.ajax({
                type: "POST",
                dataType: "json",
                url: url,
                cache: false,
                success: function(data){
                    
                     response( $.ui.autocomplete.filter(
                        data, extractLast( request.term ) ) );

                }
            });
        },
        html: true, 
       messages: {
            noResults: '',
            results: function() {}
        },      
        position: { my: "left top", at: "left bottom", collision: "none" },        
        select: function( event, ui ) {
            
            var terms = split( this.value );
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push(ui.item.value );
            // add placeholder to get the comma-and-space at the end
            //terms.push( "" );
            //this.value = terms.join( ", " );
            
            newDestinataireDeletable(emailCount, ui);
            emailCount = newDestinataire(emailCount, ui);
            
            this.value = "";
            
            return false;
        }
    });
});