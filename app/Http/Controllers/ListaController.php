<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lista;
use App\Models\ListaItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class ListaController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $dataReceived['nome_lista'] = $request->nome;
            $dataReceived['descricao'] = $request->descricao;
            $dataReceived['itens'] = (array) $request->itens;
            $token = JWTAuth::getToken();
            $user = JWTAuth::getPayload($token)->toArray();
            $listas = new Lista();
            $item = new Item();
            $insertedData = array();
            $listas->nome = $dataReceived['nome_lista'];
            $listas->id_usuario = $user['id'];
            $listas->descricao = $dataReceived['descricao'];
            if ($listas->save()) {
                foreach ($dataReceived['itens'] as $item) {
                    $itens = Item::create([
                        'nome' => $item['nomeItem'],
                        'quantidade' => $item['quantidade'],
                    ]);

                    $insertedData['itens'][] = ListaItem::create([
                        'id_item' => $itens->id,
                        'id_lista' => $listas->id
                    ]);
                }
            }
            DB::commit();
            return response()->json(["success" => true, "data" => $insertedData, "message" => "CREATED"], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(["success" => false, "data" => $th->getMessage(), "message" => "ERROR"], 200);
        }
    }

    public function getMyList(Request $request)
    {
        try {
            $userId = $request->id;
            $lista = new Lista;
            $dataReturned = $lista::where('id_usuario', $userId)->get();

            return response()->json(["success" => true, "data" => $dataReturned, "message" => "CREATED"], 200);
        } catch (\Exception $th) {
            throw $th;
            return response()->json(["success" => false, "data" => $th->getMessage(), "message" => "ERROR"], 200);
        }
    }

    public function getMyListWithItems(Request $request)
    {
        try {
            $userId = $request->id;
            $id = $request->id_lista;
            $lista = new Lista;
            $dataToReturn = array();

            $listasItems = $lista::where('id_usuario', $userId)->orWhere('id', $id)->with('item')->get();

            foreach ($listasItems  as $key => $listaItem) {
                $filteredItems = array();
                foreach ($listaItem->item as $key => $item) {
                    $filteredItems[] = array(
                        'id_item' => $item->id,
                        'nome' => $item->nome,
                        'quantidade' => $item->quantidade,
                        'is_checked' => $item->pivot->is_checked,
                        'valor' => $item->valor
                    );
                }

                $dataToReturn[] = array(
                    'id_lista' => $listaItem->id,
                    'nome' => $listaItem->nome,
                    'valor' => $listaItem->valor,
                    'descricao' => $listaItem->descricao,
                    'created_at' => $listaItem->created_at,
                    'updated_at' => $listaItem->updated_at,
                    'items' => $filteredItems
                );
            }

            return response()->json(["success" => true, "data" => $dataToReturn, "message" => "CREATED"], 200);
        } catch (\Exception $th) {
            return response()->json(["success" => false, "data" => $th->getMessage(), "message" => "ERROR"], 200);
        }
    }

    public function updateCheckedLista(Request $request)
    {
        DB::beginTransaction();
        try {
            $id_lista = $request->id_lista;
            $itensToCheck = $request->itens;
            $total = $request->total;
            $dataToReturn = array();
            if (!$this->_updateListValue($id_lista, $total)) {
                DB::rollBack();
                return response()->json(["success" => false, "data" => 'Erro ao atualizar valor total!', "message" => "ERROR"], 200);
            }
            foreach ($itensToCheck as $key => $item) {
                if (!$this->_updateItemValue($item['id_item'], $item['valor'])) {
                    DB::rollBack();
                    return response()->json(["success" => false, "data" => 'Erro ao atualizar valor do item!', "message" => "ERROR"], 200);
                }
            }
            foreach ($itensToCheck as $key => $item) {
                $dataToReturn[] = ListaItem::where('id_lista',  $id_lista)->where('id_item', $item['id_item'])->update(['is_checked' => $item['isChecked']]);
            }
            DB::commit();
            return response()->json(["success" => true, "data" => $dataToReturn, "message" => "CREATED"], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json(["success" => false, "data" => $th->getMessage(), "message" => "ERROR"], 200);
        }
    }

    private function _updateListValue($id_lista, $valor)
    {
        try {
            $valor = floatval($valor);
            $lista = Lista::find($id_lista);
            $lista->valor = $valor;
            if (!$lista->save()) {
                return false;
            }
            return true;
        } catch (\Exception $th) {
            throw $th;
        }
    }

    private function _updateItemValue($id_item, $valor)
    {
        try {
            $valor = floatval($valor);
            $itemDB = Item::find($id_item);
            $itemDB->valor =  $valor;

            if (!$itemDB->save()) {
                return false;
            }
            return true;
        } catch (\Exception $th) {
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
}
