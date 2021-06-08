<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lista;
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
            $dataReceived['itens'] = $request->itens;
            $token = JWTAuth::getToken();
            $user = JWTAuth::getPayload($token)->toArray();
            $listas = new Lista();
            $toInsert = array();
            $item = new Item();
            $listas->nome = $dataReceived['nome_lista'];
            $listas->id_usuario = $user['id'];
            // $listas->save();
            var_dump($item);
            if ($listas) {
                foreach ($dataReceived['itens'] as $item) {
                    $toInsert[] = [
                        'nome' => $item['nome_item'],
                        'quantidade' => $item['quantidade'],
                    ];
                }
            }
            $listas->item()->saveMany($toInsert);
            // $itens = Item::insert($toInsert);
            // return $itens;
        } catch (\Throwable $th) {
            throw $th;
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
    public function delete(Request $request)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
