<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientApiController extends Controller
{
    public function index()
    {
        return response()->json (Client::all());
    }

    public function getEmails(){
        return response()->json (Client::select('email')->get());
    }

    public function show($id)
    {
        return response()->json(Client::findOrFail($id));
    }
    
    public function showEmail($id)
    {
        $client = Client::findOrFail($id);
        return response()->json($client->email);
    }

    public function store(Request $request){
        $client = new  Client();
        
        $client->nom =$request->input('nom');
        $client->prenom = $request->input('prenom');
        $client->email= $request->input('email');
        $client->tel = $request->input('tel');


        $client->save();
        return response()->json (Client::all());    
    }

    public function update(Request $request , $id){
        Client::where('id',$id)->update([
            'nom'=>$request->nom,
            'prenom'=>$request->prenom,
            'email'=>$request->email,
            'tel' =>$request->tel
        ]);
        return response()->json (Client::all());   
    }

}
