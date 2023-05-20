<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function showAll()
    {

        $orders = DB::table('orders AS o')
        ->select('o.order_id','o.order_satus','o.order_date','o.order_total','o.order_date_delivery','o.order_satus',
        'cu.customer_id_number', 'cu.customer_birth_date', 'cu.customer_address','cu.customer_phone', 
        'c.city_name')
        ->leftjoin('customers AS cu', 'cu.customer_id','=','o.customer_id')
        ->leftjoin('cities AS c', 'c.city_id','=','cu.city_id')
        ->get();

        return response()->json([
                'code' => 200,
                'status' => 'success',
                'orders' => $orders
            ]);
    }

    public function showOrder($id)
    {

        $cantidad = 0;
 
        $detailOrder = DB::table('order_detail')
        ->select(DB::raw('COUNT(product_id) as cantidad'))
        ->where('order_id', $id)
        ->get();

        if (is_object($detailOrder)) {
 
            foreach ($detailOrder as $key => $value) {
                $cantidad = $value->cantidad;
            }
        
        }else {
            $cantidad = 0;
        }

        $orders = DB::table('orders AS o')
        ->select('o.order_id', 'o.order_date','o.order_total','o.order_date_delivery','o.order_satus',
        'cu.customer_id_number', 'cu.customer_birth_date', 'cu.customer_address','cu.customer_phone', 
        'c.city_name')
        ->leftjoin('customers AS cu', 'cu.customer_id','=','o.customer_id')
        ->leftjoin('cities AS c', 'c.city_id','=','cu.city_id')
        ->where('o.order_id', $id)
        ->get();

 
     if (is_object($orders)) {
 
         $data = array('status' => 'success',
                         'code' => 200,
                         'orders' => $orders,
                         'cantidad' => $cantidad,
                         'orden_id' => $id
                     
                     );
     
     }else {
         $data = array('status' => 'error',
                         'code' => 404,
                         'message' => 'El Producto no existe'
                     );
     }
 

         return response()->json($data, $data['code']);
         
    }

    public function registerOrder(Request $request)
    {

             // recoger datos por post
             $json = $request->input('json', null);
             $params_array = json_decode($json, true);
 
                 // guardar orden

                 $orders = new Order();
                 $orders->customer_id = $params_array['customer_id'];
                 $orders->order_date = $params_array['order_date'];
                 $orders->order_total = $params_array['order_total'];
                 $orders->order_date_delivery = $params_array['order_date_delivery'];
                 $orders->order_satus = $params_array['order_satus'];
                 $orders->save();

                 /*
                 $id_insertado = Order::latest('order_id')->first();

                 $producto_insertado = new OrderDetail();
                 $producto_insertado->order_id = $id_insertado;
                 $producto_insertado->product_id = $params_array['product_id'];
                 $producto_insertado->save();
                 */
                    
                 $data = array('status' => 'success',
                             'code' => 200,
                             'orders' => $orders
                         );
       
             // devolver resultado
             return response()->json($data, $data['code']);
 
    }

    public function updateOrder($id, Request $request)
    {
             // recoger los datos

             $json = $request->input('json', null);
 
             $params_array = json_decode($json, true); // obtengo un array 
 
             if (!empty($params_array)) {
               
                 $validate = \Validator::make($params_array, [

                    'order_date' => 'required',
                    'order_total' => 'required',
                    'order_date_delivery' => 'required',
                    'order_satus' => 'required'
                 
                 ]);
     
                     $orders = Order::where('order_id', $id)->update(
                       $params_array
                     );
 
                     $data = array('status' => 'success',
                     'code' => 200,
                     'message' => 'Se ha actualizado la Orden',
                     'orders' => $params_array
                 );
 
             }else {
                 $data = array('status' => 'error',
                 'code' => 400,
                 'message' => 'No se ha enviado ninguna Orden',
             );
             }
 
             return response()->json($data, $data['code']);
 
    }

    public function asignProducts(Request $request)
    {

                 // recoger datos por post
                 $json = $request->input('json', null);
                 $params_array = json_decode($json, true);

                     $orders = new OrderDetail();
                     $orders->order_id = $params_array['order_id'];
                     $orders->product_id = $params_array['product_id'];
                     $orders->save();
                        
                     $data = array('status' => 'success',
                                 'code' => 200,
                                 'orders' => $orders
                             );
             
                 // devolver resultado
                 return response()->json($data, $data['code']);
     
        

        /*
             // recoger los datos
             $json = $request->input('json', null);
             $params_array = json_decode($json, true);

                $orders  = new OrderDetail();
                $orders->order_id = $params_array['order_id'];
                $orders->product_id = $params_array['product_id'];
                $orders->save();
                
            
                $data = array('status' => 'success',
                            'code' => 200,
                            'orders' => $orders
                        );
 
             return response()->json($data, $data['code']);
             */
 
    }

    public function deleteProductsAsign($id)
    {


            $orders = OrderDetail::where('detail_id', $id)->delete();
            
      
                $data = array('status' => 'success',
                            'code' => 200,
                            'message' => 'Producto eliminado con éxito'
                        );
 
             return response()->json($data, $data['code']);
 
    }

    public function getProductsAsign($id)
    {

            $products = DB::select("SELECT product_id, product_description, $id as order_id FROM products");

            $productsAsign = DB::table('products as p')
            ->select('o.detail_id', 'p.product_description')
            ->leftjoin('order_detail AS o', 'o.product_id','=','p.product_id')
            ->whereIn('p.product_id', $array_id)
            ->where('order_id', $id)
            ->get();
       
            $data = array('status' => 'success',
                            'code' => 200,
                            'products' => $products, 
                            'productsAsign' => $productsAsign,
                            'id_orden' => $id
                        );
        
  
    
   
            return response()->json($data, $data['code']);
 
    }

    public function asignarProductos(Request $request)
    {

             // recoger datos por post
             $json = $request->input('json', null);
             $params_array = json_decode($json, true);
 

                $orders = new OrderDetail();
                $orders->order_id = $params_array['order_id'];
                $orders->product_id = $params_array['product_id'];
                $orders->save();
                   
                $data = array('status' => 'success',
                            'code' => 200,
                            'orders' => $orders
                        );
      
             // devolver resultado
             return response()->json($data, $data['code']);
 

        

 
 
    }



}
