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
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;

class EnviosFNController extends AbstractController
{
    /**
     * @Route("/envios_fn/index", name="indexEnvios")
     */
    public function indexFN(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(EnviosFN::class)->TodosLosEnviosFN();
            $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

            return $this->render('envios_fn/index.html.twig', [
                'pagination' => $pagination
                ]);

    }

    
    /**
     * @Route("/envios_fn/add", name="addEnvios")
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
     * @Route("/envios_fn/create", name="createEnvios")
     */
    public function createAction(Request $request)
    {

        $captcha = [
            'g-recaptcha-response' => $request->request->get('g-recaptcha-response'),
        
        ];

     
        //La respuesta del recaptcha
        $tokenGoogle = $captcha['g-recaptcha-response'] ;
        //La ip del usuario
        $ipuser=$_SERVER['REMOTE_ADDR'];
        //Tu clave secretra de recaptcha
        $clavesecreta='6LdlGxMaAAAAAIiK6o4BCLvyNzdusjs0EMtA_wjB';
        //La url preparada para enviar
        $urlrecaptcha="https://www.google.com/recaptcha/api/siteverify?secret=$clavesecreta&response=$tokenGoogle&remoteip=$ipuser";
        
       
        
        //Leemos la respuesta (suele funcionar solo en remoto)
        $respuesta = file_get_contents($urlrecaptcha) ;
        
        //Comprobamos el success
        $dividir=explode('"success":',$respuesta);
        $obtener=explode(',',$dividir[1]);
        
        //Obtenemos el estado
        $estado=trim($obtener[0]);
        
        
        if ($estado=='true'){
          //Si es ok
          echo '-> Ok';
        } else if ($estado=='false'){
          //Si es error
          echo '-> Error';
        }

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
            
            $repository = $this->getDoctrine()->getRepository(EnviosFN::class);
            
            $envios = $repository->find($envios);
            $id = $repository->findById($envios);
              
          return $this->render('envios_fn/view.html.twig', array('id' => $id, 'envio' => $envios));
                 
   
        }else{
  
          return $this->render('envios_fn/add.html.twig', array('form' => $form->createView()));
         }
        
    }




    /**
     * @Route("/envios_fn/view{id}", name="viewEnvio")
     */
    public function viewEnviosAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(EnviosFN::class);
        $envio = $repository->find($id);

            return $this->render('envios_fn/view.html.twig', [
                'envio' => $envio
                ]);
        
       }




    /**
     * @Route("/envios_fn/edit{id}", name="editEnvio")
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
     * @Route("/envios_fn/update{id}", name="updateEnvios")
     */
       public function updateAction($id, Request $request)
       {
           
           $em = $this->getDoctrine()->getManager();
           $envio = $em->getRepository(EnviosFN::class)->find($id);
           $form = $this->createEditForm($envio);
           $form->handleRequest($request);
           
             
   
           if($form->isSubmitted() && $form->isValid())
           {   
               
               $em->persist($envio);
               $em->flush();
               
               
               $this->addFlash('editarEnvio', 'El envio numero ' .$id. ' ha sido modificado con éxito');
   
               return $this->redirectToRoute('indexEnvios');
           }
   
           return $this->render('envios_fn/edit.html.twig', array('envio' => $envio, 'form' => $form->createView()));
       }
   
   
    
}
