/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function jeVote(){
    
    $('#jeVote > button').click(function(){
        
        typeOpinion = this.id;
        idAvis = document.getElementById('inputIdAvis').value;
        url = Routing.generate('mind_media_opinion_vote', {idAvis: idAvis, typeOpinion: typeOpinion });
        
        $.ajax({
        type: "POST",
        url: url,
        cache: false,
        success: function(data){
           $('#messageVote').html(data);
            }
        });    
        return false;
        
    });
}

$(function(){
    jeVote();
});