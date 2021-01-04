<?php

namespace App\Controller;

use Dompdf\Dompdf;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PDFController extends AbstractController
{
    /**
     * @Route("/recibo_fn/pdf{id}", name="pdfFNRecibo")
     */
    public function reciboFNPdfAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(EnviosFN::class);
        $envio = $repository->find($id);
        
         // Instantiate Dompdf with our options
         $dompdf = new Dompdf();
        
         $html = $this->renderView('pdf/recibo_pdf_fn.html.twig', array('envio' => $envio)); 
         
         // Load HTML to Dompdf
         $dompdf->loadHtml($html);
         
         // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
         $dompdf->setPaper('A4', 'portrait');
 
         // Render the HTML as PDF
         $dompdf->render();
 
         // Output the generated PDF to Browser (inline view)
         $dompdf->stream("Recibo Tesoreria Nacional.pdf", [
             "Attachment" => true
         ]);

    }


    /**
     * @Route("/recibo_as/pdf{id}", name="pdfASRecibo")
     */
    public function reciboASPdfAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(EnviosAS::class);
        $envio = $repository->find($id);
        
         // Instantiate Dompdf with our options
         $dompdf = new Dompdf();
        
         $html = $this->renderView('pdf/recibo_pdf_as.html.twig', array('envio' => $envio)); 
         
         // Load HTML to Dompdf
         $dompdf->loadHtml($html);
         
         // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
         $dompdf->setPaper('A4', 'portrait');
 
         // Render the HTML as PDF
         $dompdf->render();
 
         // Output the generated PDF to Browser (inline view)
         $dompdf->stream("Recibo Asistencia Social.pdf", [
             "Attachment" => true
         ]);

    }


    /**
     * @Route("/report_fn/pdf{ofrenda}/{anio}", name="reportFNPdf")
     */
    public function reportPdfAction($ofrenda, $anio)
    {   
       
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
    
    $concat = "GROUP_CONCAT(if(mes = 'Enero'," . $ofrenda . ", NULL)) as 'a',
        GROUP_CONCAT(if(mes = 'Febrero', " . $ofrenda . ", NULL)) as 'b', 
        GROUP_CONCAT(if(mes = 'Marzo'," . $ofrenda . ", NULL)) as 'c',
        GROUP_CONCAT(if(mes = 'Abril'," . $ofrenda . ", NULL)) as 'd',
        GROUP_CONCAT(if(mes = 'Mayo'," . $ofrenda . ", NULL)) as 'e',
        GROUP_CONCAT(if(mes = 'Junio'," . $ofrenda . ", NULL)) as 'f',
        GROUP_CONCAT(if(mes = 'Julio'," . $ofrenda . ", NULL)) as 'g',
        GROUP_CONCAT(if(mes = 'Agosto'," . $ofrenda . ", NULL)) as 'h',
        GROUP_CONCAT(if(mes = 'Septiembre'," . $ofrenda . ", NULL)) as 'i',
        GROUP_CONCAT(if(mes = 'Octubre'," . $ofrenda . ", NULL)) as 'j',
        GROUP_CONCAT(if(mes = 'Noviembre'," . $ofrenda . ", NULL)) as 'k',
        GROUP_CONCAT(if(mes = 'Diciembre'," . $ofrenda . ", NULL)) as 'l'";
    
        $query = "SELECT I.iglesia, " .$concat. "
        FROM envios_fn E 
        INNER JOIN user I ON I.id = E.user_id
        INNER JOIN zonas U ON U.id = I.zonas_id
        WHERE YEAR(anio) = " . $anio . " AND U.id = '1'
        GROUP BY user_id";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
    
        $query = "SELECT I.iglesia, " .$concat. "
        FROM envios_fn E 
        INNER JOIN user I ON I.id = E.user_id
        INNER JOIN zonas U ON U.id = I.zonas_id
        WHERE YEAR(anio) = " . $anio . " AND U.id = '2'
        GROUP BY user_id";
        $stmtCentro = $db->prepare($query);
        $params = array();
        $stmtCentro->execute($params);
        
        $query = "SELECT I.iglesia, " .$concat. "
        FROM envios_fn E 
        INNER JOIN user I ON I.id = E.user_id
        INNER JOIN zonas U ON U.id = I.zonas_id
        WHERE YEAR(anio) = " . $anio . " AND U.id = '3'
        GROUP BY user_id";
        $stmtSur = $db->prepare($query);
        $params = array();
        $stmtSur->execute($params);
    
        if($ofrenda === 'misionera'){
    
            $enviosMisio = $stmt->fetchAll();
            $enviosNorte = $enviosMisio;
            $enviosMisioCentro = $stmtCentro->fetchAll();
            $enviosCentro = $enviosMisioCentro;
            $enviosMisioSur = $stmtSur->fetchAll();
            $enviosSur = $enviosMisioSur;
            $ofrendas = 'Misionera';
        }
        
        if($ofrenda === 'gavillas'){
        
            $enviosGavillas = $stmt->fetchAll();
            $enviosNorte = $enviosGavillas;
            $enviosGavillasCentro = $stmtCentro->fetchAll();
            $enviosCentro = $enviosGavillasCentro;
            $enviosGavillasSur = $stmtSur->fetchAll();
            $enviosSur = $enviosGavillasSur;
            $ofrendas = 'Gavillas';
        
        } 
        if($ofrenda === 'rayos'){
        
            $enviosRayos = $stmt->fetchAll();
            $enviosNorte = $enviosRayos;
            $enviosRayosCentro = $stmtCentro->fetchAll();
            $enviosCentro = $enviosRayosCentro;
            $enviosRayosSur = $stmtSur->fetchAll();
            $enviosSur = $enviosRayosSur;
            $ofrendas = 'Rayos';
        } 
        if($ofrenda === 'fmn'){
        
            $enviosFmn = $stmt->fetchAll();
            $enviosNorte = $enviosFmn;
            $enviosFmnCentro = $stmtCentro->fetchAll();
            $enviosCentro = $enviosFmnCentro;
            $enviosFmnSur = $stmtSur->fetchAll();
            $enviosSur = $enviosFmnSur;
            $ofrendas = 'Fmn';
     }    
     if($ofrenda === 'd_diezmo'){
    
        $enviosDiezmo = $stmt->fetchAll();
        $enviosNorte = $enviosDiezmo;
        $enviosDiezmoCentro = $stmt->fetchAll();
        $enviosCentro = $enviosDiezmoCentro;
        $enviosDiezmoSur = $stmtSur->fetchAll();
        $enviosSur = $enviosDiezmoSur;
        $ofrendas = 'Diezmo de Diezmo';
    
    }  

        
    $dompdf = new Dompdf();
        
    $html = $this->renderView('pdf/reporte_fn.html.twig', array( 
        'ofrendas' => $ofrendas, 
        'ofrenda' => $ofrenda, 
        'anio' => $anio, 
        'enviosNorte' => $enviosNorte,
        'enviosCentro' => $enviosCentro, 
        'enviosSur' => $enviosSur)); 
        
    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
    
    // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser (inline view)
    $dompdf->stream("Reporte Anual de Ofrendas.pdf", [
        "Attachment" => true
    ]);
     
        
    }


    /**
     * @Route("/report_as/pdf{aporte}/{anio}", name="reportASPdf")
     */
    public function reportASPdfAction($aporte, $anio)
    {   
       
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
    
        $concat = "GROUP_CONCAT(if(mes = 'Enero'," . $aporte . ", NULL)) as 'a',
        GROUP_CONCAT(if(mes = 'Febrero', " . $aporte . ", NULL)) as 'b', 
        GROUP_CONCAT(if(mes = 'Marzo'," . $aporte . ", NULL)) as 'c',
        GROUP_CONCAT(if(mes = 'Abril'," . $aporte . ", NULL)) as 'd',
        GROUP_CONCAT(if(mes = 'Mayo'," . $aporte . ", NULL)) as 'e',
        GROUP_CONCAT(if(mes = 'Junio'," . $aporte . ", NULL)) as 'f',
        GROUP_CONCAT(if(mes = 'Julio'," . $aporte . ", NULL)) as 'g',
        GROUP_CONCAT(if(mes = 'Agosto'," . $aporte . ", NULL)) as 'h',
        GROUP_CONCAT(if(mes = 'Septiembre'," . $aporte . ", NULL)) as 'i',
        GROUP_CONCAT(if(mes = 'Octubre'," . $aporte . ", NULL)) as 'j',
        GROUP_CONCAT(if(mes = 'Noviembre'," . $aporte . ", NULL)) as 'k',
        GROUP_CONCAT(if(mes = 'Diciembre'," . $aporte . ", NULL)) as 'l'";

        $query = "SELECT I.iglesia, " .$concat. "
        FROM envios_as E 
        INNER JOIN user I ON I.id = E.user_id
        INNER JOIN zonas U ON U.id = I.zonas_id
        WHERE YEAR(anio) = " . $anio . " AND U.id = '1'
        GROUP BY user_id";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);

    
        $query = "SELECT I.iglesia, " .$concat. "
        FROM envios_as E 
        INNER JOIN user I ON I.id = E.user_id
        INNER JOIN zonas U ON U.id = I.zonas_id
        WHERE YEAR(anio) = " . $anio . " AND U.id = '2'
        GROUP BY user_id";
        $stmtCentro = $db->prepare($query);
        $params = array();
        $stmtCentro->execute($params);
        
        $query = "SELECT I.iglesia, " .$concat. "
        FROM envios_as E 
        INNER JOIN user I ON I.id = E.user_id
        INNER JOIN zonas U ON U.id = I.zonas_id
        WHERE YEAR(anio) = " . $anio . " AND U.id = '3'
        GROUP BY user_id";
        $stmtSur = $db->prepare($query);
        $params = array();
        $stmtSur->execute($params);
    
        if($aporte === 'aporte_a'){
    
            $enviosMisio = $stmt->fetchAll();
            $enviosNorte = $enviosMisio;
            $enviosMisioCentro = $stmtCentro->fetchAll();
            $enviosCentro = $enviosMisioCentro;
            $enviosMisioSur = $stmtSur->fetchAll();
            $enviosSur = $enviosMisioSur;
            $aportes = 'Aporte Voluntario 1';
        }
        
        if($aporte === 'aporte_b'){
        
            $enviosGavillas = $stmt->fetchAll();
            $enviosNorte = $enviosGavillas;
            $enviosGavillasCentro = $stmtCentro->fetchAll();
            $enviosCentro = $enviosGavillasCentro;
            $enviosGavillasSur = $stmtSur->fetchAll();
            $enviosSur = $enviosGavillasSur;
            $aportes = 'Aporte Voluntario 2';
        
        } 
        

        
    $dompdf = new Dompdf();
        
    $html = $this->renderView('pdf/reporte_as.html.twig', array( 
        'aportes' => $aportes, 
        'aporte' => $aporte, 
        'anio' => $anio, 
        'enviosNorte' => $enviosNorte,
        'enviosCentro' => $enviosCentro, 
        'enviosSur' => $enviosSur)); 
        
    // Load HTML to Dompdf
    $dompdf->loadHtml($html);
    
    // (Optional) Setup the paper size and orientation 'portrait' or 'landscape'
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser (inline view)
    $dompdf->stream("Reporte Anual Asistencia Social.pdf", [
        "Attachment" => true
    ]);
     
        
    }



}
