var lang = {
    "emptyTable":     "Aucune données disponibles",
    "info":           "_START_ à _END_ sur _TOTAL_",
    "infoEmpty":      "0 à 0 sur 0",
    "infoFiltered":   "(filtré à partir de _MAX_ lignes totales)",
    "infoPostFix":    "",
    "thousands":      ".",
    "lengthMenu":     "Afficher _MENU_ lignes",
    "loadingRecords": "Chargement...",
    "processing":     "En cours...",
    "search":         "Rechercher:",
    "zeroRecords":    "Aucune ligne trouvée",
    "paginate": {
        "first":      "Première",
        "last":       "Dernière",
        "next":       "Suivante",
        "previous":   "Précédente"
    },
    "aria": {
        "sortAscending":  ": Trier sur la colonne (A-Z)",
        "sortDescending": ": Trier sur la colonne (Z-A)"
    }
};

(function($){

	$('.datatable').DataTable({
		pageLength : 25,
		language: lang,
        autoWidth: false,
        bRetrieve: true,
        columnDefs: [
            { "orderable": false, "targets": 0 }
        ]
	});

    $('.datatable-playlist').DataTable({
        pageLength : 25,
        language: lang,
        autoWidth: false,
        bRetrieve: true,
        columnDefs: [
            { "orderable": false, "targets": 0 }
        ]
    });

})(jQuery)