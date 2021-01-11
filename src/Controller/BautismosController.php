<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BautismosController extends AbstractController
{
    /**
     * @Route("/bautismos", name="bautismos")
     */
    public function index(): Response
    {
        return $this->render('bautismos/index.html.twig', [
            'controller_name' => 'BautismosController',
        ]);
    }
}
