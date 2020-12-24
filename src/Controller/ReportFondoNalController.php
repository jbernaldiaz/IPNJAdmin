<?php

namespace App\Controller;

use App\Entity\EnviosFN;
use App\Form\ReporteOfrendasNacionalesType;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportFondoNalController extends AbstractController
{

/*
    private function getYears($min, $max='current')
    {
         $years = range($min, ($max === 'current' ? date('Y') : $max));

         return array_combine($years, $years);
    }

    private function ()
    {
    
        $form = $this->createForm(ReporteOfrendasNacionalesType::class);

        return $this->render('report_fondo_nal/report.html.twig', [
            'form' => $form->createView(),
        ]);
    }
*/

    /**
     * @Route("/report/fondo/nal", name="report_fondo_nal")
     */
    

public function reportAction(Request $request)
{   
       
    $em = $this->getDoctrine()->getManager();
    $db = $em->getConnection();
    $queryAnio = "SELECT DISTINCT anio  FROM envios_fn";
    $anioStmt = $db->prepare($queryAnio);
    $paramsAnio = array();
    $anioStmt->execute($paramsAnio);
    $aniosResult = $anioStmt->fetchAll(PDO::FETCH_COLUMN);

$arrayResultMap = array();

foreach ($aniosResult as $valor) {
   $arrayResultMap[$valor] = $valor;
}


$optionAnio = array();
$optionAnio["aniosResult"] = $aniosResult;
$optionAnio["arrayResulMap"] = $arrayResultMap;

    $form = $this->createForm(ReporteOfrendasNacionalesType::class, $optionAnio);   
 
    $form->handleRequest($request);
 
    if ($form->isSubmitted() && $form->isValid()) { 


    $ofrenda = $form->get("ofrenda")->getData();
    $anio = $form->get("anio")->getData();
    

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
    WHERE anio = " . $anio . " AND U.id = '1'
    GROUP BY user_id";
    $stmt = $db->prepare($query);
    $params = array();
    $stmt->execute($params);

if($ofrenda === 'misionera'){

    $enviosMisioNorte = $stmt->fetchAll();
    $enviosNorte = $enviosMisioNorte;

}

if($ofrenda === 'gavillas'){

    $enviosGavillasNorte = $stmt->fetchAll();
    $enviosNorte = $enviosGavillasNorte;

} 
if($ofrenda === 'rayos'){

    $enviosRayosNorte = $stmt->fetchAll();
        $enviosNorte = $enviosRayosNorte;

}     

if($ofrenda === 'fmn'){

    $enviosFmnNorte = $stmt->fetchAll();
        $enviosNorte = $enviosFmnNorte;
 }
    
 $query = "SELECT I.iglesia, " .$concat. "
 FROM envios_fn E 
 INNER JOIN user I ON I.id = E.user_id
 INNER JOIN zonas U ON U.id = I.zonas_id
 WHERE anio = " . $anio . " AND U.id = '2'
 GROUP BY user_id";
    $stmtCentro = $db->prepare($query);
    $params = array();
    $stmtCentro->execute($params);

    if($ofrenda === 'misionera'){

        $enviosMisioCentro = $stmtCentro->fetchAll();
        $enviosCentro = $enviosMisioCentro;
    }
    if($ofrenda === 'gavillas'){
    
        $enviosGavillasCentro = $stmtCentro->fetchAll();
        $enviosCentro = $enviosGavillasCentro;
    } 
    if($ofrenda === 'rayos'){
    
        $enviosRayosCentro = $stmtCentro->fetchAll();
        $enviosCentro = $enviosRayosCentro;
    
    } 
    if($ofrenda === 'fmn'){
    
        $enviosFmnCentro = $stmtCentro->fetchAll();
            $enviosCentro = $enviosFmnCentro;
    
    }       
    
    $query = "SELECT I.iglesia, " .$concat. "
    FROM envios_fn E 
    INNER JOIN user I ON I.id = E.user_id
    INNER JOIN zonas U ON U.id = I.zonas_id
    WHERE anio = " . $anio . " AND U.id = '3'
    GROUP BY user_id";
    $stmtSur = $db->prepare($query);
    $params = array();
    $stmtSur->execute($params);


    if($ofrenda === 'misionera'){

        $enviosMisioSur = $stmtSur->fetchAll();
        $enviosSur = $enviosMisioSur;
        $ofrendas = 'Misionera';
    }
    if($ofrenda === 'gavillas'){
    
        $enviosGavillasSur = $stmtSur->fetchAll();
        $enviosSur = $enviosGavillasSur;
        $ofrendas = 'Gavillas';
    
    } 
    if($ofrenda === 'rayos'){
    
        $enviosRayosSur = $stmtSur->fetchAll();
        $enviosSur = $enviosRayosSur;
        $ofrendas = 'Rayos';
    } 
    if($ofrenda === 'fmn'){
    
        $enviosFmnSur = $stmtSur->fetchAll();
            $enviosSur = $enviosFmnSur;
            $ofrendas = 'Fmn';
 }    

 return $this->render('report_fondo_nal/index.html.twig', array(
     'ofrendas' => $ofrendas, 
     'ofrenda' => $ofrenda, 
     'anio' => $anio, 
     'enviosNorte' => $enviosNorte,
     'enviosCentro' => $enviosCentro, 
     'enviosSur' => $enviosSur
));
    
}
 
     return $this->render('report_fondo_nal/report.html.twig', array('form' => $form->createView()));
}


}
