<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ConvertController extends Controller
{
    public function convert(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimetypes:application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Get the original file name without the extension
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Load the Word file
        $phpWord = IOFactory::load($file);

        // Save the Word file as HTML
        $htmlPath = storage_path('app/' . $originalName . '.html');
        $xmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        $xmlWriter->save($htmlPath);

        // Convert the HTML file to PDF
        $html = file_get_contents($htmlPath);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdf = $dompdf->output();

        // Save the PDF file
        $pdfPath = storage_path('app/' . $originalName . '.pdf');
        file_put_contents($pdfPath, $pdf);

        // Delete the temporary HTML file
        unlink($htmlPath);

        // Return the PDF file as a download
        return response()->download($pdfPath);
    }
}
