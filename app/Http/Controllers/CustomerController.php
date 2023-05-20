<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function showAll()
    {

        $customer = DB::table('customers AS cu')
        ->select('cu.customer_id','cu.customer_id_number',
                'cu.customer_birth_date',
                'cu.customer_address','cu.customer_phone', 'c.city_name')
        ->leftjoin('cities AS c', 'c.city_id','=','cu.city_id')
        ->get();
       
        return response()->json([
                'code' => 200,
                'status' => 'success',
                'customer' => $customer
            ]);
    }

    public function showCustomer($id)
    {

        $customers = DB::table('customers AS cu')
        ->select('cu.customer_id','cu.customer_id_number',
                'cu.customer_birth_date',
                'cu.customer_address','cu.customer_phone', 'c.city_name')
        ->leftjoin('cities AS c', 'c.city_id','=','cu.city_id')
        ->where('cu.customer_id', $id)
        ->first();

     if (is_object($customers)) {
 
         $data = array('status' => 'success',
                         'code' => 200,
                         'customer' => $customers
                     );
     
     }else {
         $data = array('status' => 'error',
                         'code' => 404,
                         'message' => 'La Cliente no existe'
                     );
     }
 

         return response()->json($data, $data['code']);
         
    }

    public function registerCustomer(Request $request)
    {

             // recoger datos por post
             $json = $request->input('json', null);
             $params_array = json_decode($json, true);
 
             if (!empty($params_array)) {
 
               // validar los datos
             $validate = \Validator::make($params_array, [
                 'city_id' => 'required',
                 'customer_id_number' => 'required',
                 'customer_birth_date' => 'required',
                 'customer_address' => 'required',
                 'customer_phone' => 'required',
             ]);
 
             if ($validate->fails()) {
                 $data = array('status' => 'error',
                             'code' => 400,
                             'message' => 'El Cliente no se ha creado',
                         );
                         
             }else{
 
                 // guardar la cliente

                 $customers = new Customer();
                 $customers->city_id = $params_array['city_id'];
                 $customers->customer_id_number = $params_array['customer_id_number'];
                 $customers->customer_birth_date = $params_array['customer_birth_date'];
                 $customers->customer_address = $params_array['customer_address'];
                 $customers->customer_phone = $params_array['customer_phone'];
                 $customers->save();
                    
                 $data = array('status' => 'success',
                             'code' => 200,
                             'customer' => $customers
                         );
             }
             
         }else {
             $data = array('status' => 'error',
             'code' => 400,
             'message' => 'No se ha enviado ningún Cliente',
         );
         }
             // devolver resultado
             return response()->json($data, $data['code']);
 
    }

    public function updateCustomer($id, Request $request)
    {
             // recoger los datos

             $json = $request->input('json', null);
 
             $params_array = json_decode($json, true); // obtengo un array 
 
             if (!empty($params_array)) {
               
                 $validate = \Validator::make($params_array, [
                    'customer_address' => 'required',
                    'customer_phone' => 'required',
                 ]);
     
                     $customer = Customer::where('customer_id', $id)->update(
                       $params_array
                     );
 
                     $data = array('status' => 'success',
                     'code' => 200,
                     'message' => 'Se ha actualizado la Ciudad',
                     'customer' => $params_array
                 );
 
             }else {
                 $data = array('status' => 'error',
                 'code' => 400,
                 'message' => 'No se ha enviado ningún Cliente',
             );
             }
 
             return response()->json($data, $data['code']);
 
    }
}
