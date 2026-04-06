<?php

namespace App\Support\Cotizacion;

use App\Models\Cotizacion;
use App\Models\Proyecto;
use App\Models\User;
use App\Models\VersionCotizacion;
use App\Services\SendMessageFactory;
use Illuminate\Support\Facades\Auth;

class CotizacionMailer
{
    // Envía un correo notificando la creación de una cotización.
    public function enviarEmailCreacion(Cotizacion $cotizacion, Proyecto $project, VersionCotizacion $version): void
    {
        $sendMessage = app(SendMessageFactory::class)->make('email');
        $user = User::findOrFail(Auth::id());
        $position = $this->posicionEnProyecto($cotizacion, $project);

        $sendMessage->send(
            $cotizacion->getEstado(),
            __('email.quote_created_subject', ['project' => $project->getNombre()]),
            __('email.quote_created_body', ['id' => $position, 'project' => $project->getNombre()]),
            $project->getNombre(),
            $user->getName().' - CC: '.$user->getCedula(),
            $version->getnumeroVersion(),
            $version->getPdfPath()
        );
    }

    // Envía un correo notificando la edición de una cotización.
    public function enviarEmailEdicion(Cotizacion $cotizacion, Proyecto $project, VersionCotizacion $version): void
    {
        $sendMessage = app(SendMessageFactory::class)->make('email');
        $user = User::findOrFail(Auth::id());
        $position = $this->posicionEnProyecto($cotizacion, $project);

        $sendMessage->send(
            $cotizacion->getEstado(),
            __('email.quote_edited_subject', ['project' => $project->getNombre()]),
            __('email.quote_edited_body', ['id' => $position, 'project' => $project->getNombre()]),
            $project->getNombre(),
            $user->getName().' - CC: '.$user->getCedula(),
            $version->getnumeroVersion(),
            $version->getPdfPath()
        );
    }

    // Retorna la posición ordinal de la cotización dentro del proyecto.
    private function posicionEnProyecto(Cotizacion $cotizacion, Proyecto $project): int
    {
        return Cotizacion::where('proyectoId', $project->getId())
            ->where('id', '<=', $cotizacion->getId())
            ->orderBy('id')
            ->count();
    }
}
