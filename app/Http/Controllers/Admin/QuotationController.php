<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotation\UpdateQuotationRequest;
use App\Models\MaterialType;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\QuotationVersion;
use App\Services\QuotationService;
use App\Support\Quotation\QuotationBuilder;
use App\Support\Quotation\QuotationMailer;
use App\Support\Quotation\QuotationPdfBuilder;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuotationController extends Controller
{
    public function __construct(
        private readonly QuotationBuilder $builder,
        private readonly QuotationPdfBuilder $pdfBuilder,
        private readonly QuotationService $quotationService,
        private readonly QuotationMailer $mailer,
    ) {}

    // Displays all versions of a specific quotation for the admin.
    public function versions(string $projectId, string $quotationId): View
    {
        $viewData = [];
        $viewData['project'] = Project::findOrFail($projectId);
        $viewData['quotation'] = Quotation::findOrFail($quotationId);
        $viewData['versions'] = $viewData['quotation']->quotationVersions()
            ->orderBy('version_number')
            ->get();
        $viewData['currentVersion'] = $viewData['versions']->firstWhere('is_most_recent', true);
        $viewData['quotationNumber'] = Quotation::where('project_id', $projectId)
            ->where('id', '<=', $quotationId)
            ->count();
        $viewData['status'] = $viewData['quotation']->getStatus();

        return view('admin.quotation.versions')->with('viewData', $viewData);
    }

    // Displays the detail of a specific version for the admin.
    public function show(string $projectId, string $versionId): View
    {
        $viewData = [];
        $viewData['project'] = Project::findOrFail($projectId);
        $viewData['version'] = QuotationVersion::with([
            'quotation',
            'presentationMaterialTypeQuotationVersions.presentationMaterialType.presentation',
            'presentationMaterialTypeQuotationVersions.presentationMaterialType.materialType.material',
            'presentationMaterialTypeQuotationVersions.presentationMaterialType.materialType.type.unitOfMeasure',
        ])->findOrFail($versionId);

        $viewData['versionMaterials'] = $this->builder->buildVersionMaterials($viewData['version']);

        return view('admin.quotation.show')->with('viewData', $viewData);
    }

    // Displays the form for editing the most recent version of a quotation (admin).
    public function edit(string $projectId, string $versionId): View
    {
        $viewData = [];
        $viewData['project'] = Project::findOrFail($projectId);
        $viewData['version'] = QuotationVersion::with([
            'quotation',
            'presentationMaterialTypeQuotationVersions.presentationMaterialType.presentation',
            'presentationMaterialTypeQuotationVersions.presentationMaterialType.materialType.material',
            'presentationMaterialTypeQuotationVersions.presentationMaterialType.materialType.type.unitOfMeasure',
        ])->findOrFail($versionId);

        $materialTypes = MaterialType::with([
            'material',
            'type.unitOfMeasure',
            'presentationMaterialTypes.presentation',
        ])->get();
        $viewData['materialTypeData'] = $this->builder->buildMaterialTypeData($materialTypes);
        $viewData['versionMaterials'] = $this->builder->buildVersionMaterials($viewData['version']);

        return view('admin.quotation.edit')->with('viewData', $viewData);
    }

    // Creates a new version as admin, sets status to Admin Edited, regenerates PDF and sends email.
    public function update(UpdateQuotationRequest $request, string $projectId, string $versionId): RedirectResponse
    {
        $project = Project::findOrFail($projectId);
        $currentVersion = QuotationVersion::findOrFail($versionId);
        $quotation = $currentVersion->quotation;
        $mostRecentVersion = $quotation->quotationVersions()->where('is_most_recent', true)->first();
        $previousPdfPath = ($mostRecentVersion && $mostRecentVersion->getVersionNumber() !== '1')
            ? $mostRecentVersion->getPdfPath()
            : null;

        try {
            $newVersionId = $this->quotationService->createNewVersion($quotation, $request->materials, 'Admin Edited');
        } catch (Exception $e) {
            session()->flash('error', __('technician_quotation.flash_update_error', ['error' => $e->getMessage()]));

            return redirect()->route('admin.quotation.versions', [$projectId, $quotation->getId()]);
        }

        $this->pdfBuilder->deletePreviousPdf($previousPdfPath, $mostRecentVersion);

        try {
            $this->pdfBuilder->generateAndSavePdf($newVersionId, $project);
        } catch (Exception $e) {
            session()->flash('error', __('technician_quotation.flash_update_pdf_error', ['error' => $e->getMessage()]));

            return redirect()->route('admin.quotation.versions', [$projectId, $quotation->getId()]);
        }

        session()->flash('success', __('technician_quotation.flash_update_success'));

        return redirect()->route('admin.quotation.versions', [$projectId, $quotation->getId()]);
    }

    // Accepts the quotation as-is, moving it to In Process.
    public function accept(string $projectId, string $quotationId): RedirectResponse
    {
        $quotation = Quotation::findOrFail($quotationId);

        if (! in_array($quotation->getStatus(), ['Technician Final', 'Admin Edited'])) {
            session()->flash('error', __('project.flash_accept_invalid_status'));

            return redirect()->route('admin.quotation.versions', [$projectId, $quotationId]);
        }

        $quotation->setStatus('In Process');
        $quotation->save();

        session()->flash('success', __('project.flash_accept_success'));

        return redirect()->route('admin.quotation.versions', [$projectId, $quotationId]);
    }

    // Rejects the quotation and returns it to the technician for editing (sends email).
    public function reject(string $projectId, string $quotationId): RedirectResponse
    {
        $quotation = Quotation::findOrFail($quotationId);
        $project = Project::findOrFail($projectId);

        if (! in_array($quotation->getStatus(), ['Technician Final', 'Admin Edited'])) {
            session()->flash('error', __('project.flash_reject_invalid_status'));

            return redirect()->route('admin.quotation.versions', [$projectId, $quotationId]);
        }

        $quotation->setStatus('Technician Edited');
        $quotation->save();

        try {
            $currentVersion = $quotation->quotationVersions()->where('is_most_recent', true)->first();
            if ($currentVersion) {
                $this->mailer->sendRejectEmail($quotation, $project, $currentVersion);
            }
        } catch (Exception $e) {
            session()->flash('error', __('email.quote_rejected_error'));
        }

        session()->flash('success', __('project.flash_reject_success'));

        return redirect()->route('admin.quotation.versions', [$projectId, $quotationId]);
    }
}
