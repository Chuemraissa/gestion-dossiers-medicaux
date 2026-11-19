$(function () {
    // Recherche : filtre les lignes du tableau de l'onglet (ou de la page) où se trouve le champ.
    // Chaque onglet a son propre champ de recherche et son propre tableau.
    $(document).on('input', 'input[type="search"]', function () {
        var valeur = $(this).val().toLowerCase();
        var zone = $(this).closest('.tab-pane');

        if (zone.length === 0) {
            zone = $(this).closest('.container-fluid');
        }

        zone.find('table tbody tr').each(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(valeur) > -1);
        });
    });

    // Suppression : demande une confirmation avant de suivre un lien de suppression
    $(document).on('click', 'a[href*="/delete-"]', function (event) {
        var message = $('body').data('confirmer-suppression') || 'Supprimer ?';

        if (!window.confirm(message)) {
            event.preventDefault();
        }
    });
});
