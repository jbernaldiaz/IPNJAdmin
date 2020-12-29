<?php

namespace App\Controller;

use App\Entity\Zonas;
use App\Form\ZonasType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ZonasController extends AbstractController
{
    /**
     * @Route("/zonas/index", name="indexZona")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $zona = $em->getRepository(Zonas::class)->findAll();
        
        return $this->render('zonas/index.html.twig', [
            'zona' => $zona
            ]);

    }


    /**
     * @Route("/zonas/add", name="addZona")
     */
    public function addZonaAction()
    {
        $zona = new Zonas();
        $form = $this->createCreateForm($zona);
        
        return $this->render('zonas/add.html.twig', array('form' => $form->createView()));
    }
    
    private function createCreateForm(Zonas $entity)
    {
        $form = $this->createForm(ZonasType::class, $entity, array(
            'action' => $this->generateUrl('createZona'),
            'method' => 'POST'
        ));
        
        return $form;
    }
    

    /**
     * @Route("/zonas/create", name="createZona")
     */
    public function createZonaAction(Request $request)
    {
        $zona = new Zonas();
        $form = $this->createCreateForm($zona);
        $form->handleRequest($request);
        
       if ($form->isSubmitted() && $form->isValid())
        {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($zona);
            $em->flush();
            $this->addFlash('exito', Zonas::REGISTRO_EXITOSO);
            
           return $this->redirectToRoute('indexZona');
        }
        
        return $this->render('zonas/add.html.twig', ['form' => $form->createView()]);
    }




}
