<?php

namespace App\Controller;

use App\Entity\Bautismos;
use App\Form\BautismosType;
use App\Repository\BautismosRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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

            return $this->render('bautismos/index.html.twig', [
                'pagination' => $pagination
                ]);

    }


    /**
     * @Route("/bautismos/add", name="bautismosAdd")
     */
    public function bautismosAdd(Request $request, SluggerInterface $slugger): Response
    {
        $bautismo = new Bautismos();
        $form = $this->createForm(BautismosType::class, $bautismo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $brochureFile = $form->get('fotos')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception("Ha ocurrido un error, disculpe");
                    
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $bautismo->setFotos($newFilename);

     }
 
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
