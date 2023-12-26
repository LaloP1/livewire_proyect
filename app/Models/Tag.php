<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable=[
        'name'
    ];

    //Relacion muchos a muchos en el modelo tag
    //Aqui estoy utilizando esta relacion para saber cuantos post pertenecen a un solo tag
    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}
