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

use App\Libraries\MailService;

use App\Models\SolicitantesModel;

class DpiAdmin extends BaseController
{
    public function index()
    {
        return view('dpi/home');
    }

    public function getViewSolicitudes(){
        $tramitesModel = new TramiteModel();
        

        $dataTramite = $tramitesModel->getTramites();


        return view('dpi/Solicitudes', ['tramites' => $dataTramite]);

    }

    public function getViewConstancia($codigoTramite){
        $tramitesModel = new TramiteModel(); 
        $dataTramite = $tramitesModel->getTramite($codigoTramite);
        return view('dpi/Constancia',['codigoTramite' => $codigoTramite,'dniSolicitante' => $dataTramite['solicitanteDNI']]);

    }

    public function generarConstancia($codigoTramite){

        $tramitesModel = new TramiteModel(); 
        $dataTramite = $tramitesModel->getTramite($codigoTramite);

        /*

            4. NOMENCLATURA PARA EL NOMBRE DE LA CONSTANCIA: constancia_*codigo/serieconstnacia_*codigotramite

        */

        //**************  CONTRUCCION DEL NUMERO DE CONSTANCIA *********************//

            //    Empezamos en la posición 3 (índice 3), que es el primer '0'.
            $sinPrefijo = substr($codigoTramite, 3); // Resultado: '000125' 

            // 2. Extraer el número de trámite (los primeros 4 dígitos del string restante)
            $numeroTramite = substr($sinPrefijo, 0, 4); // Resultado: '0001'
            
        
            // 3. Extraer el año (los últimos 2 dígitos del string restante)
            //    Empezamos en la posición 4 (índice 4), o usamos un índice negativo.
            $anioCorto = substr($sinPrefijo, 4, 2); // Resultado: '25'

            // 4. Construir el año completo
            $anioCompleto = '20' . $anioCorto; // Resultado: '2025'

            // 5. Combinar los resultados con el guion
            $numConstancia = $numeroTramite . '-' . $anioCompleto;

        //**** TITULO DEL MATERIAÑ */
            $tituloTrabajo = $dataTramite['tituloMaterial'];

        //***** AUTORES */
            $autores=[];
            foreach($dataTramite['autores'] as $autor){
                $autores[]=$autor['nombre'];
            }
        
        //*** URL PUBLICACION */
            $urlRepositorio = $dataTramite['urlPublicacion'];
        
        //*** FECHA ACTUAL */
            $mesesEnEspanol = [
                1 => 'enero',
                'febrero',
                'marzo',
                'abril',
                'mayo',
                'junio',
                'julio',
                'agosto',
                'septiembre',
                'octubre',
                'noviembre',
                'diciembre'
            ];

            $dia = date('d');
            $numeroMes = date('n'); // 'n' da el número del mes sin ceros iniciales (1 a 12)
            $anio = date('Y');

            $nombreMes = $mesesEnEspanol[$numeroMes];

            $fechaEmision = "Pucallpa ".$dia." de ".$nombreMes." del " . $anio;
        
        // 🚨 RUTA DE IMÁGENES:
            $rutaLogo = FCPATH.'assets/img/unu.png'; 
            $rutaFirma = FCPATH . 'assets/img/firmaDirector.png'; 

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
        $pdf->SetFont('helvetica', 'B', 25);
        $pdf->Cell(0, 5, 'URL', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
        
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
        
        // --- 2.5 CAJA DE AUTOR(ES)---
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 6,'Autor(es)', 1, 1, 'C', 0, '', 0, false, 'T', 'M');

        
        foreach($autores as $autor){
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 6, $autor, 1, 1, 'C', 0, '', 0, false, 'T', 'M');
        }
        
        // --- 2.6 URL DEL REPOSITORIO ---
        $pdf->Ln(8);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Write(0, 'Ha sido publicado en el Repositorio Institucional y se codificó con el siguiente URL:');
        
        // Caja de la URL
        $pdf->Ln(8);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 8, $urlRepositorio, 1, 1, 'C', 0, '', 0, false, 'T', 'M');
        
        // --- 2.7 QR y FIRMA (Sección Inferior) ---
        
        $pdf->Ln(10);
        $y_firma_seccion = $pdf->GetY();
        
        // POSICIÓN DEL QR (Izquierda)
        $qrWidth = 55; 
        $qrX = 25; 
        $qrY = $y_firma_seccion; 
        $pdf->Image($qrPath, $qrX, $qrY, $qrWidth, $qrWidth, 'PNG');
        
        // FECHA (Derecha, arriba de la firma)
        $pdf->SetFont('helvetica', '', 11);
        $pdf->SetXY($qrX + $qrWidth +40, $y_firma_seccion); 
        $pdf->Write(0, $fechaEmision);

        // IMAGEN DE FIRMA (Derecha, debajo de la fecha)
        if (file_exists($rutaFirma)) {
            // Posición ajustada para alinear con la imagen de referencia
            $pdf->Image($rutaFirma, $qrX + $qrWidth+10 , $y_firma_seccion + 10, 75, 50, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }       
      

        // --- 3️⃣ GUARDAR Y DESCARGAR ---
        $pdf->Output($rutaGuardaPdf, 'F');

        //**** ACTUALIZAR ESTADO DEL TRAMITE Y GUARDAR HISTORIAL DEL TRAMITE */

        $historialModel = new HistorialTramitesModel();
        $tramitesModel->updateEstado($dataTramite['idTramite'], 7);
        $historialModel->newHistorialTramite(session('id'),$dataTramite['idTramite'],session('rol'),7);


       
       ///
        return view('dpi/Constancia',['codigoTramite' => $codigoTramite,'dniSolicitante' => $dataTramite['solicitanteDNI']]);
        
    } 
 
    public function enviarConstancia($dni,$codigoTramite){
       
        $solicitanteModel = new SolicitantesModel();
        $solicitanteData = $solicitanteModel->getSolicitantePorDNI($dni);
        $solicitanteCorreo = $solicitanteData['correo'];

        $mail = new MailService();            
        $boolmail = $mail->sendMain_EnvioConstancia($solicitanteCorreo,$codigoTramite);
        $mail->sendMail_EnvioEncuesta($solicitanteCorreo,$codigoTramite);
        
        if($boolmail){
            return redirect()->back()->withInput()->with('success','Correo Enviado Existosamente!');
        }else{
            return;
        }
    }

    public function verConstancia($nombreArchivo)
    {
        $ruta = WRITEPATH . "uploads/constancias/constancia_" . basename($nombreArchivo).'.pdf';
        if (!file_exists($ruta)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Archivo no encontrado");
        }
        //return $this->response->download($ruta, null)->setFileName($nombreArchivo); 
        return $this->response
               ->setHeader('Content-Type', 'application/pdf')
               ->setBody(file_get_contents($ruta));
    }
}
