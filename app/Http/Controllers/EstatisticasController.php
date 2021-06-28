<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstatisticasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getUserTotalItens(Request $request)
    {
        try {
            $userId = $request->user_id;
            $total = DB::table('item')
                ->join('lista_item', 'item.id', '=', 'lista_item.id_item')
                ->join('lista', 'lista.id', '=', 'lista_item.id_lista')
                ->join('usuarios', 'lista.id_usuario', '=', 'usuarios.id')
                ->where('usuarios.id', $userId)
                ->count('item.id');
            return response()->json(["success" => true, "data" => $total, "message" => "CREATED"], 200);
        } catch (\Exception $th) {
            return response()->json(["success" => false, "data" => $th->getMessage(), "message" => "ERROR"], 200);
        }
    }
    public function getUserTotalSpentByList(Request $request)
    {
        try {
            $userId = $request->user_id;
            $total = DB::table('lista')
                ->join('usuarios', 'lista.id_usuario', '=', 'usuarios.id')
                ->where('usuarios.id', $userId)
                ->sum('lista.valor');
            return response()->json(["success" => true, "data" => $total, "message" => "CREATED"], 200);
        } catch (\Exception $th) {
            return response()->json(["success" => false, "data" => $th->getMessage(), "message" => "ERROR"], 200);
        }
    }
    public function getUserTotalSpentItem(Request $request)
    {
        try {
            $userId = $request->user_id;
            $total = DB::table('item')
                ->select(DB::raw('sum(item.valor) as total, item.nome'))
                ->join('lista_item', 'item.id', '=', 'lista_item.id_item')
                ->join('lista', 'lista.id', '=', 'lista_item.id_lista')
                ->join('usuarios', 'lista.id_usuario', '=', 'usuarios.id')
                ->where('usuarios.id', $userId)
                ->groupBy('item.nome')
                ->orderByDesc('total')
                ->get();
            return response()->json(["success" => true, "data" => $total, "message" => "CREATED"], 200);
        } catch (\Exception $th) {
            return response()->json(["success" => false, "data" => $th->getMessage(), "message" => "ERROR"], 200);
        }
    }
}
