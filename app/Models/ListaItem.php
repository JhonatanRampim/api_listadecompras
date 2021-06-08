<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaItem extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var String table
     */

    protected $table = 'lista_item';

    protected $fillable = [
        'id_item',
        'id_lista',
        'is_checked',
        'created_at',
        'updated_at',
    ];


    public function item()
    {
        return $this->belongsTo(Item::class, 'id', 'id_item');
    }
    public function lista()
    {
        return $this->belongsTo(Lista::class, 'id', 'id_lista');
    }
}
