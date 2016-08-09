<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OEModule\OphCoCvi\controllers;
use \OEModule\OphCoCvi\components\CertFromOdtTemplate;


class PrintTestController extends \BaseController
{
    public $inputFile = 'example_certificate_4.odt';
    public $xmlDoc;
    public $xpath;
    public $printTestXml;
    public $xml;
    
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'       => array('test', 'getPDF'),
                'roles'         => array('admin')
            ),
        );
    }
    
    public function actionTest()
    {
        $pdfLink = '';
        if(isset($_POST['test_print'])){
            $this->printTestXml = new CertFromOdtTemplate( $this->inputFile , realpath(__DIR__ . '/..').'/files');
        
            $this->printTestXml->strReplace( $_POST );
            $this->printTestXml->imgReplace( 'image1.png' , $this->printTestXml->templateDir.'/signature3.png');
            
            $this->generateTestTable( 'myTable' );
            $this->printTestXml->fillTable("Table30" , $this->whoIs() );
            $this->printTestXml->fillTable("Table45" , $this->iConsider() );
            $this->printTestXml->fillTable("Table102" , $this->copiesInConfidenceTo() );
            $this->printTestXml->fillTable("Table348" , $this->genTableDatas() , 1 );
            $this->printTestXml->fillTable("Table690" , $this->yesNoQuestions() , 1 );
            
            $this->printTestXml->saveContentXML( $this->printTestXml->contentXml );
           
            $this->printTestXml->convertToPdf();
            $pdfLink = $this->pdfLink();
        }
       
        $this->render("test", array( 'pdfLink' => $pdfLink, 'imageSrc' => $this->getImage()) );
    }
    public function getImage()
    {
        if($this->printTestXml != NULL){
            $data = file_get_contents($this->printTestXml->templateDir.'/signature3.png');
            return '<div style="width:30%;max-height:30%;position:relative;"/><img src="data:image/jpeg;base64,'.base64_encode($data).'"/></div>';
        }
    }
   
    public function actionGetPDF()
    {
        $file = '/var/www/openeyes/protected/runtime/document.pdf';
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="document.pdf"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));
        @readfile($file);
    }
    
    public function whoIs()
    {
        $data = array(
            array('X', 'I am the patient'),
            array('','the patient’s representative and my name is (PLEASE PRINT):'),
        );
        return $data;
    }
    
    public function copiesInConfidenceTo(){
        $data = array(
            array('X', 'Local council / Care trust'),
            array('','Patient'),
            array('','Patinet’s GP'),
            array('','Hospital notes'),
            array('','Epidemiological analysis'),
        );
        return $data;
    }
    public function iConsider(){
        $data = array(
            array('I consider (tick one)', 'X', 'That this person is sight impaired (partially sighted)'),
            array('','', 'That this person is severly sight impaired (blind' ),
        );
        return $data;
    }
    public function yesNoQuestions()
    {
        $data = array(
            array('Does the patient live alone', 'Y'),
            array('Does the patient also have a hearing impairment','Y'),
            array('Does the patient have poor physical mobility?','Y'),
           
        );
        return $data;
    }
    public function genTableDatas()
    {
        $data = array(
            array('Retina', 'age-related macular degeneration –subretinal neovascularisation','H35.3'),
            array('','age-related macular degeneration – atrophic /geographic macular atrophy','H35.3','', ''),
            array('','diabetic retinopathy','E10.3 – E14.3 H36.0','', ''),
            array('','hereditary retinal dystrophy','H35.5','', ''),
            array('','retinal vascular occlusions','','', ''),
            array('','other retinal : please specify','','', ''),
        );
        return $data;
    }
    
    public function generateTestTable( $variable ){
        $data = array(
            'tables' => array(
                array(
                    'template_variable_name' => $variable,
                    'style' => 'border: 1px solid black;',
                    'table-type' => 'full_table',
                    'rows'  => array( 
                        array( 'row-type' => 'normal',  'cells' => array( 
                            array( 'cell-type' => 'normal', 'colspan' => 2, 'rowspan' => 0, 'data' => 'A1:B1', 'style' => 'background-color:red;font-weight:bold;'),
                            array( 'cell-type' => 'covered' , 'colspan' => 0, 'rowspan' => 0),
                            array( 'cell-type' => 'normal', 'colspan' => 0, 'rowspan' => 0, 'data' => 'C1' ),
                        )), 
                        array( 'row-type' => 'normal',  'cells' => array( 
                            array( 'cell-type' => 'normal', 'colspan' => 0, 'rowspan' => 2, 'data' => 'A2:A3' ),
                            array( 'cell-type' => 'normal', 'colspan' => 0, 'rowspan' => 0, 'data' => 'B2' ), 
                            array( 'cell-type' => 'normal', 'colspan' => 0, 'rowspan' => 0, 'data' => 'C2' ),
                        )), 
                        array( 'row-type' => 'lastrow',  'cells' => array( 
                            array( 'cell-type' => 'covered' ),
                            array( 'cell-type' => 'normal', 'colspan' => 0, 'rowspan' => 0, 'data' => 'B3' ), 
                            array( 'cell-type' => 'normal', 'colspan' => 0, 'rowspan' => 0, 'data' => 'C3' ), 
                        )), 
                    ),
                ),
            ),
            'images' => array(),
            'static_content' => array(
                array( 'template_variable_name' => 'my_name', 'data' => 'Kecskes Peter' ),
            ),
        );
        $this->printTestXml->exchangeStringValues($data);
    }
    public function pdfLink()
    {
        return '<a href="getPDF" target="_blank" > See PDF </a>';
    }
}
