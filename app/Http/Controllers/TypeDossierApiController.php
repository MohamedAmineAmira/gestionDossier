<?php

namespace App\Http\Controllers;

use App\Models\TypeDossier;
use Illuminate\Http\Request;

class TypeDossierApiController extends Controller
{
    public function index()
    {
        return response()->json (TypeDossier::all());
    }

    public function getNoms(){
        return response()->json (TypeDossier::select('nom')->get());
    }

    public function showId($nom)
    {
        $typedossier = TypeDossier::where(function($query) use ($nom){        
            $query->where('nom',$nom);
        })->first();
  
        return response()->json( $typedossier->id);
    
    }
    public function showNom($id)
    {
        return response()->json(TypeDossier::findOrFail($id));
    }

    public function store(Request $request){
        $typedossier = new  TypeDossier();
        
        $typedossier->nom =$request->input('nom');
        $typedossier->description = $request->input('description');
       

        $typedossier->save(); 
        return response()->json (TypeDossier::all());   
    }

    public function update(Request $request , $id){
        TypeDossier::where('id',$id)->update([
            'nom'=>$request->nom,
            'description'=>$request->description
        ]);
        return response()->json (TypeDossier::all());
    }

}
