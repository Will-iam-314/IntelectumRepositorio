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
            $rutaFileT = WRITEPATH . 'uploads/material/tesis/' . $newNameFileT; ;

            if(file_exists($rutaFileT)){
                unlink($rutaFileT);
            }

            $fileT->move( WRITEPATH . 'uploads/material/tesis/',$newNameFileT); 

    
        } else {
            return false;
        }

        //guarda archivo de declaracion jurada

        if($fileDJ->isValid() && !$fileDJ->hasMoved()){
            $newNameFileDJ = 'DeclaracionJurada_'.$this->tramiteModel->generaCodigo().'.pdf';
            $rutaFileDJ = WRITEPATH . 'uploads/tramites/declaracionesJuradas/'.$newNameFileDJ;
        
            if(file_exists($rutaFileDJ)){
                unlink($rutaFileDJ);
            }

            $fileDJ->move(WRITEPATH . 'uploads/tramites/declaracionesJuradas/',$newNameFileDJ);

            
        }else{
            return false;
        }

        //guarda archivo de autorizacion de publicacion

        if($fileAP->isValid() && !$fileAP->hasMoved()){
            $newNameFilAP = 'DeclaracionJurada_'.$this->tramiteModel->generaCodigo().'.pdf';
            $rutaFileAP = WRITEPATH . 'uploads/tramites/autorizacionesPublicacion/'.$newNameFilAP;
        
            if(file_exists( $rutaFileAP)){
                unlink( $rutaFileAP);
            }

            $fileAP->move( WRITEPATH . 'uploads/tramites/autorizacionesPublicacion/', $newNameFilAP);
           
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

    public function verFileTesis($filename)
    {
        $path = WRITEPATH . 'uploads/material/tesis/' . $filename;

        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Archivo no encontrado");
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody(file_get_contents($path));
    }

    public function verFileDJ($filename)
    {
        $path = WRITEPATH . 'uploads/tramites/declaracionesJuradas/' . $filename;

        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Archivo no encontrado");
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody(file_get_contents($path));
    }

    public function verFileAP($filename)
    {
        $path = WRITEPATH . 'uploads/tramites/autorizacionesPublicacion/' . $filename;

        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Archivo no encontrado");
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody(file_get_contents($path));
    }

  
   

   

}

?>