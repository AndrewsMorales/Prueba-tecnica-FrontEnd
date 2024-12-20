<x-app-layout>
  @vite(['resources/css/coctel/cocteles.css'])

  <div class="px-3">
    <ul class="nav nav-tabs nav-pills justify-content-center border-0" id="myTab" role="tablist">
      <li class="nav-item mx-2" role="presentation">
        <button class="nav-link clickLink fw-bolder active" id="coctelCloud-tab" data-bs-toggle="tab" data-bs-target="#coctelCloud-tab-pane" type="button" role="tab" aria-controls="coctelCloud-tab-pane" aria-selected="true">
          En la Nube
        </button>
      </li>
      <li class="nav-item mx-2" role="presentation">
        <button class="nav-link clickLink fw-bolder" id="coctelLocal-tab" data-bs-toggle="tab" data-bs-target="#coctelLocal-tab-pane" type="button" role="tab" aria-controls="coctelLocal-tab-pane" aria-selected="false">
          Localmente
        </button>
      </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
      <div class="tab-pane fade show active" id="coctelCloud-tab-pane" role="tabpanel" aria-labelledby="coctelCloud-tab" tabindex="0">
        <div class="card">
          <div class="card-body">
            <table id="cotelesCloud" class="table tableCoctel">
              <thead>
                <tr>
                  <th>ID Drink</th>
                  <th>Nombre</th>
                  <th>Instrucciones</th>
                  <th>Ingredientes</th>
                  <th>Acciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="coctelLocal-tab-pane" role="tabpanel" aria-labelledby="coctelLocal-tab" tabindex="0">
        <div class="card">
          <div class="card-body">
            <table id="cotelesLocal" class="table tableCoctel">
              <thead>
                <tr>
                  <th>Imagen</th>
                  <th>Nombre</th>
                  <th>Instrucciones</th>
                  <th>Ingredientes</th>
                  <th>Id Nube</th>
                  <th>Acciones</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalSaveUpdateCoctel" tabindex="-1" aria-labelledby="modalSaveUpdateCoctelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalSaveUpdateCoctelLabel">Editar Coctel</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" class="form-control">
          <label for="instruciones">Instruciones</label>
          <textarea name="instruciones" id="instruciones" rows="5" class="form-control"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" id="updateCoctelLocal" class="btn btn-primary">Actualizar</button>
          <button type="button" id="updateCoctelNube" class="btn btn-success">Actualizar desde la nube</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    var ApiRestUrl = [];
    ApiRestUrl['getDataCoctelesCloud'] = "{{ route('coctel.getDataCoctelesCloud') }}";
    ApiRestUrl['getDataCoctelesLocal'] = "{{ route('coctel.getDataCoctelesLocal') }}";
    ApiRestUrl['saveUpdateDrink'] = "{{ route('coctel.saveUpdateDrink') }}";
    ApiRestUrl['getCoctelId'] = "{{ route('coctel.getCoctelId') }}";
    ApiRestUrl['deleteDrink'] = "{{ route('coctel.deleteDrink') }}";
  </script>
  @vite(['resources/js/coctel/cocteles.js'])
</x-app-layout>