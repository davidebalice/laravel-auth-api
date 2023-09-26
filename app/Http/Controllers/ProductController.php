<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    public function Index(){
        $product = Product::latest()->select('id', 'name', 'price', 'photo')->get();
        return response()->json($product);
    }

    public function Store(Request $request){

        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'description' => 'required'
        ]);

        Product::insert([
            'category_id' => $request->class_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'created_at' => Carbon::now()
        ]);
        return response('Product inserted');
    }

    public function Edit($id){
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function Show($id) {
        try {
            $product = Product::findOrFail($id);
            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found:' . $e], 404);
        }
    }

    public function Update(Request $request, $id){
        $product = Product::findOrFail($id)->update([
            'category_id' => $request->class_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'updated_at' => Carbon::now()
        ]);
        return response('Product updated');
    }

    public function Delete($id){
        $product = Product::findOrFail($id)->delete();
        return response('Product deleted');
    }
}
