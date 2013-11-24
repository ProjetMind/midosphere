
$(function(){
    
    var url = Routing.generate('mind_mp_json_user');
    $('#destinataires').select2({
            multiple: true,
            minimumInputLength: 2,
            placeholder: 'Destinataires',
            width: 150,
            allowClear: true,
            id: function (item) {
                    return item.id;
                },
            ajax: {
                url: url,
                dataType: 'json',
                data: function (term, page) {
                            return { searchTerms: term };
                        },
                results: function (data, page) {
                            return { results: data };
                        }
                },
            formatResult: function (item) {      
                return item.username;
            },
            formatSelection: function (item) {
                var inputHtml = '<input id="'+item.id+'" value="'+item.id+'" type="hidden" id="mind_mpbundle_messagetype_destinataires'+item.id+'" name="mind_mpbundle_messagetype[destinataires]['+item.id+']" required="required" />';
                           
                return item.username+inputHtml;
            }    
            
        });
        
        
});
