<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\Quotation\QuotationPdfBuilder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

class QuotationPdfController extends Controller
{
    public function __construct(private readonly QuotationPdfBuilder $pdfBuilder) {}

    // Displays the on-screen preview of the PDF for a specific version.
    public function pdfView(string $projectId, string $versionId): View
    {
        [$project, $data] = $this->loadPdfData($projectId, $versionId);

        return view('technician.quotation.pdf-view', array_merge(['project' => $project], $data));
    }

    // Generates and directly downloads the PDF for a specific version.
    public function pdfDownload(string $projectId, string $versionId)
    {
        [$project, $data] = $this->loadPdfData($projectId, $versionId);

        return Pdf::loadView('pdf.quotation', array_merge(['project' => $project], $data))
            ->setPaper('a4', 'portrait')
            ->download('p'.$project->getId().'_c'.$data['quotationNumber'].'_v'.$data['version']->getVersionNumber().'.pdf');
    }

    // Loads the project and prepares all data needed to render the PDF.
    private function loadPdfData(string $projectId, string $versionId): array
    {
        $project = Project::findOrFail($projectId);
        $version = $this->pdfBuilder->loadVersionWithRelations($versionId);
        $data = $this->pdfBuilder->preparePdfData($version);

        return [$project, $data];
    }
}
