<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dossier;
use App\Models\MetaData_Fichier;
use App\Models\TypeDossier;
use App\Models\TypeFichier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class DossierApiController extends Controller
{
    public function index()
    {
        return response()->json (Dossier::all());
    }

    public function show($id)
    {   
        return response()->json(Dossier::findOrFail($id));
        
    }

    public function store(Request $request){
        $dossier = new Dossier();
        

        $client = Client::where('email', $request->input('selectedClient.email'))->first();
        $dossier->client()->associate($client);
        
        $typedossier = TypeDossier::where('nom', $request->input('selectedDossier.nom'))->first();
        $dossier->type_dossier()->associate( $typedossier);

        

        $dossier->date_depot_prevu =$request->input('date');
        $dossier->description = $request->input('description');

        $dossier->save();

       foreach(($request->selectedFichier)['fichier'] as $fichier ){

         
            $dossier->type_fichiers()->attach($fichier['id']);

       }
        
    }
    public function getTypeFichier ($id)
    {
        $typeFichiesIds = DB::table('dossier_type_fichier')
                        ->select('type_fichier_id')
                        ->where('dossier_id','=' ,$id)
                        ->get();

        $typefichiers=[]; 
       for ($i=0 ;$i < sizeof($typeFichiesIds); $i++) {
           
           $typefichiers[$i] =TypeFichier::where('id','=',$typeFichiesIds[$i]->type_fichier_id)->first();


        }
        return response()->json ($typefichiers);
    }

    public function getTypeFichierMetaData ($id)
    {
    

     
        $typefichiers = DB::table('dossier_type_fichier')
                    ->join('type_fichiers', 'dossier_type_fichier.type_fichier_id', '=', 'type_fichiers.id')
                    ->join('dossiers', 'dossier_type_fichier.dossier_id', '=', 'dossiers.id')
                    ->select('type_fichiers.id', 'type_fichiers.nom')
                    ->where('dossier_type_fichier.dossier_id','=',$id)
                    ->get();

       foreach($typefichiers as $key => $value)   {
                $metaData  = DB::table('meta_data__fichiers')
                            ->where('dossier_id', '=', $id)
                            ->where('nom_type_fichier', '=' , $value->nom)
                            ->first();
                if($metaData != null){
                    $typefichiers->pull($key);
                }
    
        }         
        
        return response()->json ($typefichiers);

    }

    public function update(Request $request ,$id){
        $client = Client::where('email', $request->selectedClient)->first();

        $typedossier = TypeDossier::where('nom', $request->selectedDossier)->first();


        Dossier::where('id',$id)->update([
            'date_depot_prevu'=>$request->date,
            'statue'=>$request->statue,
            'description'=>$request->description,
            'client_id'=>$client->id,
            'type_dossier_id'=>$typedossier->id
        ]);
        $typefichierIds =[];//tableau des ids de type des fichiers 
        $i= 0;
        foreach(($request->selectedFichier)['fichier'] as $fichier ){

            $typefichierIds[$i] = $fichier['id'];
            $i++;
       }

        $dossier = Dossier::find($id);
        $dossier->type_fichiers()->sync($typefichierIds);
        
        $metaData = MetaData_Fichier::where('dossier_id',$id)->get();
       
        
        foreach ( $metaData as $meta){

            
            $idFichier = DB::table('type_fichiers')
                        ->select('id')
                        ->where('nom','=' ,$meta->nom_type_fichier)
                        ->first();

            if(!in_array( $idFichier->id,$typefichierIds )){
                $meta->delete();
            }
        }



    }
    public function destroy(Request $request)
    {

        DB::table('dossiers')->where('id', '=', $request->id)->delete();
        return response()->json (Dossier::all());

    }
} 
