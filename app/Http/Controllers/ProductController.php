<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function showAll()
    {

        $product = Product::all();

        return response()->json([
                'code' => 200,
                'status' => 'success',
                'product' => $product
            ]);
    }

    public function showProduct($id)
    {

     $products = Product::where('product_id', $id)->first();
 
     if (is_object($products)) {
 
         $data = array('status' => 'success',
                         'code' => 200,
                         'products' => $products
                     );
     
     }else {
         $data = array('status' => 'error',
                         'code' => 404,
                         'message' => 'El Producto no existe'
                     );
     }
 

         return response()->json($data, $data['code']);
         
    }

    public function registerProduct(Request $request)
    {

             // recoger datos por post
             $json = $request->input('json', null);
             $params_array = json_decode($json, true);
 
             if (!empty($params_array)) {
 
               // validar los datos
             $validate = \Validator::make($params_array, [

                 'product_description' => 'required',
                 'product_amount' => 'required',
                 'product_value' => 'required',
                 'product_status' => 'required'
             ]);
 
             if ($validate->fails()) {
                 $data = array('status' => 'error',
                             'code' => 400,
                             'message' => 'El Cliente no se ha creado',
                         );
                         
             }else{
 
                 // guardar producto

                 $products = new Product();
                 $products->product_description = $params_array['product_description'];
                 $products->product_amount = $params_array['product_amount'];
                 $products->product_value = $params_array['product_value'];
                 $products->product_status = $params_array['product_status'];
                 $products->save();
                    
                 $data = array('status' => 'success',
                             'code' => 200,
                             'products' => $products
                         );
             }
             
         }else {
             $data = array('status' => 'error',
             'code' => 400,
             'message' => 'No se ha enviado ningún Producto',
         );
         }
             // devolver resultado
             return response()->json($data, $data['code']);
 
    }

    public function updateProduct($id, Request $request)
    {
             // recoger los datos

             $json = $request->input('json', null);
 
             $params_array = json_decode($json, true); // obtengo un array 
 
             if (!empty($params_array)) {
               
                 $validate = \Validator::make($params_array, [
                    'product_description' => 'required',
                    'product_amount' => 'required',
                    'product_value' => 'required'
                 
                 ]);
     
                     $product = Product::where('product_id', $id)->update(
                       $params_array
                     );
 
                     $data = array('status' => 'success',
                     'code' => 200,
                     'message' => 'Se ha actualizado el Producto',
                     'product' => $params_array
                 );
 
             }else {
                 $data = array('status' => 'error',
                 'code' => 400,
                 'message' => 'No se ha enviado ningún Producto',
             );
             }
 
             return response()->json($data, $data['code']);
 
    }
}
