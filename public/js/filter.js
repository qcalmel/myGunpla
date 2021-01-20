var $collectionHolder;
var k;
$(document).ready(function () {
    // Récupération de l'element qui contient la liste des filtres
    $collectionHolder = $('#filters_list')
    // Récupération des options sélectionnées sous forme de tableau à partir de données JSON
    var selectedOptions = JSON.parse(document.querySelector('.selected_option').dataset.selectedOptions)
    // Définition de l'index des filtres par rapport à ceux déjà existant pour la création de nouveaux filtres
    $index = $collectionHolder.children().length
    // Ajout de la fonction "ajouter un filtre" au bouton correspondant
    $('#add_filter').click(function (e) {
        e.preventDefault();
        addNewForm();
    })

    // Génération du contenu pour les listes déroulantes des filtres déjà existants et
    // ajout de cette fonction lorsque qu'un changement de type de filtre survient
    $('select[id$="_filter"]').change(function () {
        dynamicForm($(this))
    }).each(function () {
        dynamicForm($(this), k++)
        addDeleteButton($(this));
    })
    if ($index === 0){
        addNewForm();
    }
    // Fonction permettant l'ajout d'un bouton de suppression sur un filtre
    function addDeleteButton(form) {
        var id = 'buttonDelete_' + $index
        var button = `<div class="align-self-end"><button id="${id}" class="btn btn-danger">X</button></div>`
        form.parent().parent().parent().append(button)
        $('#' + id).click(function (e) {
            e.preventDefault();
            $(this).parent().parent().remove()
        })
    }
    // Fonction qui permet la récupération des données lié au type de filtre
    // grâce à une requête AJAX et la restauration de l'option sélectionnée
    // lors du rechargement de la page sur les filtres existants
    function dynamicForm(form, k) {
        var filterId = form.val();
        $index = form.attr("id").replace(/\D/g, '')
        k = $index
        var $idStart = []
        $idStart[k] = '#advanced_search_filters_' + $index
        $($idStart[k] + '_condition').prop('disabled', !filterId)
        $.post('filter/' + filterId, function (data) {
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
                    if (selectedOptions) {
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
    // Fonction permettant l'ajout d'un filtre à partir du prototype crée par
    // le formulaire de Symfony
    function addNewForm() {
        var prototype = $collectionHolder.data('prototype');
        prototype = prototype.replace(/__name__/g, ++$index)
        $collectionHolder.append(prototype)
        $idStart = '#advanced_search_filters_' + $index
        addDeleteButton($($idStart + '_filter'));
        $($idStart + '_filter').change(function () {
            dynamicForm($(this))
        })
        dynamicForm($($idStart + '_filter'), k++)
    }
})
