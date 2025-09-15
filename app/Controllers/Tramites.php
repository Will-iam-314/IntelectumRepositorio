<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TramiteModel;

class Tramites extends BaseController

{

    protected $tramiteModel;

    public function __construct()
    {
        $this->tramiteModel = new TramiteModel();
    }

    public function nuevoTramite($data,$fileT,$fileDJ,$fileAP){

        //Guarda archivo de tesis

        if ($fileT->isValid() && !$fileT->hasMoved()) {
     
            $newNameFileT = 'TesisFile_'.$this->tramiteModel->generaCodigo().'.pdf';     
            $rutaFileT = APPPATH. 'repositor/material/tesis/' . $newNameFileT;

            if(file_exists($rutaFileT)){
                unlink($rutaFileT);
            }

            $fileT->move(APPPATH.'repositor/material/tesis',  $newNameFileT); 
    
        } else {
            return false;
        }

        //guarda archivo de declaracion jurada

        if($fileDJ->isValid() && !$fileDJ->hasMoved()){
            $newNameFileDJ = 'DeclaracionJurada_'.$this->tramiteModel->generaCodigo().'.pdf';
            $rutaFileDJ = APPPATH. 'repositor/tramites/declaracionesJuradas/'.$newNameFileDJ;
        
            if(file_exists($rutaFileDJ)){
                unlink($rutaFileDJ);
            }

            $fileDJ->move(APPPATH. 'repositor/tramites/declaracionesJuradas',$newNameFileDJ);

            
        }else{
            return false;
        }

        //guarda archivo de autorizacion de publicacion

        if($fileAP->isValid() && !$fileAP->hasMoved()){
            $newNameFilAP = 'DeclaracionJurada_'.$this->tramiteModel->generaCodigo().'.pdf';
            $rutaFileAP = APPPATH. 'repositor/tramites/autorizacionesPublicacion/'. $newNameFilAP;
        
            if(file_exists( $rutaFileAP)){
                unlink( $rutaFileAP);
            }

            $fileAP->move(APPPATH. 'repositor/tramites/autorizacionesPublicacion', $newNameFilAP);
           
        }else{
            return false;
        }

        $boolnewTramite = $this->tramiteModel->newTramite($data,$newNameFileT,$newNameFileDJ, $newNameFilAP);

        if($boolnewTramite){
            return true;
        }else{
            return false;
        }
      
    }

  
   

   

}

?>