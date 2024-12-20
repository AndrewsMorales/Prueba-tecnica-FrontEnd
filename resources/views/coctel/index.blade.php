<x-app-layout>
  @vite(['resources/css/coctel/cocteles.css'])

  <div class="px-3">
    <ul class="nav nav-tabs nav-pills justify-content-center border-0" id="myTab" role="tablist">
      <li class="nav-item mx-2" role="presentation">
        <button class="nav-link fw-bolder active" id="coctelCloud-tab" data-bs-toggle="tab" data-bs-target="#coctelCloud-tab-pane" type="button" role="tab" aria-controls="coctelCloud-tab-pane" aria-selected="true">
          En la Nube
        </button>
      </li>
      <li class="nav-item mx-2" role="presentation">
        <button class="nav-link fw-bolder" id="coctelLocal-tab" data-bs-toggle="tab" data-bs-target="#coctelLocal-tab-pane" type="button" role="tab" aria-controls="coctelLocal-tab-pane" aria-selected="false">
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
                  <th>First name</th>
                  <th>Last name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Start date</th>
                  <th>Salary</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    var ApiRestUrl = [];
    ApiRestUrl['getDataCoctelesCloud'] = "{{ route('coctel.getDataCoctelesCloud') }}";
    ApiRestUrl['getDataCoctelesLocal'] = "{{ route('coctel.getDataCoctelesLocal') }}";
    ApiRestUrl['saveUpdateDrink'] = "{{ route('coctel.saveUpdateDrink') }}";
  </script>
  @vite(['resources/js/coctel/cocteles.js'])
</x-app-layout>
