<x-mail.layout title="Notificación Técnica">
 
    <x-mail.header
        label="Notificación del sistema"
        title="Actividad registrada en el sistema"
    />
 
    <x-mail.card title="Descripción de la acción">
        <p class="action-description">{{ $viewData['description'] }}</p>
    </x-mail.card>
    
    <div style="border-radius: 8px; overflow: hidden;">

        <table class="data-grid" style="background-color: #161616;" width="100%" cellpadding="0" cellspacing="0">
            <x-mail.dataRow label="Estado"       :value="$viewData['state']"     type="badge"      />
            <x-mail.dataRow label="Fecha y hora" :value="$viewData['timestamp']"  type="timestamp"  />
            <x-mail.dataRow label="Técnico"      :value="$viewData['technicianName']" type="technician" />
            <x-mail.dataRow label="Proyecto"     :value="$viewData['projectName']"    type="project"    />
            <x-mail.dataRow label="Versión"     :value="$viewData['version']"    type="version"    />
        </table>

    </div>
 
    <x-mail.footer />
 
</x-mail.layout>