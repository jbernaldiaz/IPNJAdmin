<?php

namespace App\Controller;

use App\Entity\Bautismos;
use App\Form\BautismosType;
use App\Repository\BautismosRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BautismosController extends AbstractController
{
    /**
     * @Route("/bautismos", name="bautismos")
     */
    public function indexBautismos(Request $request,BautismosRepository $bautismosRepository, PaginatorInterface $paginator): Response
    {

        $query = $bautismosRepository->TodosLosBautismos();
                
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
     * @Route("/bautismos/add", name="bautismosAdd")
     */
    public function bautismosAdd(Request $request): Response
    {
        $bautismo = new Bautismos();
        $form = $this->createForm(BautismosType::class, $bautismo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $this->getUser();
            $bautismo->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($bautismo);
            $em->flush();
            
            return $this->redirectToRoute('bautismos');

        }

        return $this->render('bautismos/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
