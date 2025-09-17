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
            $rutaFileT = base_archives_material_tesis($newNameFileT) ;

            if(file_exists($rutaFileT)){
                unlink($rutaFileT);
            }

            $fileT->move(base_archives_material_tesis(),$newNameFileT); 

    
        } else {
            return false;
        }

        //guarda archivo de declaracion jurada

        if($fileDJ->isValid() && !$fileDJ->hasMoved()){
            $newNameFileDJ = 'DeclaracionJurada_'.$this->tramiteModel->generaCodigo().'.pdf';
            $rutaFileDJ = base_archives_tramites_dj($newNameFileDJ);
        
            if(file_exists($rutaFileDJ)){
                unlink($rutaFileDJ);
            }

            $fileDJ->move(base_archives_tramites_dj(),$newNameFileDJ);

            
        }else{
            return false;
        }

        //guarda archivo de autorizacion de publicacion

        if($fileAP->isValid() && !$fileAP->hasMoved()){
            $newNameFilAP = 'DeclaracionJurada_'.$this->tramiteModel->generaCodigo().'.pdf';
            $rutaFileAP = base_archives_tramites_auth_pub($newNameFilAP);
        
            if(file_exists( $rutaFileAP)){
                unlink( $rutaFileAP);
            }

            $fileAP->move(base_archives_tramites_auth_pub(), $newNameFilAP);
           
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