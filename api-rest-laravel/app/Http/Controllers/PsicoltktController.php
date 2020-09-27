<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Category;
use App\Models\Event;

use App\Models\Post;


//use App\Http\Controllers\Controller;

class PsicoltktController extends Controller
{
    //
    
    public function index(){
        
        $titulo = "Animales";
        $animales = ['Perro','Gato'];
        
        return view(pruebas.index, array (
           'titulo' => $titulo,
            'animales' => $animales
            
        ));
    }
    
    public function testPost(){
        
        $posts = Post::all();
        // var_dump($posts);
       foreach ($posts as $post){
        echo "<H1>".$post->title."</H1>"; 
         echo "<span>{$post->category->name}</span>";
        echo "<p>".$post->content."</p>";
        echo "<hr>";
            
            
      } 
        
        die();
        
    }
    
    public function testEvent(){
        
       /*
        $events = Event::all();
        
       foreach ($events as $event){
           
        echo "<span>{$event->category->name}</span>";
        echo "<H1>".$event->title."</H1>"; 
        echo "<p>".$event->content."</p>";
        echo "<hr>";
            
            
      } 
      
        
        */
        
        
      $categories = Category::all();
      foreach($categories as $category){
          
          echo "<H1>".$category->name."</H1>"; 
          
          foreach($category->events as $event){
              echo "<H2>".$event->title."</H2>";
              echo "<span style= 'color:gray;'>{$event->content}</span>";
              
              
          }
          echo "<hr>";
          
      }
          
      
      
        
        die();
        
    }
    
    
    
    
}
