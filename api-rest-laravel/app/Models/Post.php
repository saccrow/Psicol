<?php

namespace App\Models;

//namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $table = 'posts';
    
    // Relacion de 1 a muchos inversa (muchos a uno)
    public function user(){
        
        return $this->belongsTo('App\Models\User','user_id');
    }
    
    public function category(){
        
        return $this->belongsTo('App\Models\Category','category_id');
    }
    
}
