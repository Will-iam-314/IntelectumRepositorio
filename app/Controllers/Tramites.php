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

    public function nuevoTramite($data,$file1,$file2,$file3){

        if ($file1->isValid() && !$file1->hasMoved()) {
     
        $newNameFile1 = $file1->getClientName();
        $file1->move('repositor/material/tesis', $newNameFile1); 
    
        // Ruta relativa para guardar en DB
        $rutaFile1 = 'repositor/material/tesis' . $newNameFile1;

        // Guardar en DB junto con otros datos
        $data = [
            'titulo' => $this->request->getPost('tituloTesis'),
            'ruta_archivo' => $ruta,
        ];

        $this->tesisModel->insert($data);

        echo "Archivo guardado y registrado en DB ✅";
        } else {
            echo "No se pudo guardar el archivo ❌";
        }
    }

   

}

?>