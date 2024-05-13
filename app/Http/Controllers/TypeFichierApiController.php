<?php

namespace App\Http\Controllers;

use App\Models\TypeFichier;
use Illuminate\Http\Request;

class TypeFichierApiController extends Controller
{
    public function index()
    {
        return response()->json (TypeFichier::all());
    }

    public function store(Request $request){
        $typefichier = new  TypeFichier();
        
        $typefichier->nom =$request->input('nom');
        $typefichier->description = $request->input('description');
       

        $typefichier->save(); 
           
        return response()->json (TypeFichier::all());
    }
    public function update(Request $request , $id){
        TypeFichier::where('id',$id)->update([
            'nom'=>$request->nom,
            'description'=>$request->description
        ]);
        return response()->json (TypeFichier::all());
    }
}
