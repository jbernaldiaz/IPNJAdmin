<?php
namespace App\Controller;

use App\Entity\EnviosFN;
use App\Form\CalculadorDiezmosType;
use App\Form\CalculadorDiezmoType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Options;

class DatosController extends AbstractController
{

/**
     * @Route("/pdf{id}", name="pdf")
     */
   public function pdfAction($id)
    {

        $repository = $this->getDoctrine()->getRepository(EnviosFN::class);
        $envio = $repository->find($id);
        
         // Configure Dompdf according to your needs
         //$pdfOptions = new Options();
         //$pdfOptions->set('defaultFont', 'Arial');
         
         // Instantiate Dompdf with our options
         $dompdf = new Dompdf();
         // Retrieve the HTML generated in our twig file
         $html = $this->renderView('pdf/pdf.html.twig', array('envio' => $envio)); 

         // Load HTML to Dompdf
         $dompdf->loadHtml($html);
         
         // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
         $dompdf->setPaper('A4', 'portrait');
 
         // Render the HTML as PDF
         $dompdf->render();
 
         // Output the generated PDF to Browser (inline view)
         $dompdf->stream("mypdf.pdf", [
             "Attachment" => false
         ]);
        
/* 
    //Esta opcion descarga el archivo de inmediato
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
       $html = $this->renderView('pdf/pdf.html.twig', array('envio' => $envio)); 

        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    */

    }
    
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
