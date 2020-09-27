<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JwtAuth{
    
    public $key;
    
    public function __construct() {
        $this->key = 'esto_es_una_clave_secreta-982542';
    }
    
    
    public function signup($email, $password, $getToken = null){
    
    // Buscar usuario y clave
        
        $user = User::where([
            'email'     => $email,
            'password'  => $password
            
        ])->first();
    
    // Verificar si son correctas
        
        $signup = false;
        if(is_object($user)){
            
            $signup = true;
            
        }
    
    // Generar el Token con datos de usuario.
        
        if($signup){
            
            $token = array(
                
              'sub'     =>  $user->id,
              'email'   =>  $user->email,
              'name'    =>  $user->name,
              'surname' =>  $user->surname,
              'iat'     =>  time(),
              'exp'     =>  time() + (7 * 24 * 60 * 60)
                
            );
            
            $jwt = JWT::encode($token, $this->key, 'HS256');  
            $decode = JWT::decode($jwt, $this->key, ['HS256']);
            
            if(is_null($getToken)){
                $data = $jwt;
            }else{
                $data = $decode;
            }
            
            
        }else{
            
            $data = array(
                'status'    =>  'error',
                'mensaje'   =>  'Login Incorrecto.'  
            );
            
        }
    
    // Devolver datos decodificados o el Token 
    
        
        return $data;
    }
    
    
    public function checkToken($jwt, $getIdentity=false){
        $auth = false;
        
        try{
            $jwt = str_replace('"', '', $jwt);
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        
        }catch(\UnexpectedCallException $e){
            $auth = false;
        }catch(\DomainException $e){
            $auth = false;
        }
        
        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub) ){
           $auth = true;
        }else{
            $auth = false;
        }
        
        if($getIdentity){
            return $decoded;  
        }
        
        
        return $auth;
    }
    
}