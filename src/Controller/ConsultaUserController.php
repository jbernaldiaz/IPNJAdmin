<?php

namespace App\Controller;

use App\Entity\EnviosAS;
use App\Entity\EnviosFN;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    
}
