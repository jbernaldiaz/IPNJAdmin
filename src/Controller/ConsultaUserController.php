<?php

namespace App\Controller;

use App\Entity\EnviosFN;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultaUserController extends AbstractController
{
    /**
     * @Route("/consulta_fnacional/user", name="consulta_fnacional_user")
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
     * @Route("/consulta_fnacional/super", name="consulta_fnacional_super")
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


    
}
