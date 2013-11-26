//$(function(){
//
////remote source (advanced)
//$('#addDomaine').editable({
//    select2: {
//                placeholder: 'Séléctionnez un domaine',
//                allowClear: true,
//                minimumInputLength: 2,
//                id: function (item) {
//                                        return item.domaineId;
//                },
//                ajax: {
//                    
//                        url: Routing.generate('mind_site_domaine_for_form'),
//                        dataType: 'json',
//                        data: function (term, page) {
//                                                        return { termsSearch: term };
//                        },
//                        results: function (data, page) {
//                                                        return { results: data };
//                        }
//                },
//                formatResult: function (item) {
//                        return item.domaineName;
//                },
//                formatSelection: function (item) {
//                        return item.domaineName;
//                },
//                initSelection: function (element, callback) {
//                        return $.get('/getCountryById', { query: element.val() }, function (data) {
//                                                                                                    callback(data);
//                        });
//                }
//    }
//
//});
//});