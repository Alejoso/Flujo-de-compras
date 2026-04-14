@extends('layouts.tecnico')
@section('page-title', __('tecnico_cotizacion.title_index') . ' — V' . $version->getVersionNumber())

@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-file-earmark-pdf me-2"></i>
        {{ __('tecnico_cotizacion.title_index') }} — V{{ $version->getVersionNumber() }}
      </h1>
      <div class="d-flex gap-2">
        <a href="{{ route('technician.quotation.pdfDownload', [$project->getId(), $version->getId()]) }}"
          class="um-btn-primary px-3 py-2">
          <i class="bi bi-download me-1"></i> {{ __('tecnico_cotizacion.btn_download_pdf') }}
        </a>
        <a href="{{ route('technician.quotation.versions', [$project->getId(), $version->getQuotation()->getId()]) }}"
          class="um-btn-icon um-btn-icon--edit px-3 py-2">
          <i class="bi bi-arrow-left me-1"></i> {{ __('tecnico_cotizacion.btn_back') }}
        </a>
      </div>
    </div>

    <div class="cot-doc-wrapper">

      <div class="cot-doc-header">
        <h2>{{ $tecnico->getName() }}</h2>
        <p>{{ __('tecnico_cotizacion.pdf_label_tel') }}: {{ $tecnico->getPhoneNumber() }} &nbsp;&nbsp;
          {{ __('tecnico_cotizacion.pdf_label_email') }}: {{ $tecnico->getEmail() }}</p>
        <p>{{ $project->getCity() }}, {{ __('tecnico_cotizacion.pdf_country') }}</p>
      </div>

      <div class="cot-doc-title">{{ __('tecnico_cotizacion.title_index') }} {{ $quotationNumber }} -
        V{{ $version->getVersionNumber() }}</div>
      <div class="cot-doc-title">{{ $project->getName() }}</div>
      <div class="cot-doc-date">{{ $fecha }}</div>

      <p class="cot-doc-intro">{{ __('tecnico_cotizacion.pdf_intro') }}</p>

      <table class="cot-doc-table">
        <thead>
          <tr>
            <th>{{ __('tecnico_cotizacion.pdf_th_quantity') }}</th>
            <th>{{ __('tecnico_cotizacion.pdf_th_description') }}</th>
            <th>{{ __('tecnico_cotizacion.pdf_th_specification') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($materiales as $item)
            <tr>
              <td>
                @if ($item['presentacion'])
                  {{ $item['cantidad'] }} {{ $item['presentacion'] }} de {{ $item['unidades'] }}
                @else
                  {{ $item['cantidad'] }} {{ $item['unidades'] }}
                @endif
              </td>
              <td>{{ $item['descripcion'] }}</td>
              <td><strong>{{ $item['especificacion'] }}</strong></td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </div>

  </div>
@endsection
