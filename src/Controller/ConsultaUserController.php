<?php

namespace App\Controller;

use App\Entity\EnviosAS;
use App\Entity\EnviosFN;
use App\Form\ReportASType;
use PDO;
use App\Form\ReporteFNType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultaUserController extends AbstractController
{
    /**
     * @Route("/consulta_fn/user", name="consultaFN_user")
     */
    public function consultaUser(): Response
    {
        $idUser = $this->getUser()->getId();
        $user = $this->getUser()->getIglesia();
  
        $em = $this->getDoctrine()->getManager();
        $envio = $em->getRepository(EnviosFN::class)->findBy(array('user' => $idUser), array('create_at' => 'DESC')); 
  
          return $this->render('consulta_user/consultaUser.html.twig', array('user' => $user,'envio' => $envio));
      }


     /**
     * @Route("/consulta_fn/super", name="consultaFN_super")
     */
    public function consultaSuper(): Response
    {
        
        $user = $this->getUser()->getIglesia();
        $zonaUser = $this->getUser()->getZonas();


        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        $queryEnvio = "SELECT I.iglesia, E.id, fecha, mes, anio, operacion, cajero, d_diezmo, f_solidario, cuota_socio, diezmo_personal, misionera, rayos, gavillas, fmn, total, create_at 
        FROM `envios_fn` E 
        INNER JOIN user I ON I.id = E.user_id
        INNER JOIN zonas U ON U.id = I.zonas_id WHERE zona = '" . $zonaUser . "' ";

            $envioStmt = $db->prepare($queryEnvio);
            $paramsAnio = array();
            $envioStmt->execute($paramsAnio);
            $envio = $envioStmt->fetchAll();

            
          return $this->render('consulta_user/consultaSuper.html.twig', array('zonaUser' => $zonaUser, 'user' => $user,'envio' => $envio));
      }

    /**
     * @Route("/consulta_as/user", name="consultaAS_user")
     */
    public function consultaAsistenciaUser(): Response
    {
        $idUser = $this->getUser()->getId();
        $user = $this->getUser()->getIglesia();
  
        $em = $this->getDoctrine()->getManager();
        $envio = $em->getRepository(EnviosAS::class)->findBy(array('user' => $idUser), array('createAt' => 'DESC')); 

          return $this->render('consulta_user/consultaASUser.html.twig', array('user' => $user,'envio' => $envio));
      }


    /**
     * @Route("/consulta_as/super", name="consultaAS_super")
     */
    public function consultaAsistenciaSuper(): Response
    {
        
        $user = $this->getUser()->getIglesia();
        $zonaUser = $this->getUser()->getZonas();


        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        $queryEnvio = "SELECT I.iglesia, E.id, fecha, mes, anio, operacion, cajero, aporte_a, aporte_b, total, create_at 
        FROM `envios_as` E 
        INNER JOIN user I ON I.id = E.user_id
        INNER JOIN zonas U ON U.id = I.zonas_id WHERE zona = '" . $zonaUser . "' ";

            $envioStmt = $db->prepare($queryEnvio);
            $paramsAnio = array();
            $envioStmt->execute($paramsAnio);
            $envio = $envioStmt->fetchAll();

            
          return $this->render('consulta_user/consultaASSuper.html.twig', array('zonaUser' => $zonaUser, 'user' => $user,'envio' => $envio));
      }

      
//Reporte cruzado por aportes Asistencia Social
    /**
     * @Route("/reporte/asistencia", name="report_as")
     */
    public function reportAsistenciaAction(Request $request)
      {   
            
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        $queryAnio = "SELECT DISTINCT YEAR(anio)  FROM envios_fn";
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


          $form = $this->createForm(ReportASType::class, $optionAnio);   
      
          $form->handleRequest($request);
      
          if ($form->isSubmitted() && $form->isValid()) { 


          $aporte = $form->get("aporte")->getData();
          $anio = $form->get("anio")->getData();
          

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

      if($aporte === 'aporte_a'){

          $enviosMisioNorte = $stmt->fetchAll();
          $enviosNorte = $enviosMisioNorte;
          $aportes = 'Aporte Voluntario 1';

      }

      if($aporte === 'aporte_b'){

          $enviosGavillasNorte = $stmt->fetchAll();
          $enviosNorte = $enviosGavillasNorte;
          $aportes = 'Aporte Voluntario 2';

      } 

      $query = "SELECT I.iglesia, " .$concat. "
      FROM envios_as E 
      INNER JOIN user I ON I.id = E.user_id
      INNER JOIN zonas U ON U.id = I.zonas_id
      WHERE YEAR(anio) = " . $anio . " AND U.id = '2'
      GROUP BY user_id";
          $stmtCentro = $db->prepare($query);
          $params = array();
          $stmtCentro->execute($params);

          if($aporte === 'aporte_a'){

              $enviosMisioCentro = $stmtCentro->fetchAll();
              $enviosCentro = $enviosMisioCentro;
          }
          if($aporte === 'aporte_b'){
          
              $enviosGavillasCentro = $stmtCentro->fetchAll();
              $enviosCentro = $enviosGavillasCentro;
          } 
            
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

              $enviosMisioSur = $stmtSur->fetchAll();
              $enviosSur = $enviosMisioSur;
              $aportes = 'Aporte Voluntario 1';
          }
          if($aporte === 'aporte_b'){
          
              $enviosGavillasSur = $stmtSur->fetchAll();
              $enviosSur = $enviosGavillasSur;
              $aportes = 'Aporte Voluntario 2';
          
          } 

      return $this->render('consulta_user/report_as.html.twig', array(
          'aportes' => $aportes, 
          'aporte' => $aporte, 
          'anio' => $anio, 
          'enviosNorte' => $enviosNorte,
          'enviosCentro' => $enviosCentro, 
          'enviosSur' => $enviosSur
      ));
          
      }
 
     return $this->render('consulta_user/reporte_as.html.twig', array('form' => $form->createView()));
    }

//Fin reporte Asistencia Social


//Reporte cruzado por ofrendas FONDO NACIONAL
   

    /**
     * @Route("/reporte/nacional", name="report_fn")
     */
    public function reportAction(Request $request)
    {   
           
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        $queryAnio = "SELECT DISTINCT YEAR(anio)  FROM envios_fn";
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
    
    
        $form = $this->createForm(ReporteFNType::class, $optionAnio);   
     
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
        WHERE YEAR(anio) = " . $anio . " AND U.id = '1'
        GROUP BY user_id";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
    
    
        if($ofrenda === 'misionera'){
    
            $enviosMisio = $stmt->fetchAll();
            $enviosNorte = $enviosMisio;
            $ofrendas = 'Misionera';
        }
        if($ofrenda === 'gavillas'){
        
            $enviosGavillas = $stmt->fetchAll();
            $enviosNorte = $enviosGavillas;
            $ofrendas = 'Gavillas';
        
        } 
        if($ofrenda === 'rayos'){
        
            $enviosRayos = $stmt->fetchAll();
            $enviosNorte = $enviosRayos;
            $ofrendas = 'Rayos';
        } 
        if($ofrenda === 'fmn'){
        
            $enviosFmn = $stmt->fetchAll();
                $enviosNorte = $enviosFmn;
                $ofrendas = 'Fmn';
     }    
     if($ofrenda === 'd_diezmo'){
    
        $enviosDiezmo = $stmt->fetchAll();
        $enviosNorte = $enviosDiezmo;
        $ofrendas = 'Diezmo de Diezmo';
    
    }  
    
     $query = "SELECT I.iglesia, " .$concat. "
     FROM envios_fn E 
     INNER JOIN user I ON I.id = E.user_id
     INNER JOIN zonas U ON U.id = I.zonas_id
     WHERE YEAR(anio) = " . $anio . " AND U.id = '2'
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
        if($ofrenda === 'd_diezmo'){
    
            $enviosDiezmoCentro = $stmt->fetchAll();
            $enviosCentro = $enviosDiezmoCentro;
        
        }  
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
     if($ofrenda === 'd_diezmo'){
    
        $enviosDiezmoSur = $stmtSur->fetchAll();
        $enviosSur = $enviosDiezmoSur;
        $ofrendas = 'Diezmo de Diezmo';
    
    }

    
     return $this->render('consulta_user/report_fn.html.twig', array(
         'ofrendas' => $ofrendas, 
         'ofrenda' => $ofrenda, 
         'anio' => $anio, 
         'enviosNorte' => $enviosNorte,
         'enviosCentro' => $enviosCentro, 
         'enviosSur' => $enviosSur
    ));
        
    }
     
         return $this->render('consulta_user/reporte_fn.html.twig', array('form' => $form->createView()));
    }
//Fin reporte Fondo Nacional


}
