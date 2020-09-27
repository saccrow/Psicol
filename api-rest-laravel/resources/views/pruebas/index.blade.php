
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

<h1>{{$titulo}}</h1>

<ul>
    
    @foreach($animales as $animal)
    <li>
        {{$animal}}
    </li>
    
    @endforeach
    
</ul>
