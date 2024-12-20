$(document).ready(function () {
  var tableCloud = new DataTable('#cotelesCloud', {
    ajax: {
      url: ApiRestUrl.getDataCoctelesCloud,
      type: 'POST',
      data: function (d) {
        return $.extend({}, d, {
          _token: $('meta[name="csrf-token"]').attr('content')
        });
      },
      error: function (xhr, error, thrown) {
        console.error('Error al cargar los datos:', error);
      }
    },
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json',
      emptyTable: 'No hay datos disponibles',
      zeroRecords: 'No se encontraron registros'
    },
    responsive: true,
    autoWidth: false,
    pageLength: 10,
    lengthMenu: [10, 25, 50, 75, 100],
    pagingType: 'simple_numbers',
    columnDefs: [
      {
        targets: -1,
        orderable: false
      }
    ]
  });

  var tableLocal = new DataTable('#cotelesLocal', {
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
    columnDefs: [
      {
        targets: [0, 4, -1], // Índices de las columnas donde se desactiva el orden
        orderable: false
      }
    ]
  });

  // Manejo del cambio de pestañas
  $('.clickLink').on('click', function (e) {
    var target = $(this).attr('id');
    if (target == 'coctelCloud-tab') {
      //tableCloud.ajax.reload(null, false); 
    } else if (target == 'coctelLocal-tab') {
      tableLocal.ajax.reload(null, false);
    }
  });


  $(document).on('click', '.saveNubeDrink', function (e) {
    let idDrink = $(this).data('id');
    saveLocalDrink(idDrink);
  });
});
function saveLocalDrink(idDrink) {
  $.ajax({
    type: "post",
    url: ApiRestUrl.saveUpdateDrink,
    data: { 'idDrink': idDrink, 'isNube': 1 },
    dataType: "json",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (response) {
      console.log(response);

    },
    error: function (error) {
      console.log(error);
    }
  });
};
