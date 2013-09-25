/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function getDomaines(){

    //Si on clique sur un domaine
    $("#containerDiv_AddAvis_Domaines > label > input").click(function(){
        
        idDuDomaineParent = this.value;
        leLabelContainer = this.id;
        
        
        var url = Routing.generate('mind_site_get_domaine_ajax', { id: idDuDomaineParent});
        
        //Envoi de la requete ajax
        $.ajax({
            type: "POST",
            url: url,
            cache: false,
            success: function(data){
                $('label[for='+leLabelContainer+']').append(data);
               //$('#blockCompte1-1').html(data);
               //$(".loading").hide();
            }
        });  
    });

}

$(function(){
    getDomaines();
});