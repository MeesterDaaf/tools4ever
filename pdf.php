<?php

require 'fpdf.php';

class PDF extends FPDF
{
    protected $total_amount;

    // Simple table
    function BasicTable($data)
    {
        // Header
        $header = array('Lokatie', 'Aankoopsprijs', 'Product naam', 'Aantal');

        $this->Cell(40, 7, $header[0], 1);
        $this->Cell(40, 7, $header[1], 1);
        $this->Cell(60, 7, $header[2], 1);
        $this->Cell(40, 7, $header[3], 1);
        $this->Ln();

        // Data
        $this->total_amount = 0;

        foreach ($data as $row) { //loop door de database_gegevens
            $this->Cell(40, 6, $row['location_name'], 1);
            $this->Cell(40, 6, $row['purchase_price'], 1);
            $this->Cell(60, 6, $row['product_name'], 1);
            $this->Cell(40, 6, $row['amount'], 1);

            $this->Ln();

            $this->total_amount += $row['amount'];
        };
    }

    public function retrieve_totals()
    {
        $data = [
            'total_amount' => $this->total_amount,
        ];

        return $data;
    }
}

//continueer sessie zodat we de database_gegevens kunnen gebruiken. De database_gegevens array wordt gevuld bij de stock_index.php
session_start();

$pdf = new PDF();
// Column headings

$pdf->SetFont('Arial', '', 14);
$pdf->AddPage(); //maak een lege pagina
$pdf->BasicTable($_SESSION['database_gegevens']); //maak van database_gegevens een data array

$totals = $pdf->retrieve_totals();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(140, 10, 'totaal aantal producten: ' . $totals['total_amount']);
$pdf->Ln();
$pdf->Output();
