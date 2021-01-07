<?php

namespace App\Controller;

use App\Entity\EnviosFN;
use PDO;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class ExcelFNController extends AbstractController
{
   /**
     * @Route("/excel_fn/recibo{id}", name="excelFNRecibo")
     */
    public function excelFN($id): Response
    {  
        
        $repository = $this->getDoctrine()->getRepository(EnviosFN::class);
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
                        ->setCellValue('E4', $valor->getDDiezmo())
                        ->setCellValue('E5', $valor->getFSolidario())
                        ->setCellValue('E6', $valor->getCuotaSocio())
                        ->setCellValue('E7', $valor->getDiezmoPersonal())
                        ->setCellValue('E8', $valor->getMisionera())
                        ->setCellValue('E9', $valor->getRayos())
                        ->setCellValue('E10', $valor->getGavillas()) 
                        ->setCellValue('E11', $valor->getFmn())     
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
            ->setCellValue('B7', 'Fecha del Deposito')
            ->setCellValue('B8', 'Operacion')
            ->setCellValue('B9', 'Cajero')
            ->setCellValue('D4', 'Diezmo de Diezmo')
            ->setCellValue('D5', 'Fondo Solidario')
            ->setCellValue('D6', 'Cuota')
            ->setCellValue('D7', 'Diezmo Personal')
            ->setCellValue('D8', 'O. Misionera')
            ->setCellValue('D9', 'O. Rayos')
            ->setCellValue('D10', 'O. Gavillas')
            ->setCellValue('D11', 'FMN')
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
                $fileName = 'reciboTesoreriaNacional.xlsx';
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




//Reporte cruzado por ofrendas FONDO NACIONAL
    /**
     * @Route("/excel_fn/reporte/{ofrenda}/{anio}", name="excelFNReporte")
     */
    public function reportAction($ofrenda, $anio)
    {             
        
// COMIENZA LA CONSULTA

                $em = $this->getDoctrine()->getManager();
                $db = $em->getConnection();
            
            $concat = "GROUP_CONCAT(if(mes = 'Enero'," . $ofrenda . ", NULL)) as 'a',
                GROUP_CONCAT(if(mes = 'Febrero', " . $ofrenda . ", NULL)) as 'b', 
                GROUP_CONCAT(if(mes = 'Marzo'," . $ofrenda . ", NULL)) as 'c',
                GROUP_CONCAT(if(mes = 'Abril'," . $ofrenda . ", NULL)) as 'd',
                GROUP_CONCAT(if(mes = 'Mayo'," . $ofrenda . ", NULL)) as 'e',
                GROUP_CONCAT(if(mes = 'Junio'," . $ofrenda . ", NULL)) as 'f',
                GROUP_CONCAT(if(mes = 'Julio'," . $ofrenda . ", NULL)) as 'g',
                GROUP_CONCAT(if(mes = 'Agosto'," . $ofrenda . ", NULL)) as 'h',
                GROUP_CONCAT(if(mes = 'Septiembre'," . $ofrenda . ", NULL)) as 'i',
                GROUP_CONCAT(if(mes = 'Octubre'," . $ofrenda . ", NULL)) as 'j',
                GROUP_CONCAT(if(mes = 'Noviembre'," . $ofrenda . ", NULL)) as 'k',
                GROUP_CONCAT(if(mes = 'Diciembre'," . $ofrenda . ", NULL)) as 'l'";
            
                $query = "SELECT I.iglesia, " .$concat. "
                FROM envios_fn E 
                INNER JOIN user I ON I.id = E.user_id
                INNER JOIN zonas U ON U.id = I.zonas_id
                WHERE YEAR(anio) = " . $anio . " AND U.id = '1'
                GROUP BY user_id";
                $stmt = $db->prepare($query);
                $params = array();
                $stmt->execute($params);
            
            if($ofrenda === 'misionera'){
            
                $enviosMisioNorte = $stmt->fetchAll();
                $enviosNorte = $enviosMisioNorte;
                
            
            }
            
            if($ofrenda === 'gavillas'){
            
                $enviosGavillasNorte = $stmt->fetchAll();
                $enviosNorte = $enviosGavillasNorte;
                
            
            } 
            if($ofrenda === 'rayos'){
            
                $enviosRayosNorte = $stmt->fetchAll();
                    $enviosNorte = $enviosRayosNorte;
                    $ofrendas = 'Rayos';
            
            }     
            
            if($ofrenda === 'fmn'){
            
                $enviosFmnNorte = $stmt->fetchAll();
                    $enviosNorte = $enviosFmnNorte;
                
            }
            
            if($ofrenda === 'd_diezmo'){
            
                $enviosDiezmoNorte = $stmt->fetchAll();
                $enviosNorte = $enviosDiezmoNorte;
                
            
            }   
            
            $query = "SELECT I.iglesia, " .$concat. "
            FROM envios_fn E 
            INNER JOIN user I ON I.id = E.user_id
            INNER JOIN zonas U ON U.id = I.zonas_id
            WHERE YEAR(anio) = " . $anio . " AND U.id = '2'
            GROUP BY user_id";
                $stmtCentro = $db->prepare($query);
                $params = array();
                $stmtCentro->execute($params);
            
                if($ofrenda === 'misionera'){
            
                    $enviosMisioCentro = $stmtCentro->fetchAll();
                    $enviosCentro = $enviosMisioCentro;
                }
                if($ofrenda === 'gavillas'){
                
                    $enviosGavillasCentro = $stmtCentro->fetchAll();
                    $enviosCentro = $enviosGavillasCentro;
                } 
                if($ofrenda === 'rayos'){
                
                    $enviosRayosCentro = $stmtCentro->fetchAll();
                    $enviosCentro = $enviosRayosCentro;
                
                } 
                if($ofrenda === 'fmn'){
                
                    $enviosFmnCentro = $stmtCentro->fetchAll();
                        $enviosCentro = $enviosFmnCentro;
                
                }       
                if($ofrenda === 'd_diezmo'){
            
                    $enviosDiezmoCentro = $stmt->fetchAll();
                    $enviosCentro = $enviosDiezmoCentro;
                
                }
                  
                $query = "SELECT I.iglesia, " .$concat. "
                FROM envios_fn E 
                INNER JOIN user I ON I.id = E.user_id
                INNER JOIN zonas U ON U.id = I.zonas_id
                WHERE YEAR(anio) = " . $anio . " AND U.id = '3'
                GROUP BY user_id";
                $stmtSur = $db->prepare($query);
                $params = array();
                $stmtSur->execute($params);
            
            
                if($ofrenda === 'misionera'){
            
                    $enviosMisioSur = $stmtSur->fetchAll();
                    $enviosSur = $enviosMisioSur;
                    
                }
                if($ofrenda === 'gavillas'){
                
                    $enviosGavillasSur = $stmtSur->fetchAll();
                    $enviosSur = $enviosGavillasSur;
                    
                
                } 
                if($ofrenda === 'rayos'){
                
                    $enviosRayosSur = $stmtSur->fetchAll();
                    $enviosSur = $enviosRayosSur;
                } 
                if($ofrenda === 'fmn'){
                
                    $enviosFmnSur = $stmtSur->fetchAll();
                        $enviosSur = $enviosFmnSur;
            }    
            if($ofrenda === 'd_diezmo'){
            
                $enviosDiezmoSur = $stmt->fetchAll();
                $enviosSur = $enviosDiezmoSur;
            
            }
 //TERMINA LA CONSULTA    


//COMIENZA EL EXCEL


            $spreadsheet = new Spreadsheet();
                            
            /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
            $sheet = $spreadsheet->getActiveSheet();
            

        if($ofrenda === 'misionera')
        {
            $ofrendas = 'Misionera';
        }
        if($ofrenda === 'gavillas')
        {
            $ofrendas = 'Gavillas';
        } 
        if($ofrenda === 'rayos')
        {
            $ofrendas = 'Rayos';
        } 


        // escribimos en distintas celdas del documento el título de los campos que vamos a exportar
        $sheet->setCellValue('A1', 'IGLESIA')
            ->setCellValue('B1', 'Ene')
            ->setCellValue('C1', 'Feb')
            ->setCellValue('D1', 'Mar')
            ->setCellValue('E1', 'Abr')
            ->setCellValue('F1', 'May')
            ->setCellValue('G1', 'Jun')
            ->setCellValue('H1', 'Jul')
            ->setCellValue('I1', 'Ago')
            ->setCellValue('J1', 'Sep')
            ->setCellValue('K1', 'Oct')
            ->setCellValue('L1', 'Nov')
            ->setCellValue('M1', 'Dic')
            ->setCellValue('N1', 'Total')
         /*   ->setCellValue('A2', 'Ofrenda ' .$ofrendas. ' Zona Norte')            
            ->setCellValue('A6', 'Ofrenda ' .$ofrendas. ' Zona Norte')
            ->setCellValue('A18', 'Ofrenda ' .$ofrendas. ' Zona Norte')
            */
            ;
        
        
        $i = 3;
        $n = $i-1;
        $a = 3;
        $b = 3;
        $c = 3;
        $d = 3;
        $e = 3;
        $f = 3;
        $g = 3;
        $h = 3;
        $is = 3;
        $j = 3;
        $k = 3;
        $l = 3;
        $m = 3;

        
        $spreadsheet->getActiveSheet()->setCellValue('A2', 'Envios Zona Norte de Ofrenda');
        $spreadsheet->getActiveSheet()->setCellValue('H2', $ofrendas);

        $spreadsheet->getActiveSheet()->getStyle('A2')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $spreadsheet->getActiveSheet()->getStyle('A2')
            ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            
        $spreadsheet->getActiveSheet()->getStyle('H2')
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('H2')
        ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

      
        foreach ($enviosNorte as $valor) 
        {
            $totalNorte = $valor['a']+$valor['b']+$valor['c']+$valor['d']+$valor['e']+$valor['f']+$valor['g']+$valor['h']+$valor['i']+$valor['j']+$valor['k']+$valor['l'];

            
            //$spreadsheet->getActiveSheet()->insertNewRowBefore($i++, 1);
            $spreadsheet->getActiveSheet()->setCellValue('A'.$i++, $valor['iglesia']);
            $spreadsheet->getActiveSheet()->setCellValue('B'.$a++, $valor['a']);
            $spreadsheet->getActiveSheet()->setCellValue('C'.$b++, $valor['b']);
            $spreadsheet->getActiveSheet()->setCellValue('D'.$c++, $valor['c']);
            $spreadsheet->getActiveSheet()->setCellValue('E'.$d++, $valor['d']);
            $spreadsheet->getActiveSheet()->setCellValue('F'.$e++, $valor['e']);
            $spreadsheet->getActiveSheet()->setCellValue('G'.$f++, $valor['f']);
            $spreadsheet->getActiveSheet()->setCellValue('H'.$g++, $valor['g']);
            $spreadsheet->getActiveSheet()->setCellValue('I'.$h++, $valor['h']);
            $spreadsheet->getActiveSheet()->setCellValue('J'.$is++, $valor['i']);
            $spreadsheet->getActiveSheet()->setCellValue('K'.$j++, $valor['j']);
            $spreadsheet->getActiveSheet()->setCellValue('L'.$k++, $valor['k']);
            $spreadsheet->getActiveSheet()->setCellValue('M'.$l++, $valor['l']);
            $spreadsheet->getActiveSheet()->setCellValue('N'.$m++, $totalNorte);
            
        }

        
            
            $spreadsheet->getActiveSheet()->insertNewRowBefore($i++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($a++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($b++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($c++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($d++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($e++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($f++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($g++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($h++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($is++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($j++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($k++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($l++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($m++, 1);
    //columna B informacion
            $styleArray = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '848484'],
                    ],
                ],
                'font' => [
                    'name' => "Myriad Pro",
                    'size' => "12",
                    'color' => [
                        'argb' => "FFF2F2F2"
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => '16365C',
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '16365C'],
                    ],
                ],
            ];



//Fin Columna Info
           $spreadsheet->getActiveSheet()->setCellValue('A'.$i++, 'Envios Zona Centro');
           $spreadsheet->getActiveSheet()->getStyle('B'.$a++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('C'.$b++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('D'.$c++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('E'.$d++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('F'.$e++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('G'.$f++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('H'.$g++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('I'.$h++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('J'.$is++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('K'.$j++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('L'.$k++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('M'.$l++)->applyFromArray($styleArray);
           $spreadsheet->getActiveSheet()->getStyle('N'.$m++)->applyFromArray($styleArray);

        foreach ($enviosCentro as $valor) 
        {
            $totalCentro = $valor['a']+$valor['b']+$valor['c']+$valor['d']+$valor['e']+$valor['f']+$valor['g']+$valor['h']+$valor['i']+$valor['j']+$valor['k']+$valor['l'];
            
            
            $spreadsheet->getActiveSheet()->setCellValue('A'.$i++, $valor['iglesia']);
            $spreadsheet->getActiveSheet()->setCellValue('B'.$a++, $valor['a']);
            $spreadsheet->getActiveSheet()->setCellValue('C'.$b++, $valor['b']);
            $spreadsheet->getActiveSheet()->setCellValue('D'.$c++, $valor['c']);
            $spreadsheet->getActiveSheet()->setCellValue('E'.$d++, $valor['d']);
            $spreadsheet->getActiveSheet()->setCellValue('F'.$e++, $valor['e']);
            $spreadsheet->getActiveSheet()->setCellValue('G'.$f++, $valor['f']);
            $spreadsheet->getActiveSheet()->setCellValue('H'.$g++, $valor['g']);
            $spreadsheet->getActiveSheet()->setCellValue('I'.$h++, $valor['h']);
            $spreadsheet->getActiveSheet()->setCellValue('J'.$is++, $valor['i']);
            $spreadsheet->getActiveSheet()->setCellValue('K'.$j++, $valor['j']);
            $spreadsheet->getActiveSheet()->setCellValue('L'.$k++, $valor['k']);
            $spreadsheet->getActiveSheet()->setCellValue('M'.$l++, $valor['l']);
            $spreadsheet->getActiveSheet()->setCellValue('N'.$m++, $totalCentro);
            
            
        }

            $spreadsheet->getActiveSheet()->insertNewRowBefore($i++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($a++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($b++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($c++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($d++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($e++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($f++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($g++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($h++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($is++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($j++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($k++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($l++, 1);
            $spreadsheet->getActiveSheet()->insertNewRowBefore($m++, 1);

            $spreadsheet->getActiveSheet()->setCellValue('A'.$i++, 'Envios Zona Sur');
            $spreadsheet->getActiveSheet()->getStyle('B'.$a++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('C'.$b++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('D'.$c++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('E'.$d++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('F'.$e++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('G'.$f++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('H'.$g++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('I'.$h++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('J'.$is++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('K'.$j++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('L'.$k++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('M'.$l++, '')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('N'.$m++, '')->applyFromArray($styleArray);

        foreach ($enviosSur as $valor) 
        {
            $totalSur = $valor['a']+$valor['b']+$valor['c']+$valor['d']+$valor['e']+$valor['f']+$valor['g']+$valor['h']+$valor['i']+$valor['j']+$valor['k']+$valor['l'];

            $spreadsheet->getActiveSheet()->setCellValue('A'.$i++, $valor['iglesia']);
            $spreadsheet->getActiveSheet()->setCellValue('B'.$a++, $valor['a']);
            $spreadsheet->getActiveSheet()->setCellValue('C'.$b++, $valor['b']);
            $spreadsheet->getActiveSheet()->setCellValue('D'.$c++, $valor['c']);
            $spreadsheet->getActiveSheet()->setCellValue('E'.$d++, $valor['d']);
            $spreadsheet->getActiveSheet()->setCellValue('F'.$e++, $valor['e']);
            $spreadsheet->getActiveSheet()->setCellValue('G'.$f++, $valor['f']);
            $spreadsheet->getActiveSheet()->setCellValue('H'.$g++, $valor['g']);
            $spreadsheet->getActiveSheet()->setCellValue('I'.$h++, $valor['h']);
            $spreadsheet->getActiveSheet()->setCellValue('J'.$is++, $valor['i']);
            $spreadsheet->getActiveSheet()->setCellValue('K'.$j++, $valor['j']);
            $spreadsheet->getActiveSheet()->setCellValue('L'.$k++, $valor['k']);
            $spreadsheet->getActiveSheet()->setCellValue('M'.$l++, $valor['l']);
            $spreadsheet->getActiveSheet()->setCellValue('N'.$m++, $totalSur);
            
        }

        $styleArrays = [
            'borders' => [
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => 'FFFFFF'],
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '16365C'],
                ],
            ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A'.$i, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('B'.$a, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('C'.$b, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('D'.$c, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('E'.$d, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('F'.$e, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('G'.$f, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('H'.$g, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('I'.$h, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('J'.$is, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('K'.$j, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('L'.$k, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('M'.$l, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->getStyle('N'.$m, '')->applyFromArray($styleArrays);
        $spreadsheet->getActiveSheet()->mergeCells('A2:G2');               
        $spreadsheet->getActiveSheet()->mergeCells('H2:N2');



            $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('7')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('8')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('9')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('10')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('11')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('12')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('13')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('14')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('15')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('16')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('17')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('18')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('19')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('20')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('21')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('22')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('23')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('24')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('25')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('26')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('27')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('28')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('29')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('30')->setRowHeight(20);
            $spreadsheet->getActiveSheet()->getRowDimension('31')->setRowHeight(20);


            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(20);            
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);         
            $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
                     
//FIN DEL EXCEL


//ESTILOS DE LA TABLA
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
                    'name' => "Myriad Pro",
                    'size' => "12",
                    'color' => [
                        'argb' => "FFF2F2F2"
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];

            $spreadsheet->getActiveSheet()->getStyle('A1:N1')->applyFromArray($styleArray);



// Columna Datos VALORES
$styleValores = [
    'numberFormat' => [
        'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE
    ],
    'font' => [
        'name' => "Calibri",
        'size' => "12",
        'color' => [
            'argb' => "3D3D3D"
        ],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
];

$spreadsheet->getActiveSheet()->getStyle('B3:N30')->applyFromArray($styleValores);
//FIN DATOS VALORES

//fin ESTILOS DE LA TABLA


        $sheet->setTitle("RECIBO DE T. NACIONAL");
                
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        
        // Create a Temporary file in the system
        $fileName = 'REPORTE ANUAL TESORERIA NACIONAL.xlsx';
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

//TERMINA EL EXCEL
 //Fin reporte Fondo Nacional




}
