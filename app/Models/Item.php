<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var String table
     */

    protected $table = 'item';

    protected $fillable = [
        'nome',
        'descricao',
        'id_usuario',
        'created_at',
        'updated_at',

    ];

    public function usuario()
    {
        return $this->belongsToMany(Lista::class, 'lista_item', 'id_lista', 'id', 'id_item', 'id');
    }
}
