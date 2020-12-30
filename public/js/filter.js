var $collectionHolder;
$(document).ready(function () {
    var ajaxNext = false
    $collectionHolder = $('#filters_list')
    var selectedOptions = JSON.parse(document.querySelector('.selected_option').dataset.isAuthenticated)
    console.log(selectedOptions)
    $index = $collectionHolder.children().length
    $('#add_filter').click(function (e) {
        e.preventDefault();
        addNewForm();
    })
    var k
    $('select[id$="_filter"]').change(function () {
        dynamicForm($(this))
    }).each(function(){
        dynamicForm($(this),k++)
        addDeleteButton($(this));
    })
    function addDeleteButton(form){
        var id = 'buttonDelete_'+$index
        let button = `<div class="align-self-end"><button id="${id}" class="btn btn-danger">X</button></div>`
        form.parent().parent().parent().append(button)
        $('#'+id).click(function(e){
            e.preventDefault();
            $(this).parent().parent().remove()
        })
    }

    function dynamicForm(form,k){
        var filterId = form.val();
        $index = form.attr("id").replace(/\D/g,'')
        k = $index
        var $idStart = []
        $idStart[k] = '#advanced_search_filters_' + $index
        $($idStart[k] + '_condition').prop('disabled', !filterId)
        $.post('filter/' + filterId, function(data){
                var selectedVal = $('option:selected', $idStart[k] + '_condition').attr('value');
                $($idStart[k] + '_condition option').remove();
                for (i in data.conditions) {
                    // create option with employee
                    var option = $('<option></option>').attr('value', data.conditions[i][0]).text(data.conditions[i][1]);
                    // set selected employee
                    if (data.conditions[i][0] == selectedVal) {
                        option.attr('selected', 'selected');
                    }
                    // append to employee to employees select
                    $($idStart[k] + '_condition').append(option);
                }
                if (data.option) {
                    if (data.option === 'name' || data.option === 'price') {
                        $($idStart[k] + '_entity_option').hide();
                        $($idStart[k] + '_text_option').show();
                    } else {
                        var selected = null
                        if(selectedOptions) {
                            selectedOptions[k] != null ? selected = selectedOptions[k] : selected = null
                        }
                        $($idStart[k] + '_entity_option option').remove();
                        for (i in data.option) {
                            // create option with employee
                            var option = $('<option></option>').attr('value', data.option[i][0]).text(data.option[i][1]);
                            // set selected employee
                            if (selected == data.option[i][0]) {
                                option.attr('selected', 'selected');
                            }
                            // append to employee to employees select
                            $($idStart[k] + '_entity_option').append(option);

                            $($idStart[k] + '_entity_option').show();
                            $($idStart[k] + '_text_option').hide();
                        }
                    }
                }
        }, 'json');
    }
    function addNewForm() {
// TODO factoriser dynamicForm()
        var prototype = $collectionHolder.data('prototype');
        prototype = prototype.replace(/__name__/g, ++$index)
        $collectionHolder.append(prototype)
        $idStart = '#advanced_search_filters_' + $index
        addDeleteButton($($idStart + '_filter'));
        $($idStart + '_filter').change(function () {
            dynamicForm($(this))
            // var filterId = $(this).val();
            // $($idStart + '_condition').prop('disabled', !filterId)
            //
            // $.post('filter/' + filterId, function (data) {
            //     var selectedVal = $('option:selected', $idStart+'_condition').attr('value');
            //     $($idStart+'_condition option').remove();
            //     for (i in data.conditions) {
            //         // create option with employee
            //         var option = $('<option></option>').attr('value', data.conditions[i][0]).text(data.conditions[i][1]);
            //         // set selected employee
            //         if (data.conditions[i][0] == selectedVal) {
            //             option.attr('selected', 'selected');
            //         }
            //         // append to employee to employees select
            //         $($idStart+'_condition').append(option);
            //
            //     }
            //     if (data.option) {
            //         if (data.option === 'name' || data.option === 'price') {
            //             $($idStart+'_entity_option').hide();
            //             $($idStart+'_text_option').show();
            //         } else {
            //             var selected = document.querySelector('.selected_option').dataset.isAuthenticated
            //             $($idStart+'_entity_option option').remove();
            //             for (i in data.option) {
            //                 // create option with employee
            //                 var option = $('<option></option>').attr('value', data.option[i][0]).text(data.option[i][1]);
            //                 // set selected employee
            //                 if (selected == data.option[i][0]) {
            //                     option.attr('selected', 'selected');
            //                 }
            //                 // append to employee to employees select
            //                 $($idStart+'_entity_option').append(option);
            //
            //                 $($idStart+'_entity_option').show();
            //                 $($idStart+'_text_option').hide();
            //             }
            //         }
            //     }
            // }, 'json');
        })
        dynamicForm($($idStart + '_filter'),k++)
    }


//     $('#advanced_search_filters').change(function () {
//         var filterId = $(this).val();
//         $('#advanced_search_condition').prop('disabled', !filterId)
//
//
//         $.post('filter/' + filterId, function (data) {
//             var selectedVal = $('option:selected', '#advanced_search_condition').attr('value');
//             $('#advanced_search_condition option').remove();
//             for (i in data.conditions) {
//                 // create option with employee
//                 var option = $('<option></option>').attr('value', data.conditions[i][0]).text(data.conditions[i][1]);
//                 // set selected employee
//                 if (data.conditions[i][0] == selectedVal) {
//                     option.attr('selected', 'selected');
//                 }
//                 // append to employee to employees select
//                 $('#advanced_search_condition').append(option);
//
//             }
//             if (data.option) {
//                 if (data.option === 'model' || data.option === 'price') {
//                     $('#advanced_search_entity_option').hide();
//                     $('#advanced_search_text_option').show();
//                 } else {
//                     var selected = document.querySelector('.selected_option').dataset.isAuthenticated
//                     $('#advanced_search_entity_option option').remove();
//                     for (i in data.option) {
//                         // create option with employee
//                         var option = $('<option></option>').attr('value', data.option[i][0]).text(data.option[i][1]);
//                         // set selected employee
//                         if (selected == data.option[i][0]) {
//                             option.attr('selected', 'selected');
//                         }
//                         // append to employee to employees select
//                         $('#advanced_search_entity_option').append(option);
//
//                         $('#advanced_search_entity_option').show();
//                         $('#advanced_search_text_option').hide();
//                     }
//                 }
//             }
//         }, 'json');
//
// })
//
// // request employees by company
// $('#advanced_search_filter').change();
})
