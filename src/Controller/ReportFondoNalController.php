<?php

namespace App\Controller;

use App\Entity\EnviosFN;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ReportFondoNalController extends AbstractController
{
    /**
     * @Route("/excel", name="excel")
     */
    public function indexExcel()
    {  
        
        $repository = $this->getDoctrine()->getRepository(EnviosFN::class);
        $envio = $repository->findById(53);


                $spreadsheet = new Spreadsheet();
                
                /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
                $sheet = $spreadsheet->getActiveSheet();


                foreach ($envio as $valor) {
                    $spreadsheet->getActiveSheet()
                        ->setCellValue('C3', $valor->getUser())
                        ->setCellValue('C4', $valor->getAnio()->format('Y'))
                        ->setCellValue('C5', $valor->getMes())
                        ->setCellValue('C6', $valor->getFecha()->format("Y-m-d"))
                        ->setCellValue('C7', $valor->getOperacion())
                        ->setCellValue('C8', $valor->getCajero())
                        ->setCellValue('E3', $valor->getDDiezmo())
                        ->setCellValue('E4', $valor->getFSolidario())
                        ->setCellValue('E5', $valor->getCuotaSocio())
                        ->setCellValue('E6', $valor->getDiezmoPersonal())
                        ->setCellValue('E7', $valor->getMisionera())
                        ->setCellValue('E8', $valor->getRayos())
                        ->setCellValue('E9', $valor->getGavillas()) 
                        ->setCellValue('E10', $valor->getFmn())     
                        ->setCellValue('E11', $valor->getTotal())          
                        ;
        
                    
                }


      $sheet->setCellValue('B2', 'Informacion de la transacción')
            ->setCellValue('D2', 'Detalles del Envio')
            ->setCellValue('B3', 'Iglesia')
            ->setCellValue('B4', 'Año')
            ->setCellValue('B5', 'Mes')
            ->setCellValue('B6', 'Fecha')
            ->setCellValue('B7', 'Operacion')
            ->setCellValue('B8', 'Cajero')
            ->setCellValue('D3', 'Diezmo de Diezmo')
            ->setCellValue('D4', 'Fondo Solidario')
            ->setCellValue('D5', 'Cuota')
            ->setCellValue('D6', 'Diezmo Personal')
            ->setCellValue('D7', 'O. Misionera')
            ->setCellValue('D8', 'O. Rayos')
            ->setCellValue('D9', 'O. Gavillas')
            ->setCellValue('D10', 'FMN')
            ->setCellValue('D11', 'Total');

        
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);    
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);

            $spreadsheet->getActiveSheet()->mergeCells('B2:C2');
            $spreadsheet->getActiveSheet()->mergeCells('D2:E2');

            $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(14);

            $spreadsheet->getActiveSheet()->getStyle('C3:C8')
    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['argb' => 'FFFF0000'],
                    ],
                ],
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            
            $spreadsheet->getActiveSheet()->getStyle('B2:E2')->applyFromArray($styleArray);

                $sheet->setTitle("My First Worksheet");
                
                // Create your Office 2007 Excel (XLSX Format)
                $writer = new Xlsx($spreadsheet);
                
                // Create a Temporary file in the system
                $fileName = 'my_first_excel_symfony4.xlsx';
                $temp_file = tempnam(sys_get_temp_dir(), $fileName);
                
                // Create the excel file in the tmp directory of the system
                $writer->save($temp_file);
                
                // Return the excel file as an attachment
                return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
            }
        

}
