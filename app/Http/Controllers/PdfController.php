<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
	protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function index()
    {
    	$this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->AddPage();
        $this->fpdf->Text(10, 10, "Hello Bitch!");

        $this->fpdf->Output('D', 'Recu.pdf');

        exit;
    }
}
