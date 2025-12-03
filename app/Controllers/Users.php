<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        
        $this->usersModel = new UsersModel();
    }

    public function nuevoUsuario(){

       $rules = [
            'nombres' => [
                'rules' => 'required|regex_match[/^[\p{L}\s]+$/u]',
                'errors' => [
                    'required'     => 'Debes ingresar tus nombres.',
                    'regex_match'  => 'Los nombres no pueden contener caracteres especiales.'
                ]
            ],

            'apellidos' => [
                'rules' => 'required|regex_match[/^[\p{L}\s]+$/u]',
                'errors' => [
                    'required'     => 'Debes ingresar tus apellidos.',
                    'regex_match'  => 'Los apellidos no pueden contener caracteres especiales.'
                ]
            ],

            'dni' => [
                'rules' => 'required|integer|max_length[8]|min_length[8]|is_unique[solicitantes.dni_solicitante]',
                'errors' => [
                    'required'   => 'El DNI es obligatorio.',
                    'integer'    => 'El DNI solo debe contener números.',
                    'max_length' => 'El DNI debe tener exactamente 8 dígitos.',
                    'min_length' => 'El DNI debe tener exactamente 8 dígitos.',
                    'is_unique'  => 'El DNI ingresado ya se encuentra registrado.'
                ]
            ],

            'carrera' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe seleccionar su carrera.'
                ]
            ],

            'email' => [
                'rules' => 'required|valid_email|max_length[100]|is_unique[usuarios.email_usuario]',
                'errors' => [
                    'required'   => 'El correo electrónico es obligatorio.',
                    'valid_email'=> 'Debe ingresar un correo electrónico válido.',
                    'max_length' => 'El correo electrónico no debe superar los 100 caracteres.',
                    'is_unique'  => 'El correo ingresado ya está registrado.'
                ]
            ],

            'password' => [
                'rules' => 'required|max_length[50]|min_length[8]',
                'errors' => [
                    'required'     => 'La contraseña es obligatoria.',
                    'max_length'   => 'La contraseña es demasiado larga.',
                    'min_length'   => 'La contraseña debe tener al menos 8 caracteres.'
                ]
            ],

            'repassword' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Las contraseñas no coinciden.'
                ]
            ],
        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $post = $this->request->getPost(); 
        $rol = 'solicitante';   

       
        /*
        si el rol de la sesion actual es administrador , seleccione el tipo de rol que desee sino por defecto solicitante.
        si no hay sesion, no puede asignar rol?
        */

       $boolUser = $this->usersModel->createUser($post,$rol);
       

        if($boolUser){            
            return redirect()->to(base_url('verificar'));
        } else{
           //retornar a una vista que muestre el error
        }

    }

    public function verificarUsuario(){

        $rules = [
            'codigo' => [
                'rules' => 'required|numeric|exact_length[5]',
                'errors'=> [
                    'required' => 'El codigo es Obligatorio',
                    'numeric'  => 'El codigo ingresado es incorrecto',
                    'exact_length' => 'El codigo ingresado es muy extenso o muy corto'
                ]
            ]
        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $post = $this->request->getPost();
        $token = $post['codigo'];
        $boolVerification = $this->usersModel->activationUser($token);

        if($boolVerification){
            return view('Auth/verificacionExitosaCorreo');
        }else{
            return redirect()->back()->withInput()->with('errors','Codigo Incorrecto');
        }
    }

    

    public function recuperarPass(){

        $rules = [
            'correo_recuperar' => [
                'rules' => 'required|valid_email',
                'errors'=> [
                    'required' => 'El correo es Obligatorio',
                    'valid_email'  => 'El correo ingresado es invalido'
                    
                ]
            ]
        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $post = $this->request->getPost();

        $boolEnvioyVerificacion = $this->usersModel->sendTokenRecoverPass($post['correo_recuperar']);

        if($boolEnvioyVerificacion){
            return redirect('verificarRecuperacion');
        }else{
            return redirect()->back()->withInput()->with('errors','El correo ingresado no esta asociado a ninguna cuenta');
        }

        
  
    }

    public function validarCodigoRecuperacionPass(){
        $rules = [
            'codigo_recuperar' => [
                'rules' => 'required|integer|exact_length[5]',
                'errors'=> [
                    'required' => 'El codigo es Obligatorio',
                    'integer'  => 'Formato de codigo no permitido',
                    'exact_length' => 'El codigo ingresado es muy extenso o muy corto'
                    
                ]
            ]
        ];

        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->listErrors());
        }

        $post = $this->request->getPost();

        $User_data = $this->usersModel->validateRecoverPass($post['codigo_recuperar']);

        if($User_data){
            return view('Auth/cambioPassword',['idUser' => $User_data]);
        }else{
            return redirect()->back()->withInput()->with('errors','Codigo Incorrecto o ya usado');
        }

    }

    public function actualizarPass($idUser){
        $rules = [
            'nevo_password' => [
                'rules' => 'required|min_length[8]|max_length[50]',
                'errors'=> [
                    'required' => 'Ingrese una Cotraseña',
                    'min_length'  => 'La Contraseña debe de tener al menos 8 caracteres',
                    'max_length' => 'La Contraseña es demaciado larga'
                    
                ]
            ],
            're_password' => [
                'rules' => 'matches[nevo_password]',
                'errors' => [
                    'matches' => 'Las Contraseñas no Coinciden'
                ]
            ] 
        ];

        if(!$this->validate($rules)){
            
            return view('Auth/cambioPassword',['error' => $this->validator->getErrors(),'idUser' => $idUser]);
        }

        $post = $this->request->getPost();

        $boolUpdate= $this->usersModel->updatePassword($idUser,$post);
        if($boolUpdate){
            return view('Auth/recuperacionExitosaPassword');
        }else{
            return redirect()->back()->withInput()->with('errors','Hubo un error al actualizar la contraseña');
        }
    }


}
