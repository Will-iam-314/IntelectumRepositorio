<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TramiteModel;
use App\Models\HistorialTramitesModel;
use TCPDF;

class DpiAdmin extends BaseController
{
    public function index()
    {
        return view('dpi/home');
    }

    public function getViewSolicitudes(){
        $tramitesModel = new TramiteModel();
        $historialModel = new HistorialTramitesModel();

        $dataTramite = $tramitesModel->getTramites();


        return view('dpi/Solicitudes', ['tramites' => $dataTramite]);

    }

    public function generarConstancia(){

        /*

            1. CADA CONSTANCIA TIENE UN CODIGO ASIQ EU CREAR LA FUNCION PARA GENERAR EL CODIGO
            2. LA BD EN TRAMITE DEBE DE TENER UNA ATRIBUTO PARA EL CODIGO DE LA CONSTANCIA
            3. COMO LA RUTA DE LA CONSTANCIA ESTA EN WRITABLE CREAR UNA FUNCION PARA LEER DICHO PDF
            4. NOMENCLATURA PARA EL NOMBRE DE LA CONSTANCIA: constancia_*codigo/serieconstnacia_*codigotramite
            5. generar qr.


        */









        // 1. Crear una instancia de TCPDF
        // Parámetros: Orientación ('P' portrait/vertical), Unidad ('mm'), Formato ('A4')
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // 2. Configuración Inicial del Documento
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Tu Nombre');
        $pdf->SetTitle('Mi Primera Constancia PDF');
        $pdf->SetSubject('Constancia Generada con CodeIgniter 4');

        // Desactivar encabezado y pie de página por defecto de TCPDF
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Márgenes (ejemplo: 20mm en los cuatro lados)
        $pdf->SetMargins(20, 20, 20, true);
        
        // Agregar una página al documento
        $pdf->AddPage();

        // 3. Añadir Contenido (Texto de Prueba)
        
        // Fuente y tamaño
        $pdf->SetFont('helvetica', 'B', 20);
        
        // Escribir un título centrado
        $pdf->Cell(0, 10, 'CONSTANCIA DE PRUEBA', 0, 1, 'C'); // Ancho 0 (todo el ancho), Alto 10, Sin borde, Nueva línea, Alineación C (Centro)
        
        // Salto de línea
        $pdf->Ln(10);
        
        $pdf->SetFont('helvetica', '', 12);
        $pdf->write(0, 'Este es el contenido de tu PDF generado con éxito usando CodeIgniter 4 y TCPDF.', '', 0, 'L', true, 0, false, true, 0);

        // 4. Salida del PDF
        // 'D' (Download): Fuerza la descarga del archivo.
        // 'I' (Inline): Muestra el PDF en el navegador.
        // 'F' (File): Guarda el PDF en el servidor.
        $pdf->Output('constancia_ejemplo.pdf', 'F'); 
    }
}
