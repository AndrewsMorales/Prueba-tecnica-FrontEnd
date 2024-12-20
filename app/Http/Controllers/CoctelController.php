<?php

namespace App\Http\Controllers;

use App\Models\Coctel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoctelController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('coctel.index');
  }

  /**
   * Obtiene la data de la nube y la manda al data table para su visualizacion
   */
  public function getDataCoctelesCloud(Request $request)
  {
    $mh = curl_multi_init();
    $url = 'https://www.thecocktaildb.com/api/json/v1/1/filter.php?c=Cocktail';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_multi_add_handle($mh, $ch);
    do {
      $status = curl_multi_exec($mh, $active);
      if ($active) {
        curl_multi_select($mh);
      }
    } while ($active && $status == CURLM_OK);
    $response = curl_multi_getcontent($ch);
    $data = ["data" => []];

    if (curl_errno($ch)) {
      $msg = 'Error al hacer la solicitud cURL: ' . curl_error($ch);
    } else {
      $response = json_decode($response);

      if (isset($response->drinks) && is_array($response->drinks)) {
        // Iniciar el proceso de solicitudes múltiples para los detalles de cada cóctel
        $multiHandles = [];
        foreach ($response->drinks as $key => $value) {
          $urlDetail = 'https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=' . $value->idDrink;
          $chDetail = curl_init();
          curl_setopt($chDetail, CURLOPT_URL, $urlDetail);
          curl_setopt($chDetail, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($chDetail, CURLOPT_SSL_VERIFYPEER, false);
          curl_multi_add_handle($mh, $chDetail);

          // Guardar el handle de cada solicitud de detalles
          $multiHandles[$value->idDrink] = $chDetail;
        }

        // Ejecutar solicitudes cURL para los detalles de los cócteles
        do {
          $status = curl_multi_exec($mh, $active);
          if ($active) {
            curl_multi_select($mh);
          }
        } while ($active && $status == CURLM_OK);

        // Procesar las respuestas de los detalles
        foreach ($multiHandles as $id => $chDetail) {
          $responseDetail = curl_multi_getcontent($chDetail);
          if (curl_errno($chDetail)) {
            $msgDetail = 'Error en solicitud de detalles para ' . $id . ': ' . curl_error($chDetail);
            continue; // Continuar con el siguiente
          } else {
            $responseDetail = json_decode($responseDetail);

            if (isset($responseDetail->drinks) && is_array($responseDetail->drinks)) {
              $responseDetail = $responseDetail->drinks[0];

              // Concatenar los ingredientes
              $ingredientes = "";
              for ($i = 1; $i <= 15; $i++) {
                $texto = "strIngredient" . $i;
                if (!empty($responseDetail->$texto)) {
                  if ($i > 1 && $i < 15) {
                    $ingredientes .= ",<br>";
                  }
                  $ingredientes .= $responseDetail->$texto;
                }
              }

              // Añadir los datos del cóctel
              $data['data'][] = [
                $responseDetail->idDrink,
                $responseDetail->strDrink,
                $responseDetail->strInstructionsES,
                $ingredientes,
                '<button class="btn btn-sm btn-success saveNubeDrink" title="Guardar localmente" data-id="' . $responseDetail->idDrink . '"><i class="bi bi-floppy-fill"></i></button>',
              ];
            } else {
              continue;
            }
          }
          curl_multi_remove_handle($mh, $chDetail);
        }
      } else {
        $msg = 'No se encontraron cócteles en la respuesta';
      }
    }
    curl_multi_remove_handle($mh, $ch);
    curl_multi_close($mh);

    return response()->json($data);
  }

  /**
   * Obtiene la data que esta guardada localmente
   */
  public function getDataCoctelesLocal(Request $request)
  {
    // Parámetros enviados por DataTables
    $draw = $request->input('draw');
    $start = $request->input('start', 0);  // Índice de inicio para paginación
    $length = $request->input('length', 10);  // Número de elementos por página
    $search = $request->input('search.value', '');  // Término de búsqueda

    // Obtener la información de la ordenación
    $orderColumnIndex = $request->input('order.0.column');
    $orderDir = $request->input('order.0.dir', 'asc');  // Dirección de ordenación por defecto 'asc'

    // Nombres de las columnas en la base de datos
    $columns = ['nombre', 'instrucciones', 'ingredientes', 'idCloud'];  // Ajusta estos nombres a tus columnas reales

    // Lógica de consulta a la base de datos
    $query = Coctel::query();

    // Si hay término de búsqueda, se filtra
    if ($search) {
      $query->where(function ($query) use ($search) {
        $query->where('nombre', 'like', '%' . $search . '%')
          ->orWhere('instrucciones', 'like', '%' . $search . '%')
          ->orWhere('ingredientes', 'like', '%' . $search . '%')
          ->orWhere('idCloud', 'like', '%' . $search . '%');
      });
    }

    // Aplicar ordenación
    $orderColumn = $columns[$orderColumnIndex];  // Obtener el nombre de la columna a ordenar
    $query->orderBy($orderColumn, $orderDir);  // Ordenar según la columna y dirección

    // Contar el total de registros sin filtros
    $totalRecords = $query->count();

    // Aplicar paginación
    $cocteles = $query->skip($start)
      ->take($length)
      ->get();

    // Contar el total de registros después del filtro de búsqueda
    $filteredRecords = $query->count();

    // Formato de la respuesta para DataTables
    $data = [
      "draw" => $draw,
      "recordsTotal" => $totalRecords,
      "recordsFiltered" => $filteredRecords,
      "data" => $cocteles->map(function ($coctel) {

        return [
          '<img src="' . $coctel->url_imagen . '" alt="Girl in a jacket" width="100" height="100">',
          $coctel->nombre,
          $coctel->instrucciones,
          json_decode($coctel->ingredientes),
          $coctel->idCloud,
          '<button class="btn btn-sm btn-primary my-2 saveLocalDrink" title="Editar localmente" data-id="' . $coctel->id . '"><i class="bi bi-pencil"></i></button>
          <button class="btn btn-sm btn-danger my-2 deleteLocalDrink" title="Eliminar localmente" data-id="' . $coctel->id . '"><i class="bi bi-trash-fill"></i></button>',
        ];
      }),
    ];

    return response()->json($data);
  }


  /**
   * Guarda u actualiza de manera local la bebida seleccionada
   */
  public function saveUpdateDrink(Request $request)
  {
    $ajson = [];
    $dataIn = $request->all();
    $dataSql = [];
    if ($dataIn['isNube'] == 1) {
      $ch = curl_init();
      $url = 'https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=' . $dataIn['idDrink'];
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($ch);
      if (curl_errno($ch)) {
        $ajson['status'] = 0;
        $ajson['msg'] = 'Error:' . curl_error($ch);
        return response()->json($ajson);
      } else {
        $response = json_decode($response);
        if (isset($response->drinks) && is_array($response->drinks)) {
          $response = $response->drinks[0];
          $ingredientes = [];
          for ($i = 1; $i <= 15; $i++) {
            $texto = "strIngredient" . $i;
            if (!empty($response->$texto)) {
              $ingredientes[] = $response->$texto;
            }
          }
          $dataSql['idDrink'] = $response->idDrink;
          $dataSql['nombre'] = $response->strDrink;
          $dataSql['urlImg'] = $response->strDrinkThumb;
          $dataSql['instruciones'] = $response->strInstructionsES;
          $dataSql['ingredientes'] = $ingredientes;
        } else {
          $ajson['status'] = 0;
          $ajson['msg'] = "No fue posible encontrar el coctel seleccionado, vuelva a intentar más tarde.";
          return response()->json($ajson);
        }
      }
      curl_close($ch);
    }
    $coctel = Coctel::where('idCloud', $dataIn['idDrink'])->first();


    if (!isset($dataIn['idLocal']) && !$coctel) {
      $coctel = Coctel::create([
        'nombre' => $dataSql['nombre'],
        'instrucciones' => $dataSql['instruciones'],
        'url_imagen' => $dataSql['urlImg'],
        'ingredientes' => json_encode($dataSql['ingredientes']),
        'idCloud' =>  $dataSql['idDrink'],
      ]);
      $ajson['status'] = 1;
      $ajson['msg'] = "El coctel ha sido agredado correctamente.";
      return response()->json($ajson);
    } else {
      if (!isset($dataIn['idLocal'])) {
        $coctel = Coctel::where('idCloud', $dataIn['idDrink'])->first();
      } else {
        $coctel = Coctel::find($dataIn['idLocal']);
      }

      if (!$coctel) {
        $ajson['status'] = 0;
        $ajson['msg'] = "El coctel a editar no existe.";
        return response()->json($ajson);
      }
      if ($dataIn['isNube'] == 0) {
        $dataSql['idDrink'] = $dataIn['nombreIn'];
        $dataSql['nombre'] = $dataIn['instruccionesIn'];
        $dataSql['urlImg'] = $dataIn['url_imagenIn'];
        $dataSql['instruciones'] = json_encode($dataIn['ingredientesIn']);
        $dataSql['ingredientes'] = $dataIn['idCloudIn'];
      }
      // Actualizar los datos del cóctel existente
      $coctel->update([
        'nombre' => $dataSql['nombre'],
        'instrucciones' => $dataSql['instruciones'],
        'url_imagen' => $dataSql['urlImg'],
        'ingredientes' => json_encode($dataSql['ingredientes']),
        'idCloud' =>  $dataSql['idDrink'],
      ]);

      $ajson['status'] = 1;
      $ajson['msg'] = "El coctel ha sido actualizado correctamente.";
      return response()->json($ajson);
    }
  }
}
