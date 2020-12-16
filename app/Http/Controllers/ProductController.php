<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new ProductController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getAll(){
        try{
            return response()->json([
                'success' => true,
                'data' => Product::all()
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getById($productId){
        try{
            return response()->json([
                'success' => true,
                'data' => Product::find($productId)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request){
        try{
            if(!empty($request->product_id)){
                Product::findOrFail($request->product_id)->update($request->all());
            } else {
                $inputs  = $request->all();
                $inputs['created_by'] = 1;
                $inputs['updated_by'] = 1;
                Product::create($inputs);
            }
            return response()->json([
                'success' => true,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function delete(Request $request){
        try{
            Product::destroy($request->product_id);
            return response()->json([
                'success' => true,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
