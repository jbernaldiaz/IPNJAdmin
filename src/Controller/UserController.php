<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserController extends AbstractController
{
    /**
     * @Route("/user/index", name="indexUser")
     */
    public function index(): Response
    {

                $em = $this->getDoctrine()->getManager();
                $norte = $em->getRepository(User::class)->findByZonas(1);
                $centro = $em->getRepository(User::class)->findByZonas(2);
                $sur = $em->getRepository(User::class)->findByZonas(3);
    
                
            return $this->render('user/index.html.twig', array('norte' => $norte, 'centro' => $centro, 'sur' => $sur ));
    }


    /**
     * @Route("/user/add", name="addUser")
     */
    public function addAction()
    {
        $user = new User();
        $form = $this->createCreateForm($user);
        
        return $this->render('user/add.html.twig', array('form' => $form->createView()));
    }
    
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(UserType::class, $entity, array(
            'action' => $this->generateUrl('createUser'),
            'method' => 'POST'
        ));
        
        return $form;
    }
    

    /**
     * @Route("/user/create", name="createUser")
     */
    public function createAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);
        
       if ($form->isSubmitted() && $form->isValid())
        {
            
            $em = $this->getDoctrine()->getManager();
            $user->setPassword($passwordEncoder->encodePassword($user, $form['password']->getData()));
            $em->persist($user);
            $em->flush();
            $this->addFlash('exito', User::REGISTRO_EXITOSO);
           
           return $this->redirectToRoute('indexUser');
        }
        
        return $this->render('user/add.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/user/view{id}", name="viewUser")
     */
    public function viewAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->find($id);

            return $this->render('user/view.html.twig', [
                'user' => $user
                ]);
        
       }



}
