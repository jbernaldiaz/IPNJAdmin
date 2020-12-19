<?php

namespace App\Controller;

use App\Entity\EnviosFN;
use App\Form\EnviosEditType;
use App\Form\EnviosFNEditType;
use App\Form\EnviosFNType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnviosFNController extends AbstractController
{
    /**
     * @Route("/envios/index", name="indexEnvios")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(EnviosFN::class);
        $envio = $repository->findAll();

        return $this->render('envios_fn/index.html.twig', [
            'envio' => $envio
            ]);

    }

    
    /**
     * @Route("/envios/add", name="addEnvios")
     */
    public function addAction()
    {
        $envios = new EnviosFN();
        $form = $this->createCreateForm($envios);
        
        return $this->render('envios_fn/add.html.twig', array('form' => $form->createView()));
    }
    
    private function createCreateForm(EnviosFN $entity)
    {
        $form = $this->createForm(EnviosFNType::class, $entity, array(
            'action' => $this->generateUrl('createEnvios'),
            'method' => 'POST'
        ));
        
        return $form;
    }
    

    /**
     * @Route("/envios/create", name="createEnvios")
     */
    public function createAction(Request $request)
    {
        $envios = new EnviosFN();
        $form = $this->createCreateForm($envios);
        $form->handleRequest($request);
        
       if ($form->isSubmitted() && $form->isValid())
        {
            $user = $this->getUser();
            $envios->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($envios);
            $em->flush();
            $this->addFlash('exito', EnviosFN::REGISTRO_EXITOSO);
            
           return $this->redirectToRoute('addEnvios');
        }
        
        return $this->render('envios_fn/add.html.twig', ['form' => $form->createView()]);
    }




    /**
     * @Route("/envios/view{id}", name="viewEnvio")
     */
    public function viewAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(EnviosFN::class);
            $envio = $repository->find($id);

            return $this->render('envios_fn/view.html.twig', [
                'envio' => $envio
                ]);
        
       }




       /**
     * @Route("/envios/edit{id}", name="editEnvio")
     */
       public function editAction($id)
       {
           $em = $this->getDoctrine()->getManager();
           $envio = $em->getRepository(EnviosFN::class)->find($id);
           
           
           $form = $this->createEditForm($envio);
           
           return $this->render('envios_fn/edit.html.twig', array('envio' => $envio, 'form' => $form->createView()));
           
       }
        
       private function createEditForm(EnviosFN $entity)
       {
        $form = $this->createForm(EnviosFNEditType::class, $entity, array(
            'action' => $this->generateUrl('updateEnvios', array('id' => $entity->getId())), 
            'method' => 'PUT'));
        
        return $form;
       }
       
   
   
     /**
     * @Route("/envios/update{id}", name="updateEnvios")
     */
       public function updateAction($id, Request $request)
       {
           
           $em = $this->getDoctrine()->getManager();
           $envio = $em->getRepository(EnviosFN::class)->find($id);
           $form = $this->createEditForm($envio);
           $form->handleRequest($request);
           
             
   
           if($form->isSubmitted() && $form->isValid())
           {   
               $user = $this->getUser();
               $envio->setUser($user);
               $em->persist($envio);
               $em->flush();
               
               
               $this->addFlash('editarEnvio', 'El envio numero ' .$id. ' ha sido modificado con éxito');
   
               return $this->redirectToRoute('indexEnvios');
           }
   
           return $this->render('envios_fn/edit.html.twig', array('envio' => $envio, 'form' => $form->createView()));
       }
   
   

}
