<?php

namespace App\Http\Controllers;

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
                                    if ($i > 1) {
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
                                '<button class="btn btn-sm btn-success saveLocalDrink" title="Guardar localmente" data-id="' . $responseDetail->idDrink . '"><i class="bi bi-floppy-fill"></i></button>',
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
        $data = [
            "draw" => 1,
            "recordsTotal" => 57,
            "recordsFiltered" => 57,
            "data" => [
                [
                    "Airi",
                    "Satou",
                    "Accountant",
                    "Tokyo",
                    "28th Nov 08",
                    "$162,700",
                ],
                [
                    "Angelica",
                    "Ramos",
                    "Chief Executive Officer (CEO)",
                    "London",
                    "9th Oct 09",
                    "$1,200,000",
                ],
                [
                    "Ashton",
                    "Cox",
                    "Junior Technical Author",
                    "San Francisco",
                    "12th Jan 09",
                    "$86,000",
                ],
                [
                    "Bradley",
                    "Greer",
                    "Software Engineer",
                    "London",
                    "13th Oct 12",
                    "$132,000",
                ],
                [
                    "Brenden",
                    "Wagner",
                    "Software Engineer",
                    "San Francisco",
                    "7th Jun 11",
                    "$206,850",
                ],
                [
                    "Brielle",
                    "Williamson",
                    "Integration Specialist",
                    "New York",
                    "2nd Dec 12",
                    "$372,000",
                ],
                [
                    "Bruno",
                    "Nash",
                    "Software Engineer",
                    "London",
                    "3rd May 11",
                    "$163,500",
                ],
                [
                    "Caesar",
                    "Vance",
                    "Pre-Sales Support",
                    "New York",
                    "12th Dec 11",
                    "$106,450",
                ],
                [
                    "Cara",
                    "Stevens",
                    "Sales Assistant",
                    "New York",
                    "6th Dec 11",
                    "$145,600",
                ],
                [
                    "Cedric",
                    "Kelly",
                    "Senior Javascript Developer",
                    "Edinburgh",
                    "29th Mar 12",
                    "$433,060",
                ],
            ],
        ];

        return response()->json($data);
    }

    /**
     * Guarda de manera local la bebida seleccionada
     */
    public function saveUpdateDrink(Request $request)
    {

    }
}
