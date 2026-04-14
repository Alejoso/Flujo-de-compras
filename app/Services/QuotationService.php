<?php

namespace App\Services;

use App\Models\Quotation;
use App\Models\PresentationMaterialTypeQuotationVersion;
use App\Models\Project;
use App\Models\QuotationVersion;
use Illuminate\Support\Facades\Auth;

class QuotationService
{
    // Creates the initial quotation with its first version and materials inside a transaction.
    public function createQuotation(Project $project, array $materials): array
    {
        $quotationId = null;
        $versionId = null;

        Quotation::query()->getConnection()->transaction(function () use ($project, $materials, &$quotationId, &$versionId) {
            $quotation = Quotation::create([
                'project_id' => $project->getId(),
                'status'     => 'Technician',
                'created_by' => Auth::id(),
            ]);
            $quotationId = $quotation->getId();

            $version = QuotationVersion::create([
                'version_number' => '1',
                'is_most_recent' => true,
                'quotation_id'   => $quotation->getId(),
            ]);
            $versionId = $version->getId();

            foreach ($materials as $item) {
                PresentationMaterialTypeQuotationVersion::create([
                    'quantity'                      => $item['quantity'],
                    'quotation_version_id'          => $version->getId(),
                    'presentation_material_type_id' => $item['presentation_material_type_id'],
                ]);
            }
        });

        return ['quotationId' => $quotationId, 'versionId' => $versionId];
    }

    // Creates a new version of the quotation with the given materials inside a transaction.
    public function createNewVersion(Quotation $quotation, array $materials): int
    {
        $newVersionId = null;

        Quotation::query()->getConnection()->transaction(function () use ($quotation, $materials, &$newVersionId) {
            $quotation->setStatus('Technician Edited');
            $quotation->save();

            $quotation->quotationVersions()->update(['is_most_recent' => false]);

            $newVersionNumber = $quotation->quotationVersions()->count() + 1;

            $newVersion = QuotationVersion::create([
                'version_number' => (string) $newVersionNumber,
                'is_most_recent' => true,
                'quotation_id'   => $quotation->getId(),
            ]);
            $newVersionId = $newVersion->getId();

            foreach ($materials as $item) {
                PresentationMaterialTypeQuotationVersion::create([
                    'quantity'                      => $item['quantity'],
                    'quotation_version_id'          => $newVersion->getId(),
                    'presentation_material_type_id' => $item['presentation_material_type_id'],
                ]);
            }
        });

        return $newVersionId;
    }
}
