<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use Illuminate\Http\Request;
use App\Models\MetaData_Fichier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MetaDataApiController extends Controller
{
    public function store(Request $request){
        $uploadedFiles=$request->files;
       

      foreach ($uploadedFiles as $file){
            for($i = 0 ;$i<$request->nbFichier;$i++){
                $MetaData_Fichier = new MetaData_Fichier();

                $dossier = Dossier::find($request->id_dossier);
                $MetaData_Fichier->dossier()->associate($dossier);
    
                $name =$file[$i]->getClientOriginalName();
                $MetaData_Fichier->nom_fichier = $name ;
    
                $MetaData_Fichier->nom_type_fichier =$request->typeFichiers[$i];
                $MetaData_Fichier->date_ech =$request->dates[$i];
    
    
                $filename =  $filename= time(). '.' .$file[$i]->getClientOriginalExtension();
                $lien = Storage::putFileAs(
                'fichiers', $file[$i],$filename 
                );
                
                $MetaData_Fichier->lien =$lien;
    
                $MetaData_Fichier->save();
    
            }
           
              
        }
        return response(['status'=>'success'],200);
              
    }

    public function getMetaData($id_dossier){

        $MetaData_Fichier = DB::table('meta_data__fichiers')
                ->where('dossier_id', '=', $id_dossier)
                ->get();

        return response()->json ($MetaData_Fichier);  
        
    }

    public function destroy(Request $request)
    {

        DB::table('meta_data__fichiers')->where('id', '=', $request->id)->delete();
        return response(['status'=>'success'],200);

    }

    public function download($id){
        $file = MetaData_Fichier::findOrFail($id);

        return Storage::download($file->lien); 
    
    }
}
