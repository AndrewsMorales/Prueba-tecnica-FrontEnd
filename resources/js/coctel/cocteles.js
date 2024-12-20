$(document).ready(function () {
  new DataTable('#cotelesCloud', {
    ajax: {
      url: ApiRestUrl.getDataCoctelesCloud,
      type: 'POST',
      data: function (d) {
        return $.extend({}, d, {
          _token: $('meta[name="csrf-token"]').attr('content')
        });
      },
      error: function (xhr, error, thrown) {
        // Manejo de errores si es necesario
        console.error('Error al cargar los datos:', error);
        // Puedes mostrar un mensaje de error si lo deseas
      }
    },
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json',
      emptyTable: 'No hay datos disponibles', // Texto cuando no haya datos
      zeroRecords: 'No se encontraron registros', // Texto cuando no se encuentren registros coincidentes
    },
    responsive: true,
    autoWidth: false,
    pageLength: 10,
    lengthMenu: [10, 25, 50, 75, 100],
    pagingType: 'simple_numbers',
  });


  new DataTable('#cotelesLocal', {
    ajax: {
      url: ApiRestUrl.getDataCoctelesLocal,
      type: 'POST',
      data: function (d) {
        return $.extend({}, d, {
          _token: $('meta[name="csrf-token"]').attr('content')
        });
      }
    },
    processing: true,
    serverSide: true,
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
    },
    responsive: true,
    autoWidth: false,
    pageLength: 10,
    lengthMenu: [10, 25, 50, 75, 100],
    pagingType: 'simple_numbers',
  });

  $(document).on('click', '.saveLocalDrink', function (e) {
    let idDrink = $(this).data('id');
    saveLocalDrink(idDrink);
  });
});
function saveLocalDrink(idDrink) {

};
