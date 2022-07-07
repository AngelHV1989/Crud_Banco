<?php

    /*
    Para generar los pdf de clientes
    */

    class pdfMovimientos extends FPDF {

        function Header(){
            $this->SetFont('Times','',12);
            $this->Cell(30,10,'GESBANK 1.0', 'B', 0,'L');
            $this->Cell(120,10,'Angel Hueso Vecina', 'B', 0, 'C');
            $this->Cell(0,10,'2DAW 21/22', 'B', 0, 'R');
            $this->ln(14);
            $this->Title();
            $this->ln(1);
            $this->encabezado();
            
                        
        }

        function Title()
        {
            date_default_timezone_set('Europe/Amsterdam');    
            $DateAndTime = date('m-d-Y h:i:s a', time());
			$this->SetFont('times','B',12);
            $this->Cell(43,10,'Listado de Movimientos',0,0);
            $this->Cell(0,10, utf8_decode($DateAndTime),0,0, 'R');
            $this->ln(14);

		}

        function encabezado(){
            $this->SetFont('times','',11.5);
            $this->Cell(45,10, 'Num. Cuenta','B',0, 'L');
            $this->Cell(40,10, 'Fecha y Hora','B',0, 'L');
            $this->Cell(30,10, 'Concepto','B',0, 'L');
            $this->Cell(18,10, 'Tipo','B',0, 'L');
            $this->Cell(35,10, 'Cantidad','B',0, 'L');
            $this->Cell(20,10, 'Saldo','B',0, 'L');
            $this->Ln(10);
        }
               
        function body($movimientos){
            $this->SetFont('times','',11.5);
            foreach($movimientos as $movimiento):
                
                $this->Cell(45,10, utf8_decode($movimiento->num_cuenta),0,0, 'L');
                $this->Cell(40,10, utf8_decode($movimiento->fecha_hora),0,0, 'L');
                $this->Cell(30,10, utf8_decode($movimiento->concepto),0,0, 'L');
                $this->Cell(18,10, utf8_decode($movimiento->tipo),0,0, 'L');
                $this->Cell(35,10, utf8_decode($movimiento->cantidad),0,0, 'L');
                $this->Cell(35,10, utf8_decode($movimiento->saldo),0,0, 'L');
                $this->Ln(10);
                
                endforeach;
        }
        

        function Footer()
        {
        $this->SetY(-10);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}','T',0,'C');
        }
}


    
?>