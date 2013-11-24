
//HEADER NOTIFICATION MENU
sfHover = function() {
        var sfEls = document.getElementById("headerNotificationMenu").getElementsByTagName("li");
        for (var i=0; i<sfEls.length; i++) {
                sfEls[i].onmouseover=function() {
                        this.className+=" sfhover";
                }
                sfEls[i].onmouseout=function() {
                        this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
                }
        }
}
if (window.attachEvent) window.attachEvent("onload", sfHover);

function headerNotificationMenuOnBlur(li){
    alert("etst");
}

function headerNotificationMenuOnClick(){
    
    $(function(){
    
        $("#notification>#headerNotificationMenu>li>ul").css({
                                                                left: 'auto', 
                                                                minHeight:'0'
                                                            });
      
        $('#notification>#headerNotificationMenu>li[class="sfhover"]>ul').css({
                                                                    left: 'auto', 
                                                                    minHeight:'0'
                                                                });
    })
}

//FIN HEADER NOTIFICATION MENU

/*#notification #headerNotificationMenu li:hover ul ul, #notification #headerNotificationMenu li.sfhover ul ul  Sous-sous-listes lorsque la souris passe sur un élément de liste 
{
        left: -999em;  On expédie les sous-sous-listes hors du champ de vision 
}
 
#notification #headerNotificationMenu li:hover ul, #notification #headerNotificationMenu li li:hover ul, #notification #headerNotificationMenu li.sfhover ul, #notification #headerNotificationMenu li li.sfhover ul   Sous-listes lorsque la souris passe sur un élément de liste ET sous-sous-lites lorsque la souris passe sur un élément de sous-liste 
{
        left: auto;  Repositionnement normal 
        min-height: 0;  Corrige un bug sous IE 
}*/
