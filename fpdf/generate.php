<?php
	require('fpdf.php');
	

	class PDF extends FPDF{
		// Load data
		/*
		function LoadData($file){
			// Read file lines
			$lines = file($file);
			$data = array();
			foreach($lines as $line)
				$data[] = explode('|',trim($line));
			return $data;
		}*/

		// Simple table
		
		function BasicTable($header, $data, $widths){
			// Header
			$this->SetFont('Arial','',14);
			$x = 0;
			foreach($header as $col)
			{
				$this->Cell($widths[$x],7,$col,1);
				$x++;
			}
			$this->Ln();
			// Data
			
			$this->SetFont('Arial','',10);
			foreach($data as $row)
			{
				
				$x = 0;
				foreach($row as $col)
				{
					$this->Cell($widths[$x],6,$col,1);
					$x++;
				}
				$this->Ln();
			}
		}
	}
	$pdf = new PDF("L");
	// Column headings
	$header = explode(",",$_POST['headers']);
	// Data loading
	$data_raw = explode(",,",$_POST['data']);
	
	$data = array();
	
	for($x = 0; $x < count($data_raw) / count($header); $x++)
	{
		$temp = array();
		for($y = 0; $y < count($header); $y++)
		{
			array_push($temp, $data_raw[($x * count($header)) + $y]);
		}
		array_push($data, $temp);
	}
	
	$widths = array(40, 25, 40, 30, 30, 40, 20, 30);
	$pdf->SetFont('Arial','',10);
	$pdf->AddPage();
	$pdf->BasicTable($header,$data, $widths);
	$pdf->Output("report.pdf", "D");
?>