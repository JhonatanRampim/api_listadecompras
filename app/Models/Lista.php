<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var String table
     */

    protected $table = 'lista';

    protected $fillable = [
        'nome',
        'descricao',
        'id_usuario',
        'is_used',
        'created_at',
        'updated_at',

    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    public function item()
    {
        return $this->belongsToMany(Item::class,'lista_item', 'id_lista', 'id')->withPivot('is_checked');
    }
}
