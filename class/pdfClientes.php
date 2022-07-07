<?php

   //Clase pdfClientes
    //generar los pdfs de clientes
    class pdfClientes extends FPDF {

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
            $this->Cell(43,10,'Listado de Clientes',0,0);
            $this->Cell(0,10, utf8_decode($DateAndTime),0,0, 'R');
            $this->ln(14);

		}

        function encabezado(){
            $this->SetFont('times','',11.5);
            $this->Cell(25,10, 'Nombre','B',0, 'L');
            $this->Cell(35,10, 'Apellidos','B',0, 'L');
            $this->Cell(25,10, 'Telefono','B',0, 'L');
            $this->Cell(40,10, 'Ciudad','B',0, 'L');
            $this->Cell(22,10, 'DNI','B',0, 'L');
            $this->Cell(49,10, 'Email','B',0, 'L');
            $this->Ln(10);
        }
               
        function body($clientes){
            $this->SetFont('times','',11.5);
            foreach($clientes as $cliente):

                $this->Cell(25,10, utf8_decode($cliente->nombre),0,0, 'L');
                $this->Cell(35,10, utf8_decode($cliente->apellidos),0,0, 'L');
                $this->Cell(25,10, utf8_decode($cliente->telefono),0,0, 'L');
                $this->Cell(40,10, utf8_decode($cliente->ciudad),0,0, 'L');
                $this->Cell(22,10, utf8_decode($cliente->dni),0,0, 'L');
                $this->Cell(53,10, utf8_decode($cliente->email),0,0, 'L');
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