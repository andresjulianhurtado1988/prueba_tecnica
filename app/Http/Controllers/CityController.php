<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    public function showAll()
    {
        $cities = City::all();

        return response()->json([
                'code' => 200,
                'status' => 'success',
                'cities' => $cities
            ]);
    }

    public function showCity($id)
    {

     $cities = City::where('city_id', $id)->first();
 
     if (is_object($cities)) {
 
         $data = array('status' => 'success',
                         'code' => 200,
                         'cities' => $cities
                     );
     
     }else {
         $data = array('status' => 'error',
                         'code' => 404,
                         'message' => 'La Ciudad no existe'
                     );
     }
 

         return response()->json($data, $data['code']);
         
    }

    public function registerCity(Request $request)
    {

             // recoger datos por post
             $json = $request->input('json', null);
             $params_array = json_decode($json, true);
 
             if (!empty($params_array)) {
 
               // validar los datos
             $validate = \Validator::make($params_array, [
                 'city_name' => 'required',
             ]);
 
             if ($validate->fails()) {
                 $data = array('status' => 'error',
                             'code' => 400,
                             'message' => 'La Ciudad no se ha creado',
                         );
                         
             }else{
 
                 // guardar la categoría
 
                 $cities = new City();
                 $cities->city_name = $params_array['city_name'];
                 $cities->save();
                    
                 $data = array('status' => 'success',
                             'code' => 200,
                             'cities' => $cities
                         );
             }
             
         }else {
             $data = array('status' => 'error',
             'code' => 400,
             'message' => 'No se ha enviado ninguna Ciudad',
         );
         }
             // devolver resultado
             return response()->json($data, $data['code']);
 
    }

    public function updateCity($id, Request $request)
    {
             // recoger los datos

             $json = $request->input('json', null);
 
             $params_array = json_decode($json, true); // obtengo un array 
 
             if (!empty($params_array)) {
               
                 $validate = \Validator::make($params_array, [
                     'city_name' => 'required',
                 ]);
     
           
                     unset($params_array['city_id']);
                     unset($params_array['created_at']);
                     // actualizar usuario en DB
   
                     $cities = City::where('city_id', $id)->update(
                       $params_array
                     );
 
                     $data = array('status' => 'success',
                     'code' => 200,
                     'message' => 'Se ha actualizado la Ciudad',
                     'cities' => $params_array
                 );
 
             }else {
                 $data = array('status' => 'error',
                 'code' => 400,
                 'message' => 'No se ha enviado ninguna Ciudad',
             );
             }
 
             return response()->json($data, $data['code']);
 
    }
}
