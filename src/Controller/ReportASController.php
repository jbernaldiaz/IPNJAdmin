<?php

namespace App\Controller;

use App\Entity\EnviosAS;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class ReportASController extends AbstractController
{
    
   /**
     * @Route("/excel_as/recibo{id}", name="excelASRecibo")
     */
    public function excelAS($id): Response
    {  
        
        $repository = $this->getDoctrine()->getRepository(EnviosAS::class);
        $envio = $repository->findById($id);


                $spreadsheet = new Spreadsheet();
                
                /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
                $sheet = $spreadsheet->getActiveSheet();
                

                foreach ($envio as $valor) {
                    $spreadsheet->getActiveSheet()
                        ->setCellValue('C4', $valor->getUser())
                        ->setCellValue('C5', $valor->getAnio()->format('Y'))
                        ->setCellValue('C6', $valor->getMes())
                        ->setCellValue('C7', $valor->getFecha()->format("Y-m-d"))
                        ->setCellValue('C8', $valor->getOperacion())
                        ->setCellValue('C9', $valor->getCajero())
                        ->setCellValue('E4', $valor->getAporteA())
                        ->setCellValue('E5', $valor->getAporteB())     
                        ->setCellValue('E12', $valor->getTotal())          
                        ;
        
                    
                }

      $sheet->setCellValue('B1', 'IGLESIA PENTECOSTAL DEL NOMBRE DE JESUCRISTO')
            ->setCellValue('B3', 'Recibo No:')
            ->setCellValue('B2', 'Informacion de la transacción')
            ->setCellValue('D2', 'Detalles del Envio')
            ->setCellValue('B4', 'Iglesia')
            ->setCellValue('B5', 'Año')
            ->setCellValue('B6', 'Mes')
            ->setCellValue('B7', 'Fecha del deposito')
            ->setCellValue('B8', 'Operacion')
            ->setCellValue('B9', 'Cajero')
            ->setCellValue('D4', 'Aporte Voluntario 1')
            ->setCellValue('D5', 'Aporte Voluntario 2')
            ->setCellValue('D12', 'Total')
            ->setCellValue('B12', 'FIRMA')
            ->setCellValue('E3', $id);



            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
            $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
            $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getRowDimension('7')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getRowDimension('8')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getRowDimension('9')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getRowDimension('10')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getRowDimension('11')->setRowHeight(25);
            $spreadsheet->getActiveSheet()->getRowDimension('12')->setRowHeight(25);
        
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(24);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);    
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);

            $spreadsheet->getActiveSheet()->mergeCells('B1:E1');
            $spreadsheet->getActiveSheet()->mergeCells('B3:D3');
            $spreadsheet->getActiveSheet()->mergeCells('B2:C2');
            $spreadsheet->getActiveSheet()->mergeCells('D2:E2');
            $spreadsheet->getActiveSheet()->mergeCells('B10:C11');
            $spreadsheet->getActiveSheet()->mergeCells('B12:C12');
            $spreadsheet->getActiveSheet()->mergeCells('D6:D11');
            $spreadsheet->getActiveSheet()->mergeCells('E6:E11');

            $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(14);

              $spreadsheet->getActiveSheet()->getStyle('C3:C8')
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $spreadsheet->getActiveSheet()->getStyle('B12')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('B12')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
              
            
//Nombre de la iglesia

            $styleIglesia = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '848484'],
                    ],
                ],
                'font' => [
                    'bold' => true,
                    'name' => "Myriad Pro",
                    'size' => "22",
                    'color' => [
                        'argb' => "005095"
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];
            
            $spreadsheet->getActiveSheet()->getStyle('B1:E1')->applyFromArray($styleIglesia);
//Fin Nombre de la iglesia            
//encabezado de la Tabla
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '848484'],
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => '16365C',
                    ],
                ],
                'font' => [
                    'bold' => true,
                    'name' => "Myriad Pro",
                    'size' => "18",
                    'color' => [
                        'argb' => "FFF2F2F2"
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];
            
            $spreadsheet->getActiveSheet()->getStyle('B2:E2')->applyFromArray($styleArray);
//fin encabezao de la tabla

//columna B informacion
            $styleColInfo = [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'F2F2F2',
                    ],
                ],
                'font' => [
                    'bold' => true,
                    'name' => "Myriad Pro",
                    'size' => "16",
                    'color' => [
                        'argb' => "3F3F3F"
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                
            ];
            
            $spreadsheet->getActiveSheet()->getStyle('B4:B9')->applyFromArray($styleColInfo);
            $spreadsheet->getActiveSheet()->getStyle('D3:D11')->applyFromArray($styleColInfo);
//Fin Columna Info

//Columna Datos estilo 

    $styleColDatos = [
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FFFFFF',
            ],
        ],
        'font' => [
            'bold' => false,
            'name' => "Myriad Pro",
            'size' => "16",
            'color' => [
                'argb' => "3F3F3F"
            ],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        
    ];

    $spreadsheet->getActiveSheet()->getStyle('C3:C9')->applyFromArray($styleColDatos);
    $spreadsheet->getActiveSheet()->getStyle('B3:E3')->applyFromArray($styleColDatos);


//Fin Columna Datos
// Columna Datos VALORES
 
    $styleColValores = [
            
        'numberFormat' => [
            'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE
        ],
        
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FFFFFF',
            ],
        ],
        'font' => [
            'bold' => false,
            'name' => "Myriad Pro",
            'size' => "16",
            'color' => [
                'argb' => "3F3F3F"
            ],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        
    ];
    $spreadsheet->getActiveSheet()->getStyle('E4:E11')->applyFromArray($styleColValores);
//FIN DATOS VALORES
// Start TOTAL
        $styleTotal = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '848484'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '1B788E',
                ],
            ],
            'font' => [
                'bold' => true,
                'name' => "Myriad Pro",
                'size' => "16",
                'color' => [
                    'argb' => "FFFFFF"
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('D12')->applyFromArray($styleTotal);
        $styleTotalValor = [
            'numberFormat' => [
                'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '848484'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '1B788E',
                ],
            ],
            'font' => [
                'bold' => true,
                'name' => "Myriad Pro",
                'size' => "16",
                'color' => [
                    'argb' => "FFFFFF"
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('E12')->applyFromArray($styleTotalValor);
//End TOTAL


            $spreadsheet->getActiveSheet()->getStyle('B3:E12')->getBorders()
            ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);



                $sheet->setTitle("RECIBO DE T. NACIONAL");
                
                // Create your Office 2007 Excel (XLSX Format)
                $writer = new Xlsx($spreadsheet);
                
                // Create a Temporary file in the system
                $fileName = 'reciboAsistenciaSocial.xlsx';
                $temp_file = tempnam(sys_get_temp_dir(), $fileName);
                
                // Create the excel file in the tmp directory of the system
                $writer->save($temp_file);

/*
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load('template.xlsx'); 
                dump($spreadsheet->getActiveSheet());
                exit;
*/

                // Return the excel file as an attachment
                return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
            }
}
