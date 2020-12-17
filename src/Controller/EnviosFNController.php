<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnviosFNController extends AbstractController
{
    /**
     * @Route("/envios/f/n", name="envios_f_n")
     */
    public function index(): Response
    {
        return $this->render('envios_fn/index.html.twig', [
            'controller_name' => 'EnviosFNController',
        ]);
    }
}
