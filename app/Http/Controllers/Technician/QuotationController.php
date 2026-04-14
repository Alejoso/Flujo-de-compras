<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotation\StoreQuotationRequest;
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

    // Displays the list of quotations for a project.
    public function index(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Project::with('client')->findOrFail($id);
        $viewData['quotations'] = Quotation::where('project_id', $id)
            ->withCount('quotationVersions')
            ->with('creator')
            ->orderBy('id')
            ->get();

        return view('tecnico.cotizacion.index')->with('viewData', $viewData);
    }

    // Displays all versions of a specific quotation.
    public function versions(string $id, string $quotationId): View
    {
        $viewData = [];
        $viewData['project'] = Project::findOrFail($id);
        $viewData['quotation'] = Quotation::findOrFail($quotationId);
        $viewData['versions'] = $viewData['quotation']->quotationVersions()
            ->orderBy('version_number')
            ->get();
        $viewData['currentVersion'] = $viewData['versions']->firstWhere('is_most_recent', true);
        $viewData['quotationNumber'] = Quotation::where('project_id', $id)
            ->where('id', '<=', $quotationId)
            ->count();

        return view('tecnico.cotizacion.versions')->with('viewData', $viewData);
    }

    // Displays the detail of a specific version with its materials.
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

        return view('tecnico.cotizacion.show')->with('viewData', $viewData);
    }

    // Displays the form for creating a new quotation with the available materials.
    public function create(string $id): View
    {
        $viewData = [];
        $viewData['project'] = Project::findOrFail($id);
        $materialTypes = MaterialType::with([
            'material',
            'type.unitOfMeasure',
            'presentationMaterialTypes.presentation',
        ])->get();
        $viewData['materialTypeData'] = $this->builder->buildMaterialTypeData($materialTypes);

        return view('tecnico.cotizacion.create')->with('viewData', $viewData);
    }

    // Saves a new quotation with its first version and materials. Generates the PDF and sends an email notification.
    public function store(StoreQuotationRequest $request, string $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        try {
            ['quotationId' => $quotationId, 'versionId' => $versionId] =
                $this->quotationService->createQuotation($project, $request->materials);
        } catch (Exception $e) {
            session()->flash('error', __('tecnico_cotizacion.flash_store_error', ['error' => $e->getMessage()]));

            return redirect()->route('technician.quotation.index', $id);
        }

        try {
            $this->pdfBuilder->generateAndSavePdf($versionId, $project);
        } catch (Exception $e) {
            session()->flash('error', __('tecnico_cotizacion.flash_store_pdf_error', ['error' => $e->getMessage()]));

            return redirect()->route('technician.quotation.versions', [$id, $quotationId]);
        }

        try {
            $this->mailer->sendCreationEmail(
                Quotation::findOrFail($quotationId),
                $project,
                QuotationVersion::findOrFail($versionId)
            );
        } catch (Exception $e) {
            session()->flash('error', __('email.quote_created_error'));
        }

        session()->flash('success', __('tecnico_cotizacion.flash_store_success', ['project' => $project->getName()]));

        return redirect()->route('technician.quotation.versions', [$id, $quotationId]);
    }

    // Displays the form for editing the materials of the most recent version of a quotation.
    public function edit(string $projectId, string $versionId): View
    {
        $viewData = [];
        $viewData['project'] = Project::findOrFail($projectId);
        $viewData['version'] = QuotationVersion::with([
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

        return view('tecnico.cotizacion.edit')->with('viewData', $viewData);
    }

    // Creates a new version of the quotation with updated materials, regenerates the PDF, and sends an email notification.
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
            $newVersionId = $this->quotationService->createNewVersion($quotation, $request->materials);
        } catch (Exception $e) {
            session()->flash('error', __('tecnico_cotizacion.flash_update_error', ['error' => $e->getMessage()]));

            return redirect()->route('technician.quotation.versions', [$project->getId(), $quotation->getId()]);
        }

        $this->pdfBuilder->deletePreviousPdf($previousPdfPath, $mostRecentVersion);

        try {
            $this->pdfBuilder->generateAndSavePdf($newVersionId, $project);
        } catch (Exception $e) {
            session()->flash('error', __('tecnico_cotizacion.flash_update_pdf_error', ['error' => $e->getMessage()]));

            return redirect()->route('technician.quotation.versions', [$project->getId(), $quotation->getId()]);
        }

        try {
            $this->mailer->sendEditEmail($quotation, $project, QuotationVersion::findOrFail($newVersionId));
        } catch (Exception $e) {
            session()->flash('error', __('email.quote_edited_error'));
        }

        session()->flash('success', __('tecnico_cotizacion.flash_update_success'));

        return redirect()->route('technician.quotation.versions', [$project->getId(), $quotation->getId()]);
    }
}
