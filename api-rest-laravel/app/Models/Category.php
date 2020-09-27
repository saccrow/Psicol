<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    
    // Relacion 1 a muchos
    public function posts(){
        
        return $this->hasMany('App\Models\Post');
        
    }
    
    public function events(){
        
        return $this->hasMany('App\Models\Event');
        
    }
    
}
