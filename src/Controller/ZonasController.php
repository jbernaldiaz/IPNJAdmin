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
     * @Route("/zonas/index", name="index")
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
     * @Route("/zonas/add", name="add")
     */
    public function addAction()
    {
        $zona = new Zonas();
        $form = $this->createCreateForm($zona);
        
        return $this->render('zonas/add.html.twig', array('form' => $form->createView()));
    }
    
    private function createCreateForm(Zonas $entity)
    {
        $form = $this->createForm(ZonasType::class, $entity, array(
            'action' => $this->generateUrl('create'),
            'method' => 'POST'
        ));
        
        return $form;
    }
    

    /**
     * @Route("/zonas/create", name="create")
     */
    public function createAction(Request $request)
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
            /*$successMessage = $this->get('translator')->trans('The iglesia has been created.');
            $this->addFlash('mensaje', $successMessage);            */
            
           return $this->redirectToRoute('index');
        }
        
        return $this->render('zonas/add.html.twig', ['form' => $form->createView()]);
    }




}
