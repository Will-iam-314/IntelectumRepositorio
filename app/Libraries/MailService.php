<?php

namespace App\Libraries;

use CodeIgniter\Email\Email;

class MailService{


    protected $email;

    public function __construct()
    {
        // Cargar la configuración de correo desde Email.php
        $this->email = \Config\Services::email();
    }

    public function sendMail($to, $subject, $message)
    {
        
        $this->email->setTo($to);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        if ($this->email->send()) {
            return true;
        } else {
            // Puedes ver el error en los logs de CI4
            log_message('error', $this->email->printDebugger(['headers']));
            return false;
        }
    }

    public function sendMail_ConfirmacionUsuario($to,$token,$nombres){
        $this->email->setTo($to);
        $this->email->setSubject('Verificación de Correo Electronico');

        $body = '
        <div style="background-color:#D9D9D9; padding:10%;">

            <div style="padding:10px 30px;background-color:white; border-radius:10px;font-family:arial;">
            
                <div style="margin-top:20px;margin-bottom:40px;display:flex;">
                    
                    <img width=40 src="https://drive.google.com/file/d/1zw1tx-sIFhsGH-6ENEXrtAmzRDIHcpL8/view?usp=sharing" alt="">
                    <div>
                        <h1 style="margin:0;color:#0A1D2F;">Intelectum</h1>
                        <h3 style="margin:0;color:#3F81BB;">Repositorio</h3>
                    </div>
                    
                </div>

                <p style="font-size:18px;line-height:30px ;color: #595959; text-align: justify;"> Hola '.$nombres.' ,estás en proceso de crear una cuenta en Intelectum.  
                Para completar el registro y verificar tu dirección de correo electrónico, 
                utiliza el siguiente código:
                </p>

                <h2 style="text-align:center;font-size:50px;color:#0A1D2F;">
                    '.$token.'
                </h2>

                <p style="font-size:18px;line-height:30px ;color: #595959;margin-bottom:30px;text-align: justify;">Por seguridad, no compartas el código con nadie.</p>

                <p style="font-size:11px;line-height:30px ;text-align:center;color:#7F7F7F;text-align: center;line-height:18px;">Universidad Nacional de Ucayali – Vicerrectorado de Investigación 2025 ©</p>

            </div>

        </div>
        ';

        // 👇 ESTA LÍNEA ES FUNDAMENTAL
        $this->email->setMessage($body);

        if ($this->email->send()) {
            return true;
        } else {
            // Puedes ver el error en los logs de CI4
            log_message('error', $this->email->printDebugger(['headers']));
            return false;
        }
    }

    public function sendMail_RecoverPass($to,$token){
        $this->email->setTo($to);
        $this->email->setSubject('RESTABLECER CONTRASEÑA');

        $body = '
        <div style="background-color:#D9D9D9; padding:10%;">

            <div style="padding:10px 30px;background-color:white; border-radius:10px;font-family:arial;">
            
                <div style="margin-top:20px;margin-bottom:40px;display:flex;">
                    
                    <img width=40 src="https://drive.google.com/file/d/1zw1tx-sIFhsGH-6ENEXrtAmzRDIHcpL8/view?usp=sharing" alt="">
                    <div>
                        <h1 style="margin:0;color:#0A1D2F;">Intelectum</h1>
                        <h3 style="margin:0;color:#3F81BB;">Repositorio</h3>
                    </div>
                    
                </div>

                <p style="font-size:18px;line-height:30px ;color: #595959; text-align: justify;"> Hola ,estás en proceso de crear una cuenta en Intelectum.  
                Para completar el registro y verificar tu dirección de correo electrónico, 
                utiliza el siguiente código:
                </p>

                <h2 style="text-align:center;font-size:50px;color:#0A1D2F;">
                    '.$token.'
                </h2>

                <p style="font-size:18px;line-height:30px ;color: #595959;margin-bottom:30px;text-align: justify;">Por tu seguridad, no lo compartas el código con nadie.</p>

                <p style="font-size:11px;line-height:30px ;text-align:center;color:#7F7F7F;text-align: center;line-height:18px;">Universidad Nacional de Ucayali – Vicerrectorado de Investigación 2025 ©</p>

            </div>

        </div>
        ';

        // 👇 ESTA LÍNEA ES FUNDAMENTAL
        $this->email->setMessage($body);

        if ($this->email->send()) {
            return true;
        } else {
            // Puedes ver el error en los logs de CI4
            log_message('error', $this->email->printDebugger(['headers']));
            return false;
        }
    }

}

?>