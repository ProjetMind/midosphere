function clickSousDomaine(){
    
    idRadio2 = "#mind_sitebundle_domainetype_niveau_0";
    idRadio1 = "#mind_sitebundle_domainetype_niveau_1";
    
    $(idRadio1).click(function(){
        $('#listeDomaineSup').removeClass('hide');
        $('#mind_sitebundle_domainetype_domaineSup').attr('required', 'required');
    });

    $(idRadio1).click(function(){
        $('#listeDomaineSup').removeClass('hide');
        $('#mind_sitebundle_domainetype_domaineSup').attr('required', 'required');
        alert(valeur = document.getElementById('#mind_sitebundle_domainetype_domaineSup').options[select.selectedIndex].value);
        $("#isNotDomainePrincipale").attr('value', valeur);
    });

    
    $(idRadio2).click(function(){
        $('#listeDomaineSup').addClass('hide');
        $('#mind_sitebundle_domainetype_domaineSup').removeAttr('required');
    });
}

function addDomaineUn(){
    
    $("#formAddDomaineUn").submit(function(){ 
    $.ajax({
        type: "POST",
        url: "{{ path('mind_admin_domaine')}}",
        cache: false,
        success: function(data){
           $('.domaineUn').html(data);
        }
    });    
    return false;
});
}


$(function  () {
  $("ul.domaineUn").sortable();
});
