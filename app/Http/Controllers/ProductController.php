<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Update or create product. If found product id then update otherwise store new product
     */
    public function update(Request $request){
        try{
            $inputs  = $request->all();
            if(!empty($request->product_id)){
                if(!empty($request->file('image'))){
                    $inputs['image'] = $this->uploadImage($request->file('image'), $request->product_id);
                }
                $inputs['updated_by'] = $inputs['user_id'];
                Product::findOrFail($request->product_id)->update($inputs);
            } else {
                $inputs['image'] = $this->uploadImage($request->file('image'));
                $inputs['created_by'] = $inputs['user_id'];
                $inputs['updated_by'] = $inputs['user_id'];
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

    public function uploadImage($image, $id = null){
        if(!empty($image)){
            if(!empty($id)){
                $this->deleteFileFromPath(Product::find($id)->image);
            }
            $image->storeAs('public/product_image', $image->getClientOriginalName());
            return 'product_image/' . $image->getClientOriginalName();
        }

        return null;
    }

    public function deleteFileFromPath($file){
        if(!empty($file)){
            Storage::delete(str_replace('storage', 'public', $file));
        }
    }
    
    public function delete(Request $request){
        try{
            $product = Product::find($request->product_id);
            Product::destroy($request->product_id);
            if(!empty($product['image'])){
                $this->deleteFileFromPath($product['image']);
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
}
