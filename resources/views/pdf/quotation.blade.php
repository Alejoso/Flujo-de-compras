<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <style>
    {!! file_get_contents(public_path('css/technician.css')) !!}
  </style>
</head>

<body>

  <div class="cot-doc-header">
    <h2>{{ $technician->getName() }}</h2>
    <p>Tel: {{ $technician->getPhoneNumber() }} &nbsp;&nbsp; Email: {{ $technician->getEmail() }}</p>
    <p>{{ $project->getCity() }}, {{ __('technician_quotation.pdf_country') }}</p>
  </div>

  <div class="cot-doc-title">{{ __('technician_quotation.title_index') }} {{ $quotationNumber }} -
    V{{ $version->getVersionNumber() }}</div>
  <div class="cot-doc-title">{{ $project->getName() }}</div>
  <div class="cot-doc-date">{{ $date }}</div>

  <p class="cot-doc-intro">{{ __('technician_quotation.pdf_intro') }}</p>

  <table class="cot-doc-table">
    <thead>
      <tr>
        <th>{{ __('technician_quotation.pdf_th_quantity') }}</th>
        <th>{{ __('technician_quotation.pdf_th_description') }}</th>
        <th>{{ __('technician_quotation.pdf_th_specification') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($materials as $item)
        <tr>
          <td>
            @if ($item['presentation'])
              {{ $item['quantity'] }} {{ $item['presentation'] }} de {{ $item['units'] }}
            @else
              {{ $item['quantity'] }} {{ $item['units'] }}
            @endif
          </td>
          <td>{{ $item['description'] }}</td>
          <td><strong>{{ $item['specification'] }}</strong></td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="cot-doc-page-number">1</div>

</body>

</html>
