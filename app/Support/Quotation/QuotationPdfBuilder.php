<?php

namespace App\Support\Quotation;

use App\Models\Quotation;
use App\Models\Project;
use App\Models\QuotationVersion;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class QuotationPdfBuilder
{
    // Loads a quotation version with all relations needed for the PDF.
    public function loadVersionWithRelations(int|string $versionId): QuotationVersion
    {
        return QuotationVersion::with([
            'quotation.creator',
            'quotation.project',
            'presentationMaterialTypeQuotationVersions.presentationMaterialType.presentation',
            'presentationMaterialTypeQuotationVersions.presentationMaterialType.materialType.material',
            'presentationMaterialTypeQuotationVersions.presentationMaterialType.materialType.type.unitOfMeasure',
        ])->findOrFail($versionId);
    }

    // Prepares the data needed to render the PDF (technician, date, materials, and quotation number).
    public function preparePdfData(QuotationVersion $version): array
    {
        $quotation = $version->getQuotation();
        $tecnico = $quotation->getCreator();
        $quotationNumber = Quotation::where('project_id', $quotation->project->getId())
            ->where('id', '<=', $quotation->getId())
            ->count();

        $fecha = Carbon::parse($version->getCreatedAt())->locale('es')->isoFormat('MMMM D, YYYY');

        $materiales = $version->getPresentationMaterialTypeQuotationVersions()->map(fn ($item) => [
            'cantidad'       => $item->getQuantity(),
            'unidades'       => ($pmt = $item->getPresentationMaterialType())->getPresentationQuantity()
                                    .(($u = $pmt->getMaterialType()->getType()->getUnitOfMeasure()) ? ' '.$u->getAbbreviation() : ''),
            'presentacion'   => $pmt->getPresentation()->getName(),
            'descripcion'    => $pmt->getMaterialType()->getMaterial()->getDescription(),
            'especificacion' => strtoupper($pmt->getMaterialType()->getType()->getSpecification()),
        ]);

        return compact('tecnico', 'fecha', 'materiales', 'quotationNumber', 'version');
    }

    // Deletes the PDF of a version from storage and clears its path.
    public function deletePreviousPdf(?string $path, ?QuotationVersion $version): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            $version->pdf_path = null;
            $version->save();
        }
    }

    // Generates the PDF for a version, saves it to public storage, and updates the version's pdf_path field.
    public function generateAndSavePdf(int $versionId, Project $project): void
    {
        $version = $this->loadVersionWithRelations($versionId);
        [
            'tecnico'         => $tecnico,
            'fecha'           => $fecha,
            'materiales'      => $materiales,
            'quotationNumber' => $quotationNumber,
            'version'         => $version,
        ] = $this->preparePdfData($version);

        $pdf = Pdf::loadView('pdf.cotizacion', compact('project', 'tecnico', 'fecha', 'materiales', 'quotationNumber', 'version'))
            ->setPaper('a4', 'portrait');

        $versionNumber = $version->getVersionNumber();
        $relativePath = 'proyecto_'.$project->getId()
            .'/cotizacion_'.$quotationNumber
            .'/p'.$project->getId().'_c'.$quotationNumber.'_v'.$versionNumber.'.pdf';

        Storage::disk('public')->put($relativePath, $pdf->output());

        $version->pdf_path = $relativePath;
        $version->save();
    }
}
