<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lista;
use App\Models\ListaItem;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ListaController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    public function get(Request $request)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function create(Request $request)
    {
        try {
            $dataReceived['nome_lista'] = $request->nome_lista;
            $dataReceived['itens'] = (array) $request->itens;
            $token = JWTAuth::getToken();
            $user = JWTAuth::getPayload($token)->toArray();
            $listas = new Lista();
            $item = new Item();
            $insertedData = array();
            $listas->nome = $dataReceived['nome_lista'];
            $listas->id_usuario = $user['id'];

            if ($listas->save()) {
                foreach ($dataReceived['itens'] as $item) {
                    $itens = Item::create([
                        'nome' => $item['nome_item'],
                        'quantidade' => $item['quantidade'],
                    ]);
                    $insertedData['itens'][] = ListaItem::create([
                        'id_item' => $itens->id,
                        'id_lista' => $listas->id
                    ]);
                }
            }
            return response()->json(["success" => true, "data" => $insertedData, "message" => "CREATED"], 200);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "data" => $th, "message" => "ERROR"], 200);
        }
    }
    public function update(Request $request)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function delete(Request $request, )
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
