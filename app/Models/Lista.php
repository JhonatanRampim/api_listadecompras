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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    public function item()
    {
        return $this->belongsToMany(Item::class, 'lista_item', 'id', 'id_item');
    }
}
