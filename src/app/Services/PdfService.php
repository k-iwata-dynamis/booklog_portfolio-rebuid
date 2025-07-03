<?php

namespace App\Services;

use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class PdfService
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Create a new mPDF instance with Japanese font support
     */
    public function createPdf(): Mpdf
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $config = array_merge([
            'fontDir' => array_merge($fontDirs, [
                '/usr/share/fonts/opentype/ipafont-gothic',
                '/usr/share/fonts/opentype/ipafont-mincho',
            ]),
            'fontdata' => array_merge($fontData, [
                'ipag' => [
                    'R' => 'ipag.ttf',
                ],
                'ipagp' => [
                    'R' => 'ipagp.ttf',
                ],
            ]),
            'default_font' => 'ipag'
        ], $this->config);

        return new Mpdf($config);
    }

    /**
     * Generate PDF from HTML content
     */
    public function generatePdf(string $html, string $filename = 'document.pdf'): string
    {
        $mpdf = $this->createPdf();
        $mpdf->WriteHTML($html);
        
        return $mpdf->Output($filename, 'S');
    }

    /**
     * Save PDF to file
     */
    public function savePdf(string $html, string $filepath): void
    {
        $mpdf = $this->createPdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output($filepath, 'F');
    }
}
