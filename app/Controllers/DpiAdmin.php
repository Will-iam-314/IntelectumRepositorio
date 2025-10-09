<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TramiteModel;
use App\Models\HistorialTramitesModel;
use TCPDF; // Mantenemos TCPDF
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

use setasign\Fpdi\Tcpdf\Fpdi; 

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

    public function generarConstancia($codigoTramite){

        /*

            1. CADA CONSTANCIA TIENE UN CODIGO ASIQ EU CREAR LA FUNCION PARA GENERAR EL CODIGO
            2. LA BD EN TRAMITE DEBE DE TENER UNA ATRIBUTO PARA EL CODIGO DE LA CONSTANCIA
            3. COMO LA RUTA DE LA CONSTANCIA ESTA EN WRITABLE CREAR UNA FUNCION PARA LEER DICHO PDF
            4. NOMENCLATURA PARA EL NOMBRE DE LA CONSTANCIA: constancia_*codigo/serieconstnacia_*codigotramite
            5. generar qr.


        */

        // --- 0. DATOS SIMULADOS ---
        $numConstancia = "00225-" . date('Y');
        $tituloTrabajo = "INCIDENCIA DE LA INVERSIÓN PÚBLICA EN LAS ACTIVIDADES ECONÓMICAS DEL DISTRITO DE MANANTAY 2010-2024";
        
        // 🔑 DATOS DE AUTORES: Ahora es un array de nombres
        $autores = [
            "Guzman Novoa, Luis Angel",
            "Mendoza Ramos, Ana Lucía"
            
        ];
        
        $autoresTexto = implode(', ', $autores); // Une los autores en una sola cadena
        
        $urlRepositorio = "https://hdl.handle.net/20.500.14621/7940";
        $fechaEmision = "Pucallpa 8 de octubre del " . date('Y');
        
        // 🚨 RUTA DE IMÁGENES:
        $rutaLogo = FCPATH.'assets/img/unu.png'; 
        $rutaFirma = FCPATH . 'images/firma_director.png'; //

        // --- 0. PREPARACIÓN DE RUTAS ---
        $rutaGuardaPdf = WRITEPATH. "uploads/constancias/constancia_{$codigoTramite}.pdf";
        $qrPath = WRITEPATH . 'uploads/constancias/qrs/qr_' . $codigoTramite . '.png';
       
        // 1️⃣ Crear el QR
        $urlConstancia = base_url('Constancia/'.$codigoTramite);
        
        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $urlConstancia,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,

        );

        $result = $builder->build();        
        $result->saveToFile($qrPath);

        // 2️⃣ Crear el el PDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        
        // AJUSTES DE PÁGINA
        $pdf->SetMargins(25, 20, 25); 
        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        
        // --- 2.1 LOGO Y CABECERA (Alineación de Imagen) ---
        if (file_exists($rutaLogo)) {
            $pdf->Image($rutaLogo, 30, 19, 18, 20, 'PNG');
        }
        
        // Títulos de la Universidad
        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->SetXY(55, 20); // Ajustado a Y=22
        $pdf->Write(0, 'Universidad Nacional de Ucayali');
        $pdf->SetFont('helvetica', '', 16);
        $pdf->SetXY(65, 27);
        $pdf->Write(0, 'Vicerrectorado de Investigación');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetXY(69, 34);
        $pdf->Write(0, 'Dirección de Producción Intelectual');
        
        // --- 2.2 TÍTULO PRINCIPAL ---
        $pdf->Ln(15);
        $pdf->SetFont('helvetica', 'B', 36);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(0, 10, 'CONSTANCIA DE', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $pdf->Cell(0, 5, 'PUBLICACIÓN', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        
        // --- 2.3 NÚMERO DE CONSTANCIA ---
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', '', 18);
        $pdf->SetTextColor(0, 0, 0); 
        $pdf->Cell(0, 5, "N° {$numConstancia}", 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        $pdf->SetTextColor(0, 0, 0);
        
        // --- 2.4 CUERPO DEL TEXTO INTRODUCTORIO ---
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', '', 14); 
        $pdf->MultiCell(0, 15, 
            "La Dirección de Producción Intelectual de la Universidad Nacional de Ucayali, hace constar por la presente, que el trabajo de investigación titulado: ", 
            0, 'J', 0, 1, '', '', false
        );
        
        // Título de la Tesis (Negrita)
        $pdf->Ln(3);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->MultiCell(0, 15, 
            "“{$tituloTrabajo}”", 
            0, 'J', 0, 1, '', '', true
        );
        $pdf->SetFont('helvetica', '', 12); 
        
        // --- 2.5 CAJA DE AUTOR(ES) (DINÁMICA) ---
        $pdf->Ln(5);
        $x_inicio = $pdf->GetX();
        $y_inicio = $pdf->GetY();
        $ancho_col1 = 30; // Ancho fijo para "Autor(es)"
        $ancho_col2 = 155; // Ancho restante (175 - 30)

        // 🔑 1. Calcular la altura que ocupará la lista de autores
       
        
        // 🔑 2. Dibujar la celda de la etiqueta "Autor(es)" con la altura calculada
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->MultiCell($ancho_col1, 10, 'Autor(es)', 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'M');
        
        // 🔑 3. Dibujar la celda de los nombres con la misma altura
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', '', 11);
        $pdf->MultiCell($ancho_col2, 10, $autoresTexto, 1, 'L', 0, 0, '', '', true, 0, false, true, 0, 'T'); 
        
        // --- 2.6 URL DEL REPOSITORIO ---
        $pdf->Ln(8);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0, 'Ha sido publicado en el Repositorio Institucional y se codificó con el siguiente URL:');
        
        // Caja de la URL
        $pdf->Ln(8);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 6, $urlRepositorio, 1, 1, 'C', 0, '', 0, false, 'T', 'M');
        
        // --- 2.7 QR y FIRMA (Sección Inferior) ---
        
        $pdf->Ln(10);
        $y_firma_seccion = $pdf->GetY();
        
        // POSICIÓN DEL QR (Izquierda)
        $qrWidth = 45; 
        $qrX = 25; 
        $qrY = $y_firma_seccion; 
        $pdf->Image($qrPath, $qrX, $qrY, $qrWidth, $qrWidth, 'PNG');
        
        // FECHA (Derecha, arriba de la firma)
        $pdf->SetFont('helvetica', '', 11);
        $pdf->SetXY($qrX + $qrWidth + 50, $y_firma_seccion); 
        $pdf->Write(0, $fechaEmision);

        // IMAGEN DE FIRMA (Derecha, debajo de la fecha)
        if (file_exists($rutaFirma)) {
            // Posición ajustada para alinear con la imagen de referencia
            $pdf->Image($rutaFirma, $qrX + $qrWidth + 50, $y_firma_seccion + 10, 50, 30, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }
        
        // Nombre y Cargo del Director (Debajo de la firma)
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetXY($qrX + $qrWidth + 50, $y_firma_seccion + 35); 
        $pdf->Cell(0, 5, 'Mg. JOSÉ MANUEL CÁRDENAS BERNAOLA', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetXY($qrX + $qrWidth + 50, $y_firma_seccion + 39);
        $pdf->Cell(0, 5, 'Director de Producción Intelectual', 0, 1, 'L');

        // --- 3️⃣ GUARDAR Y DESCARGAR ---
        $pdf->Output($rutaGuardaPdf, 'F');
       
        return view('dpi/Constancia',['codigoTramite' => $codigoTramite]);
        
    } 

    public function verConstancia($nombreArchivo)
    {
        $ruta = WRITEPATH . "uploads/constancias/constancia_" . basename($nombreArchivo).'.pdf';
        if (!file_exists($ruta)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Archivo no encontrado");
        }
        //return $this->response->download($ruta, null)->setFileName($nombreArchivo); 

        return $this->response->setHeader('Content-Type', 'application/pdf')->setBody(file_get_contents($ruta));
    }
}
