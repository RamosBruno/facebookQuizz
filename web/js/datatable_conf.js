$(document).ready(function() {
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, 100, -1 ],
            [ '10 lignes', '25 lignes', '50 lignes', '100 lignes', 'Voir tout' ]
        ],
        buttons: [
            {
                extend: 'pageLength',
                text: 'Nombre de lignes visible'
            },
            {
                extend: 'colvis',
                text: 'Colonnes à afficher'
            },
            {
                extend: 'excelHtml5',
                text: 'Export excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                text: 'Export PDF',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ],
        "language": {
            "buttons": {
                "pageLength": {
                    "_": "%d lignes",
                    "-1": "Voir tout"
                }
            },
            "sProcessing":     "Traitement en cours...",
            "sSearch":         "Rechercher&nbsp;sur&nbsp;toutes&nbsp;les&nbsp;colonnes&nbsp;:",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
        }
    });
});