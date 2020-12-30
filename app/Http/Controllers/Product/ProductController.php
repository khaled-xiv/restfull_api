<?php

namespace App\Http\Controllers\Product;

use App\Enums\Status;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only([
            'index','show'
        ]);
        $this->middleware('auth:api')->except([
            'index','show'
        ]);
    }

    public function index()
    {
        $products=Product::all();
        return $this->showAll($products);
    }

    public function show(Product $product)
    {
        return $this->showOne($product);
    }


    public function store(User $seller)
    {
        $request=request();
        $rules=[
            'name'=>'required',
            'description'=>'required',
            'quantity'=>'required|integer|min:1',
            'image'=>'required|image',
        ];

        $this->validate($request,$rules);

        $data=$request->all();

        $data['status']=Status::UNAVAILABLE;
        $data['image']=$request->image->store('');
        $data['seller_id']=$seller->id;

        $product=Product::create($data);

        return $this->showOne($product);

    }

    public function destroy(Seller $seller,Product $product)
    {
        $this->checkSeller($seller,$product);
        Storage::delete($product->image);
        $product->delete();

        return $this->showOne($product);
    }

    public function checkSeller(Seller $seller,Product $product)
    {
        if($seller->id != $product->seller_id){
            throw new HttpException(422,'The specified seller is not the actual seller od the product');
        }
    }
}
