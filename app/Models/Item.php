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
        'quantidade',
        'created_at',
        'updated_at',

    ];

    public function lista()
    {
        return $this->belongsToMany(Lista::class, 'lista_item', 'id', 'id_lista');
    }
}
