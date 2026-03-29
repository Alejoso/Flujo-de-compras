<x-mail.layout title="Notificación Técnica">
 
    <x-mail.header
        label="Notificación del sistema"
        title="Actividad registrada en el sistema"
    />
 
    <x-mail.card title="Descripción de la acción">
        <p class="action-description">{{ $viewData['description'] }}</p>
    </x-mail.card>
 
    <x-mail.card title="Detalles del evento">
        <div class="data-grid">
            <x-mail.dataRow label="Acción"       :value="$viewData['action']"     type="badge"      />
            <x-mail.dataRow label="Fecha y hora" :value="$viewData['timestamp']"  type="timestamp"  />
            <x-mail.dataRow label="Técnico"      :value="$viewData['technicianName']" type="technician" />
            <x-mail.dataRow label="Proyecto"     :value="$viewData['projectName']"    type="project"    />
        </div>
    </x-mail.card>
 
    <x-mail.footer />
 
</x-mail.layout>