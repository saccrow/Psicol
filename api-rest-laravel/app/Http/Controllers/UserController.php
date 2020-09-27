<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;




class UserController extends Controller
{
    // Clase del usuario
    public function pruebas(Request $request){
        
        return "Accion de prueba de Controlador de Usuario";
        
        
    }
    
    public function register(Request $request){
        
        /*
        $name = $request->input('name'); 
        $surname = $request->input('surname');  
        return "Accion de Registro de Controlador de Usuario ".$name." ".$surname;
        */
        
        
        // DATOS DEL USUARIO

        $json = $request->input('json',null); // Obtenemos el JSON
        
        
        $params = json_decode($json); // Retorna el objeto  
        // var_dump($params->name);  // Retorna un valor del objeto
        
        $params_array = json_decode($json,true); // Retorna un Array      
        // var_dump($params_array);
       // die(); 
        
        if(!empty($params) && !empty($params_array)){
            
        
        
                    // LIMPIAR DATOS

                    $params_array = array_map('trim',$params_array); // Limpio los datos del Array

                    //VALIDAR EL USUARIO

                    $validate = \Validator::make($params_array,[
                        'name'      => 'required|alpha',
                        'surname'   => 'required|alpha',
                        'email'     => 'required|email|unique:users', // Un solo correo registrado.
                        'password'  => 'required'

                    ]);

                    if($validate->fails()){

                        // Fallo la validacions
                        
                        $data = array(
                        'status'    => 'error',
                        'code'      => 404,
                        'mensaje'   => 'El usuario no se ha creado correctamente',
                        'errors'    => $validate->errors()
                        );

                    }else{

                        //Paso la validacion
                        
                        // CIFRAR LA CLAVE
                        
                        //$pwd = password_hash($params->password, PASSWORD_BCRYPT,['cost' => 4]);
          
                        $pwd = hash('sha256',$params->password);
                        
                        // CREAR EL USUARIO
                        
                        $user = new User();
                        $user->name     = $params_array['name'];
                        $user->surname  = $params_array['surname'];
                        $user->email    = $params_array['email'];
                        $user->password = $pwd;
                        
                         // Insertar Usuario
                        
                        $user->save();
                        
                        $data = array(
                        'status'    => 'success',
                        'code'      => 200,
                        'mensaje'   => 'El usuario se ha creado correctamente',
                        'user'      => $user
                        ); 

                    }
        }else{
            
            $data = array(
                        'status'    => 'error',
                        'code'      => 404,
                        'mensaje'   => 'Los datos enviados no son correctos'
                        );

            
        }
       
        return response()->json($data,$data['code']);
        
    }
    
    public function login(Request $request){
        
        $jwtAuth = new \JwtAuth();
        
        // Recibir datos  POST
        
        $json   = $request->input('json',null);
        $params = json_decode($json);
        $params_array = json_decode($json,true);
        
        // Validar Datos
        if(!empty($params) && !empty($params_array)){
        
                    $validate = \Validator::make($params_array,[
                        'email'     => 'required|email',
                        'password'  => 'required'

                    ]);

                    if($validate->fails()){

                        // Fallo la validacions
                        
                        $signup = array(
                        'status'    => 'error',
                        'code'      => 404,
                        'mensaje'   => 'El usuario no se ha podido loguear',
                        'errors'    => $validate->errors()
                        );

                    }else{
                        
                        // Cifrar la clave
                        $pwd = hash('sha256',$params->password);
                        
                        //Devolver Token o datos.
                        $signup = $jwtAuth->signup($params->email, $pwd);
                        if(!empty($params->gettoken)){
                            
                            $signup = $jwtAuth->signup($params->email, $pwd, true);
                            
                        }
                        
                        
                    }
        
        // $pwd        =  password_hash($password, PASSWORD_BCRYPT,['cost' => 4]);
        
        }else{
            
            $signup = array(
                        'status'    => 'error',
                        'code'      => 404,
                        'mensaje'   => 'Los datos enviados no son correctos'
                        );

            
        }
        
        return response()->json($signup,200);
        
        
    }
    
    public function update(Request $request){
        
     // Comprobar si el usuario esta identificado
        
        
            
        
        $token      =   $request->header('Authorization');
        $jwtAuth    =   new \JwtAuth();
        $checkToken =   $jwtAuth->checkToken($token);
        
        // Recibir los datos Post
            
            $json           =   $request->input('json', null);
            $params_array   =   json_decode($json, true);
        
        if($checkToken && !empty($params_array) ){
            
            // ACTUALIZAR EL USUARIO
            
            
            
            // sacar usuario identificado
            
            $user =   $jwtAuth->checkToken($token, true);
           
            // validar los datos
            
            $validate   =   \Validator::make($params_array, [
                        'name'      => 'required|alpha',
                        'surname'   => 'required|alpha',
                        'email'     => 'required|email|unique:users'.$user->sub   // Un solo correo registrado.
                      

                    ]);
            
            //Quitar los datos que no se quieren actualizar
            
            unset($params_array['id']);
            unset($params_array['role']);
            unset($params_array['password']);
            unset($params_array['created_at']);
            
           // Actualizar los datos
            
            $user_update    = User::where('id', $user->sub)->update($params_array);
            
           //devolver array
            
            $data = array(
                        'status'    => 'success',
                        'code'      => 200,
                        'user'      => $user,
                        'changes'   => $params_array
                        );
            
            
            echo "<H1>LOGIN CORRECTO</H1>";
        }else{
            
            $data = array(
                        'status'    => 'error',
                        'code'      => 404,
                        'mensaje'   => 'Usuario no identificado'
                        );
           
        }
        
        return response()->json($data, $data['code']);
        
        
    }
    
    public function upload(Request $request){
        $data = array(
                        'status'    => 'error',
                        'code'      => 404,
                        'mensaje'   => 'Error al subir imagen'
                        );
        
        return response()->json($data, $data['code']);
        
    }
    
    public function detail($id){
        $user   = User::find($id);
        
        if(is_object($user)){
            $data = array(
                        'status'    => 'success',
                        'code'      => 200,
                        'user'   => $user
                        );
            
        }else{
            $data = array(
                        'status'    => 'error',
                        'code'      => 404,
                        'mensaje'   => 'El usuario no existe'
                        );
            
        }
        return response()->json($data, $data['code']);
        
    }
    
    
}
