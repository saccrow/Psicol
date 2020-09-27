<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    protected $table = 'events';
    
    // Relacion de 1 a muchos inversa (muchos a unos
    
    public function category(){
        
        return $this->belongsTo('App\Models\Category','category_id');
    }
    
}
