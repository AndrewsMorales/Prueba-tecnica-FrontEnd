import 'bootstrap';
const Toast = Swal.mixin({ toast: true, position: "top-end", showConfirmButton: false, timer: 4000, timerProgressBar: true, didOpen: (toast) => { toast.onmouseenter = Swal.stopTimer; toast.onmouseleave = Swal.resumeTimer; } });
var tableLocal;
var tableCloud;
var modalSaveUpdateCoctel = new bootstrap.Modal(document.getElementById("modalSaveUpdateCoctel"));
$(document).ready(function () {
  tableCloud = new DataTable('#cotelesCloud', {
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

  tableLocal = new DataTable('#cotelesLocal', {
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
    saveDrink(idDrink, null, 1);
  });
  $(document).on('click', '#updateCoctelLocal', function (e) {
    let idLocal = $(this).data('id');
    let idDrink = $(this).data('idNube');
    console.log(idLocal, idDrink);

    saveDrink(idDrink, idLocal, 0);
  });
  $(document).on('click', '#updateCoctelNube', function (e) {
    let idLocal = $(this).data('id');
    let idDrink = $(this).data('idNube');;
    saveDrink(idDrink, idLocal, 1);
  });
  $(document).on('click', '.getCoctelId', function (e) {
    let idDrink = $(this).data('id');
    getCoctelID(idDrink);
  });
  $(document).on('click', '.deleteLocalDrink', function (e) {
    let idDrink = $(this).data('id');
    deleteLocalDrink(idDrink);
  });
});
function saveDrink(idDrink, idLocal, nube) {
  if (nube == 1) {
    var datos = { 'idDrink': idDrink, 'isNube': 1 };
  } else {
    var datos = { 'idLocal': idLocal, 'idDrink': idDrink, 'isNube': 0, nombreIn: $('#modalSaveUpdateCoctel input#nombre').val(), instruccionesIn: $('#modalSaveUpdateCoctel textarea#instruciones').val() };
  }
  $.ajax({
    type: "post",
    url: ApiRestUrl.saveUpdateDrink,
    data: datos,
    dataType: "json",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (response) {
      if (response.status === 1) {
        Toast.fire({
          icon: "success",
          title: response.msg
        });
        tableLocal.ajax.reload(null, false);
        modalSaveUpdateCoctel.hide();
      } else {
        // Alerta de error en la respuesta
        Swal.fire({
          icon: "error",
          title: "Error",
          text: response.msg
        });
      }

    },
    error: function (error) {
      // Alerta de error en la solicitud AJAX
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Hubo un problema al intentar eliminar el cóctel. Intenta nuevamente."
      });
      console.error(error);
    }
  });
};
function getCoctelID(idDrink) {
  $.ajax({
    type: "post",
    url: ApiRestUrl.getCoctelId,
    data: { 'idLocal': idDrink },
    dataType: "json",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (response) {
      if (response.status === 1) {
        $('#modalSaveUpdateCoctel input#nombre').val(response.data.nombre);
        $('#modalSaveUpdateCoctel textarea#instruciones').val(response.data.instrucciones);
        $('#modalSaveUpdateCoctel button#updateCoctelLocal').data('id', response.data.id);
        $('#modalSaveUpdateCoctel button#updateCoctelNube').data('id', response.data.id);
        $('#modalSaveUpdateCoctel button#updateCoctelLocal').data('idNube', response.data.idCloud);
        $('#modalSaveUpdateCoctel button#updateCoctelNube').data('idNube', response.data.idCloud);
        modalSaveUpdateCoctel.show();
      } else {
        // Alerta de error en la respuesta
        Swal.fire({
          icon: "error",
          title: "Error",
          text: response.msg
        });
      }
    },
    error: function (error) {
      // Alerta de error en la solicitud AJAX
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Hubo un problema al intentar eliminar el cóctel. Intenta nuevamente."
      });
      console.error(error);
    }
  });
};

function deleteLocalDrink(idDrink) {
  // Mostrar alerta de confirmación antes de eliminar
  Swal.fire({
    title: "¿Estás seguro?",
    text: "Esta acción eliminará el cóctel. No podrás revertirla.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      // Si se confirma, proceder con la eliminación
      $.ajax({
        type: "post",
        url: ApiRestUrl.deleteDrink,
        data: { 'idLocal': idDrink },
        dataType: "json",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
          if (response.status === 1) {
            Toast.fire({
              icon: "success",
              title: response.msg
            });
            tableLocal.ajax.reload(null, false);
          } else {
            // Alerta de error en la respuesta
            Swal.fire({
              icon: "error",
              title: "Error",
              text: response.msg
            });
          }
        },
        error: function (error) {
          // Alerta de error en la solicitud AJAX
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un problema al intentar eliminar el cóctel. Intenta nuevamente."
          });
          console.error(error);
        }
      });
    }
  });
}

