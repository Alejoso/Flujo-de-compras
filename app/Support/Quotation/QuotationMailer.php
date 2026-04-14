<?php

namespace App\Support\Quotation;

use App\Models\Quotation;
use App\Models\Project;
use App\Models\User;
use App\Models\QuotationVersion;
use App\Services\EmailService;
use Illuminate\Support\Facades\Auth;

class QuotationMailer
{
    // Sends an email notifying the creation of a quotation.
    public function sendCreationEmail(Quotation $quotation, Project $project, QuotationVersion $version): void
    {
        $emailService = new EmailService();
        $user = User::findOrFail(Auth::id());
        $position = $this->positionInProject($quotation, $project);

        $emailService->send(
            $quotation->getStatus(),
            __('email.quote_created_subject', ['project' => $project->getName()]),
            __('email.quote_created_body', ['id' => $position, 'project' => $project->getName()]),
            $project->getName(),
            $user->getName().' - CC: '.$user->getIdNumber(),
            $version->getVersionNumber(),
            $version->getPdfPath()
        );
    }

    // Sends an email notifying the editing of a quotation.
    public function sendEditEmail(Quotation $quotation, Project $project, QuotationVersion $version): void
    {
        $emailService = new EmailService();
        $user = User::findOrFail(Auth::id());
        $position = $this->positionInProject($quotation, $project);

        $emailService->send(
            $quotation->getStatus(),
            __('email.quote_edited_subject', ['project' => $project->getName()]),
            __('email.quote_edited_body', ['id' => $position, 'project' => $project->getName()]),
            $project->getName(),
            $user->getName().' - CC: '.$user->getIdNumber(),
            $version->getVersionNumber(),
            $version->getPdfPath()
        );
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
