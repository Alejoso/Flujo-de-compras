<?php

namespace App\Support\Quotation;

use App\Models\Project;
use App\Models\Quotation;
use App\Models\QuotationVersion;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Support\Facades\Auth;

class QuotationMailer
{
    // Sends an email notifying the creation of a quotation.
    public function sendCreationEmail(Quotation $quotation, Project $project, QuotationVersion $version): void
    {
        $emailService = new EmailService;
        $user = User::findOrFail(Auth::id());
        $position = $this->positionInProject($quotation, $project);

        $emailService->send(
            $this->translateStatus($quotation->getStatus()),
            __('email.quote_created_subject', ['project' => $project->getName()]),
            __('email.quote_created_body', ['id' => $position, 'project' => $project->getName()]),
            $project->getName(),
            $user->getName().' - CC: '.$user->getIdNumber(),
            $version->getVersionNumber(),
            $version->getPdfPath()
        );
    }

    // Sends an email notifying that the technician submitted the final version.
    public function sendSubmitEmail(Quotation $quotation, Project $project, QuotationVersion $version): void
    {
        $emailService = new EmailService;
        $user = User::findOrFail(Auth::id());
        $position = $this->positionInProject($quotation, $project);

        $emailService->send(
            $this->translateStatus($quotation->getStatus()),
            __('email.quote_submitted_subject', ['id' => $position, 'project' => $project->getName()]),
            __('email.quote_submitted_body', ['id' => $position, 'project' => $project->getName()]),
            $project->getName(),
            $user->getName().' - CC: '.$user->getIdNumber(),
            $version->getVersionNumber(),
            $version->getPdfPath()
        );
    }

    // Sends an email notifying that the admin returned the quotation to the technician.
    public function sendRejectEmail(Quotation $quotation, Project $project, QuotationVersion $version): void
    {
        $emailService = new EmailService;
        $user = User::findOrFail(Auth::id());
        $position = $this->positionInProject($quotation, $project);

        $emailService->send(
            $this->translateStatus($quotation->getStatus()),
            __('email.quote_rejected_subject', ['id' => $position, 'project' => $project->getName()]),
            __('email.quote_rejected_body', ['id' => $position, 'project' => $project->getName()]),
            $project->getName(),
            $user->getName().' - CC: '.$user->getIdNumber(),
            $version->getVersionNumber(),
            $version->getPdfPath()
        );
    }

    // Sends an email notifying the editing of a quotation.
    public function sendEditEmail(Quotation $quotation, Project $project, QuotationVersion $version): void
    {
        $emailService = new EmailService;
        $user = User::findOrFail(Auth::id());
        $position = $this->positionInProject($quotation, $project);

        $emailService->send(
            $this->translateStatus($quotation->getStatus()),
            __('email.quote_edited_subject', ['project' => $project->getName()]),
            __('email.quote_edited_body', ['id' => $position, 'project' => $project->getName()]),
            $project->getName(),
            $user->getName().' - CC: '.$user->getIdNumber(),
            $version->getVersionNumber(),
            $version->getPdfPath()
        );
    }

    // Returns the Spanish label for a given quotation status.
    private function translateStatus(string $status): string
    {
        return match ($status) {
            'Technician'       => __('technician_quotation.status_technician'),
            'Technician Edited' => __('technician_quotation.status_technician_edited'),
            'Pending'          => __('technician_quotation.status_pending'),
            'Technician Final' => __('technician_quotation.status_technician_final'),
            'Admin Edited'     => __('technician_quotation.status_admin_edited'),
            'In Process'       => __('technician_quotation.status_in_process'),
            'Invoiced'         => __('technician_quotation.status_invoiced'),
            default            => __('technician_quotation.status_cancelled'),
        };
    }

    // Returns the ordinal position of the quotation within the project.
    private function positionInProject(Quotation $quotation, Project $project): int
    {
        return Quotation::where('project_id', $project->getId())
            ->where('id', '<=', $quotation->getId())
            ->orderBy('id')
            ->count();
    }
}
