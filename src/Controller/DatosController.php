<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DatosController
{
	/**
     * @Route("/datos")
     */
    public function homepage()
    {
        return new Response('Probando la sincronizacion de git!');
    }
}
