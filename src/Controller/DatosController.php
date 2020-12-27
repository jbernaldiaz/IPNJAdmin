<?php
namespace App\Controller;

use App\Form\CalculadorDiezmosType;
use App\Form\CalculadorDiezmoType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DatosController extends AbstractController
{

    
	/**
     * @Route("/calculador_diezmo", name="calDiezmos")
     */
   public function calculatorAction(Request $request)
    {
        
        $form = $this->createForm(CalculadorDiezmoType::class);
        $form->handleRequest($request);
 
    if ($form->isSubmitted() && $form->isValid()) { 


$diezmo = $form->get("diezmo")->getData();
$local = $form->get("local")->getData();
$cuota = $form->get("cuota")->getData();

 $a= "10";
 $b="100";
 $d= "5";
   

 $dDiezmo = intval($diezmo * $a / $b);
 $c = ($diezmo - $dDiezmo);
 $aporteA = intval($c * $d / $b);
 $e = ($c - $aporteA);
 $solidario = intval($e * $a / $b);
 $f = ($e - $solidario);
 $fLocal= intval($f * $local / $b);
 $g = ($f - $fLocal);
 

$totalNacional = ($dDiezmo + $solidario + $cuota);
$h = ($totalNacional + $aporteA);
$totalPastor = ($diezmo - $h);


return $this->render('dashboard/result.html.twig', array('cuota' => $cuota, 'diezmo' => $diezmo, 'dDiezmo' => $dDiezmo, 'aporteA' => $aporteA, 'solidario' => $solidario, 'fLocal' => $fLocal, 'totalPastor' => $totalPastor, 'totalNacional' => $totalNacional));


    }
    return $this->render('dashboard/calculadorDiezmo.html.twig', array('form' => $form->createView()));
}

}
