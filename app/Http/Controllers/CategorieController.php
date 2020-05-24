<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;

class CategorieController extends Controller
{
/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // no need to request the Categories table as it is already done in the NavComposer
        return View('categorie.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categorieName = Categorie::find($id)->name;
        $products = Categorie::find($id)->products;

        return View('categorie.show', ['categorieName' => $categorieName, 'products' => $products]);
    }


}
