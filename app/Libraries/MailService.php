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

    public function sendMail_RecoverPassCode($to,$token){
        $this->email->setTo($to);
        $this->email->setSubject('Codigo de Verificacion');

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

                <p style="font-size:18px;line-height:30px ;color: #595959; text-align: justify;"> Hola ,estás en proceso de restablecer la contraseña de tu cuenta en Intelectum.  
                Para ello utiliza el siguiente código:
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

     public function sendMail_RecoverPass($to){
        $this->email->setTo($to);
        $this->email->setSubject('Contraseña Restablecida');

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

                <p style="font-size:24px;line-height:30px ;color: #595959; text-align: center;margin-bottom:50px;"> 
                    Tu contraseña fue restablecida exitosamente!
                </p>


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

    public function sendMain_EnvioConstancia($to){
        $this->email->setTo($to);
        $this->email->setSubject('Constancia de Publicación Emitida');
        $body = '
         
        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                
                <!-- Header con Logo y Marca -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src="public/assets/icons/IntelectumLogoFondoBlanco.png" alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0; line-height: 1.2;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio</p>
                    </div>
                </div>
                
                <!-- Título del Mensaje -->
                <div style="text-align: center; padding: 10px 20px; font-size: 22px; font-weight: bold; color: #333333; ">
                    Título del Mensaje
                </div>
                
                <!-- Cuerpo del Mensaje -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Estimado usuario,</p>
                    <p style="margin: 0 0 15px 0;">Este es el cuerpo del mensaje. Aquí puedes incluir toda la información que necesites comunicar a tus usuarios.</p>
                    <p style="margin: 0 0 15px 0;">El diseño es completamente responsivo y se adaptará a cualquier dispositivo.</p>
                    <p style="margin: 0;">Saludos cordiales.</p>

                     <!-- Botón de Acción -->
                    <div style="text-align: center; margin: 20px 0;">
                        <a href="https://tudominio.com/enlace" style="display: inline-block; padding: 14px 30px; background-color: #3F81BB; color: #ffffff; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: bold;">Ver Constancia</a>
                    </div>
                </div>
                
                <!-- Pie de Página -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666; line-height: 1.5;">
                    <p style="margin: 0 0 2px 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
                    <p style="margin: 0; font-size: 12px;">Vicerrectorado de Investigación</p>
                </div>
                
            </div>
        </div>

        ';

       
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