<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at','desc')->paginate(5);
        return view('products.index')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.add_product');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //this does form validation
        $this->validate($request, ['product_name' => 'required', 
                                    'product_price' => 'required',
                                    'cover_image' => 'image|nullable|max:1999'
                                   ]);

        $data = new Product();
        $data->name = $request->input('product_name');
        $data->price = $request->input('product_price');

        //lets now handle the image upload concept
        if($request->hasFile('cover_image'))
        {
            $fileNameWithExtension = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $filename.'.'.time().'.'.$extension;

            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        else
        {
        $fileNameToStore = "NoImage.jpg";
        }
        $data->image = $fileNameToStore;
        $data->save();
        //$request->all();
        return redirect('/products')->with('success',$request->input('product_name').' saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('products.edit')->with('product',$product); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
           //this does form validation
            $this->validate($request, ['product_name' => 'required', 
                                       'product_price' => 'required',
                                       'cover_image' => 'image|nullable|max:1999'
                                      ]);

            $data = Product::find($id);
            $data->name = $request->input('product_name');
            $data->price = $request->input('product_price');

            //lets now handle the image upload concept
            if($request->hasFile('cover_image'))
            {
            $fileNameWithExtension = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $fileNameToStore = $filename.'.'.time().'.'.$extension;

            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            $data->image = $fileNameToStore;
            }
            else
            {
            $data->image = 'NoImage.jpg';
            }
            $data->save();
            return redirect('/products')->with('success',$request->input('product_name').' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
            if($product->image != 'NoImage.jpg')
            {
            Storage::delete('public/cover_images/'.$product->image);
            }
            $product->delete();
            return redirect('/products')->with('success',$product->name. ' Deleted!'); 
        
        
    }
}
