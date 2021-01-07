<?php

namespace App\Controller;

use App\Entity\EnviosAS;
use App\Form\EnviosASType;
use App\Repository\EnviosASRepository;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EnviosASController extends AbstractController 
{
    /**
     * @Route("/envios_as/index", name="indexEnviosAS")
     */
    public function indexAS(Request $request,EnviosASRepository $enviosASRepository, PaginatorInterface $paginator)
    {
        //$em = $this->getDoctrine()->getManager();
        //$query = $em->getRepository(EnviosAS::class)->TodosLosEnvios();
        $query = $enviosASRepository->TodosLosEnvios();
                
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

            return $this->render('envios_as/index.html.twig', [
                'pagination' => $pagination
                ]);

    }

    /**
     * @Route("/envios_as/add", name="addEnviosAS")
     */
    public function addASAction()
    {
        $envios = new EnviosAS();
        $form = $this->createCreateForm($envios);
        
        return $this->render('envios_as/add.html.twig', array('form' => $form->createView()));
    }
    
    private function createCreateForm(EnviosAS $entity)
    {
        $form = $this->createForm(EnviosASType::class, $entity, array(
            'action' => $this->generateUrl('createEnviosAS'),
            'method' => 'POST'
        ));
        
        return $form;
    }
    

    /**
     * @Route("/envios_as/create", name="createEnviosAS")
     */
    public function createAsistenciaAction(Request $request)
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

        $envios = new EnviosAS();
        $form = $this->createCreateForm($envios);
        $form->handleRequest($request);
        

       if ($form->isSubmitted() && $form->isValid())
        {
            $user = $this->getUser();
            $envios->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($envios);
            
            $em->flush();
            $this->addFlash('exito', EnviosAS::REGISTRO_EXITOSO);
            
           return $this->redirectToRoute('consultaAS_user');
        }
        
        return $this->render('envios_as/add.html.twig', ['form' => $form->createView()]);
    }



    /**
     * @Route("/envios_as/view{id}", name="viewEnvioAS")
     */
    public function viewAsistenciaAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(EnviosAS::class);
            $envio = $repository->find($id);

            return $this->render('envios_as/view.html.twig', [
                'envio' => $envio
                ]);
        
       }

    
    /**
     * @Route("/envios_as/edit{id}", name="editEnvioAS")
     */
    public function editAsistenciaAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $envio = $em->getRepository(EnviosAS::class)->find($id);
        
        
        $form = $this->createEditForm($envio);
        
        return $this->render('envios_as/edit.html.twig', array('envio' => $envio, 'form' => $form->createView()));
        
    }
     
    private function createEditForm(EnviosAS $entity)
    {
     $form = $this->createForm(EnviosASType::class, $entity, array(
         'action' => $this->generateUrl('updateEnviosAS', array('id' => $entity->getId())), 
         'method' => 'PUT'));
     
     return $form;
    }
    


  /**
  * @Route("/envios_as/update{id}", name="updateEnviosAS")
  */
    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $envio = $em->getRepository(EnviosAS::class)->find($id);
        $form = $this->createEditForm($envio);
        $form->handleRequest($request);          

        if($form->isSubmitted() && $form->isValid())
        {   
            $em->persist($envio);
            $em->flush();
            
            $this->addFlash('editarEnvio', 'El envio numero ' .$id. ' ha sido modificado con éxito');

            return $this->redirectToRoute('indexEnviosAS');
        }

        return $this->render('envios_as/edit.html.twig', array('envio' => $envio, 'form' => $form->createView()));
    }

    


}
