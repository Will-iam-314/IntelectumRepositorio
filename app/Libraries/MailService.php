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
        $this->email->setSubject('VERIFICACIÓN DE CORREO ELECTRONICO');
        $urlLogo = base_url('assets/icons/IntelectumLogoFondoBlanco.png');

        $body = '

        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                
                <!-- Header con Logo y Marca -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src='.$urlLogo.' alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0; line-height: 1.2;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio</p>
                    </div>
                </div>
                
                <!-- Cuerpo del Mensaje -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Hola '.$nombres.' ,estás en proceso de crear una cuenta en Intelectum.  
                    Para completar el registro y verificar tu dirección de correo electrónico, 
                    utiliza el siguiente código:</p>
                    
                    <h2 style="text-align:center;font-size:50px;color:#0A1D2F;">
                    '.$token.'
                    </h2>

                    <p style="margin: 0 0 15px 0;">Por seguridad, no compartas el código con nadie.</p>
                   
                </div>
                
                <!-- Pie de Página -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666; line-height: 1.5;">
                    <p style="margin: 0 0 2px 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 12px;">Vicerrectorado de Investigación</p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
                </div>
                
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
        $this->email->setSubject('CODIGO DE VERIFICACIÓN');
        $urlLogo = base_url('assets/icons/IntelectumLogoFondoBlanco.png');

        $body = '

        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                
                <!-- Header con Logo y Marca -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src='.$urlLogo.' alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0; line-height: 1.2;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio</p>
                    </div>
                </div>
                
                <!-- Cuerpo del Mensaje -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Estás en proceso de restablecer la contraseña de tu cuenta en Intelectum.  
                    Para ello utiliza el siguiente código:</p>
                    
                    <h2 style="text-align:center;font-size:50px;color:#0A1D2F;">
                    '.$token.'
                    </h2>

                    <p style="margin: 0 0 15px 0;">Por seguridad, no compartas el código con nadie.</p>
                   
                </div>
                
                <!-- Pie de Página -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666; line-height: 1.5;">
                    <p style="margin: 0 0 2px 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 12px;">Vicerrectorado de Investigación</p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
                </div>
                
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

     public function sendMail_RecoverPass($to,$newPass){
        $this->email->setTo($to);
        $this->email->setSubject('CONTRASEÑA RESTABLECIDA');
        $urlLogo = base_url('assets/icons/IntelectumLogoFondoBlanco.png');

        $body = '

        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                
                <!-- Header con Logo y Marca -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src='.$urlLogo.' alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0; line-height: 1.2;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio</p>
                    </div>
                </div>
                
                <!-- Cuerpo del Mensaje -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Tu contraseña en Intelectum fue restablecida exitosamente.</p>
                    
                    <p style="margin: 0 0 15px 0;"> 

                        <span> <strong> Nueva Contraseña: </strong>'.$newPass.' </span>

                    </p>

                    <p style="margin: 0 0 15px 0;">Por seguridad, no compartas la contraseña con nadie.</p>
                   
                </div>
                
                <!-- Pie de Página -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666; line-height: 1.5;">
                    <p style="margin: 0 0 2px 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 12px;">Vicerrectorado de Investigación</p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
                </div>
                
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





    public function sendMail_RegistroDeSolicitud($to,$codigoTramite){
        
        $this->email->setTo($to);
        $this->email->setSubject('SOLICITUD PRESENTADA');
        $urlLogo = base_url('assets/icons/IntelectumLogoFondoBlanco.png');
        $seccionCodigoTramite= '<span style="font-weight: bold; color:#3F81BB;">'.$codigoTramite.'</span>';
        $body = '
         
        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                
                <!-- Header con Logo y Marca -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src='.$urlLogo.' alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0; line-height: 1.2;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio</p>
                    </div>
                </div>
                
                <!-- Cuerpo del Mensaje -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Estimado usuario,</p>
                    <p style="margin: 0 0 15px 0;">Su solicitud para obtener la constancia de publicación ha sido registrada exitosamente, con codigo: '. $seccionCodigoTramite.'</p>
                    <p style="margin: 0 0 15px 0;">Recuerde revisar periódicamente su correo y su cuenta en el sistema, para mantenerse informado 
                    sobre el avance y las actualizaciones de su trámite.</p>
                    <p style="margin: 0;">Saludos cordiales.</p>
                </div>
                
                <!-- Pie de Página -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666; line-height: 1.5;">
                    <p style="margin: 0 0 2px 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 12px;">Vicerrectorado de Investigación</p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
                    
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


    public function sendMail_EnvioARevision($to,$codigoTramite){

        $this->email->setTo($to);
        $this->email->setSubject('SOLICITUD ENVIADA A REVISION');
        $urlLogo = base_url('assets/icons/IntelectumLogoFondoBlanco.png');
        $seccionCodigoTramite= '<span style="font-weight: bold; color:#3F81BB;">'.$codigoTramite.'</span>';
        $body = '
         
        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                
                <!-- Header con Logo y Marca -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src='.$urlLogo.' alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0; line-height: 1.2;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio</p>
                    </div>
                </div>
                
                <!-- Cuerpo del Mensaje -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Estimado usuario,</p>
                    <p style="margin: 0 0 15px 0;">El material correspondiente a su trámite '. $seccionCodigoTramite.' para la obtención de la constancia de publicación ha sido asignado a un inspector para iniciar el proceso de revisión. </p>
                    <p style="margin: 0 0 15px 0;">Recuerde revisar periódicamente su correo y su cuenta en el sistema, para mantenerse informado 
                    sobre el avance y las actualizaciones de su trámite.</p>
                    <p style="margin: 0;">Saludos cordiales.</p>
                </div>
                
                <!-- Pie de Página -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666; line-height: 1.5;">
                    <p style="margin: 0 0 2px 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 12px;">Vicerrectorado de Investigación</p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
                    
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

    public function sendMail_TramiteObservado($to,$codigoTramite){
        $this->email->setTo($to);
        $this->email->setSubject('MATERIAL OBSERVADO');
        $urlLogo = base_url('assets/icons/IntelectumLogoFondoBlanco.png');
        $seccionCodigoTramite= '<span style="font-weight: bold; color:#3F81BB;">'.$codigoTramite.'</span>';
        $body = '
         
        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                
                <!-- Header con Logo y Marca -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src='.$urlLogo.' alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0; line-height: 1.2;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio</p>
                    </div>
                </div>
                
                <!-- Cuerpo del Mensaje -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Estimado usuario,</p>
                    <p style="margin: 0 0 15px 0;">El material correspondiente a su trámite '. $seccionCodigoTramite.' para la obtención de la constancia de publicación ha sido revisado y presenta OBSERVACIONES que deben ser subsanadas. </p>
                    <p style="margin: 0 0 15px 0;">Por favor, ingrese al sistema para revisar el detalle de las observaciones y completar las correcciones correspondientes.</p>
                     <!-- Botón de Acción -->
                    <div style="text-align: center; margin: 20px 0;">
                        <a href="'.base_url().'" style="display: inline-block; padding: 14px 30px; background-color: #3F81BB; color: #ffffff; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: bold;">Ir al Sistema</a>
                    </div>
                    <p style="margin: 0 0 15px 0;">Recuerde revisar periódicamente su correo y su cuenta en el sistema, para mantenerse informado 
                    sobre el avance y las actualizaciones de su trámite.</p>
                    <p style="margin: 0;">Saludos cordiales.</p>
                </div>
                
                <!-- Pie de Página -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666; line-height: 1.5;">
                    <p style="margin: 0 0 2px 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 12px;">Vicerrectorado de Investigación</p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
                    
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

    public function sendMail_MaterialAprobado($to,$codigoTramite){
        $this->email->setTo($to);
        $this->email->setSubject('MATERIAL APROBADO');
        $urlLogo = base_url('assets/icons/IntelectumLogoFondoBlanco.png');
        $seccionCodigoTramite= '<span style="font-weight: bold; color:#3F81BB;">'.$codigoTramite.'</span>';
        $body = '
         
        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                
                <!-- Header con Logo y Marca -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src='.$urlLogo.' alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0; line-height: 1.2;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio</p>
                    </div>
                </div>
                
                <!-- Cuerpo del Mensaje -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Estimado usuario, ¡FELICIDADES!</p>
                    <p style="margin: 0 0 15px 0;">El material correspondiente a su trámite '. $seccionCodigoTramite.' ha sido APROBADO. </p>
                    <p style="margin: 0 0 15px 0;">Actualmente se encuentra en el proceso de publicación en el repositorio institucional.</p>
                    <p style="margin: 0 0 15px 0;">Recuerde revisar periódicamente su correo y su cuenta en el sistema, para mantenerse informado 
                    sobre el avance y las actualizaciones de su trámite.</p>
                    <p style="margin: 0;">Saludos cordiales.</p>
                </div>
                
                <!-- Pie de Página -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666; line-height: 1.5;">
                    <p style="margin: 0 0 2px 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 13px;">Vicerrectorado de Investigación</p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
                    
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


    public function sendMail_materialPublicado($to,$codigoTramite,$urlPublicacion){
        $this->email->setTo($to);
        $this->email->setSubject('MATERIAL PUBLICADO');
        $urlLogo = base_url('assets/icons/IntelectumLogoFondoBlanco.png');
        $seccionCodigoTramite= '<span style="font-weight: bold; color:#3F81BB;">'.$codigoTramite.'</span>';
        $body = '
         
        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                
                <!-- Header con Logo y Marca -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src='.$urlLogo.' alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0; line-height: 1.2;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio</p>
                    </div>
                </div>
                
                <!-- Cuerpo del Mensaje -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Estimado usuario, ¡FELICIDADES!</p>
                    <p style="margin: 0 0 15px 0;">El material correspondiente a su trámite '. $seccionCodigoTramite.' ha sido PUBLICADO en el repositorio institucional. </p>
                    <p style="margin: 0 0 15px 0;">Puede ver su publicación accediendo al siguiente enlace.</p>

                    <!-- Botón de Acción -->
                    <div style="text-align: center; margin: 20px 0;">
                        <a href="'.$urlPublicacion.'" style="display: inline-block; padding: 14px 30px; background-color: #3F81BB; color: #ffffff; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: bold;">Ver Publicación</a>
                    </div>

                    <p style="margin: 0 0 15px 0;">Recuerde revisar periódicamente su correo y su cuenta en el sistema, para mantenerse informado 
                    sobre el avance y las actualizaciones de su trámite.</p>
                    <p style="margin: 0;">Saludos cordiales.</p>
                </div>
                
                <!-- Pie de Página -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666; line-height: 1.5;">
                    <p style="margin: 0 0 2px 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 12px;">Vicerrectorado de Investigación</p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
                    
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

    public function sendMain_EnvioConstancia($to,$codigoTramite){
        $this->email->setTo($to);
        $this->email->setSubject('CONSTANCIA DE PUBLICACIÓN EMITIDA');
        $urlLogo = base_url('assets/icons/IntelectumLogoFondoBlanco.png');
        $seccionCodigoTramite= '<span style="font-weight: bold; color:#3F81BB;">'.$codigoTramite.'</span>';
        $body = '
         
        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">
                
                <!-- Header con Logo y Marca -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src='.$urlLogo.' alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0; line-height: 1.2;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio</p>
                    </div>
                </div>
                
                <!-- Cuerpo del Mensaje -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Estimado usuario,¡FELICIDADES!</p>
                    <p style="margin: 0 0 15px 0;">La constancia correspondiente a su trámite '. $seccionCodigoTramite.' ha sido emitida exitosamente. </p>
                    

                    <!-- Botón de Acción -->
                    <div style="text-align: center; margin: 20px 0;">
                        <a href="'.base_url('Constancia/'.$codigoTramite).'" style="display: inline-block; padding: 14px 30px; background-color: #3F81BB; color: #ffffff; text-decoration: none; border-radius: 10px; font-size: 14px; font-weight: bold;">Ver Constancia</a>
                    </div>

                </div>
                
                <!-- Pie de Página -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666; line-height: 1.5;">
                    <p style="margin: 0 0 2px 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 12px;">Vicerrectorado de Investigación</p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
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

    public function sendMail_EnvioEncuesta($to, $codigoTramite)
    {
        $this->email->setTo($to);
        $this->email->setSubject('CUENTANOS TU EXPERIENCIA USANDO EL SISTEMA');

        $urlLogo = base_url('assets/icons/IntelectumLogoFondoBlanco.png');
        $urlEncuesta = "https://forms.gle/vR4FtVesMRTAMvPn9";

        $seccionCodigoTramite = '<span style="font-weight: bold; color:#3F81BB;">' . $codigoTramite . '</span>';

        $body = '
        <div style="font-family: Arial, sans-serif; background-color: #D9D9D9; width: 100%; padding: 50px 0; margin: 0;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden;">

                <!-- Header -->
                <div style="padding: 30px 20px 20px 20px; text-align: left;">
                    <div style="display: inline-block; vertical-align: top;">
                        <img src="' . $urlLogo . '" alt="Logo" style="width: 60px; height: auto; display: block; border: 0;">
                    </div>
                    <div style="display: inline-block; vertical-align: top; margin-left: 15px;">
                        <p style="font-size: 24px; font-weight: bold; color:#0A1D2F; margin: 0;">Intelectum</p>
                        <p style="font-size: 14px; font-weight: bold; color:#3F81BB; margin: 1px 0 0 0;">Repositorio Institucional</p>
                    </div>
                </div>

                <!-- Cuerpo -->
                <div style="padding: 25px 20px; font-size: 16px; line-height: 1.6; color: #555555;">
                    <p style="margin: 0 0 15px 0;">Estimado(a) usuario(a),</p>

                    <p style="margin: 0 0 15px 0;">
                        Su trámite <strong>' . $seccionCodigoTramite . '</strong> concluyo EXITOSAMENTE!.
                        Con el fin de mejorar continuamente nuestro sistema, lo invitamos a
                        calificar su experiencia de uso.
                    </p>

                    <p style="margin: 0 0 15px 0;">
                        La encuesta es breve y sus respuestas serán tratadas de forma confidencial.
                    </p>

                    <!-- Botón Encuesta -->
                    <div style="text-align: center; margin: 25px 0;">
                        <a href="' . $urlEncuesta . '"
                        style="display: inline-block; padding: 14px 30px;
                                background-color: #3F81BB; color: #ffffff;
                                text-decoration: none; border-radius: 10px;
                                font-size: 14px; font-weight: bold;">
                            Responder encuesta
                        </a>
                    </div>

                    <p style="font-size: 14px; color:#777;">
                        Agradecemos su tiempo y colaboración.
                    </p>
                </div>

                <!-- Footer -->
                <div style="background-color: #f8f8f8; padding: 10px 20px; text-align: center; color: #666666;">
                    <p style="margin: 0; font-size: 14px;"><strong>Universidad Nacional de Ucayali</strong></p>
                    <p style="margin: 0; font-size: 12px;">Vicerrectorado de Investigación</p>
                    <p style="margin: 0; font-size: 12px;">Dirección de Producción Intelectual</p>
                </div>

            </div>
        </div>
        ';

        $this->email->setMessage($body);

        if ($this->email->send()) {
            return true;
        } else {
            log_message('error', $this->email->printDebugger(['headers']));
            return false;
        }
    }


}

?>