<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin-home', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-adicionar-produto');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //validando dados do form
        $input = $request->validated();
        $input['slug'] = Str::slug($input['name']);

        //salvando imagens localmente
        if (!empty($input['cover']) &&  $input['cover']->isValid()) {
            $file = $input['cover'];
            $path = $file->store('/products');
            $input['cover'] = $path;
        }

        //criando produto no banco de dados
        Product::create($input);

        //redirecionando para rota x quando está ok
        return Redirect::route('admin.products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        return view('admin-editar-produto', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, UpdateProductRequest $request)
    {
        //validando dados do form
        $input = $request->validated();

        if (!empty($input['cover']) &&  $input['cover']->isValid()) {

            Storage::delete($product->cover ?? '');
            $file = $input['cover'];
            $path = $file->store('/products');
            $input['cover'] = $path;
        }

        $product->fill($input);
        $product->save();

        //redirecionando para rota x quando está ok
        return Redirect::route('admin.products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Storage::delete($product->cover ?? '');
        //redirecionando para rota x quando está ok
        return Redirect::route('admin.products');
    }


    public function destroyImage(Product $product)
    {
        Storage::delete($product->cover ?? '');
        $product->cover = null;
        $product->save();


        //redirecionando para rota x quando está ok
        return Redirect::back();
    }
}
