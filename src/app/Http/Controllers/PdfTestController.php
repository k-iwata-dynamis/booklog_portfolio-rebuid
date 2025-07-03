<?php

namespace App\Http\Controllers;

use App\Services\PdfService;
use Illuminate\Http\Response;

class PdfTestController extends Controller
{
    private PdfService $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function generateTestPdf(): Response
    {
        $html = view('pdf.test-template')->render();
        $pdfContent = $this->pdfService->generatePdf($html, 'test.pdf');

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="test.pdf"',
        ]);
    }
}
