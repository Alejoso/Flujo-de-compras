@extends('layouts.technician')
@section('page-title', __('technician_quotation.title_index') . ' — V' . $version->getVersionNumber())

@section('content')
  <div class="pj-wrapper">

    <div class="um-header">
      <h1 class="um-title">
        <i class="bi bi-file-earmark-pdf me-2"></i>
        {{ __('technician_quotation.title_index') }} — V{{ $version->getVersionNumber() }}
      </h1>
      <div class="d-flex gap-2">
        <a href="{{ route('technician.quotation.pdfDownload', [$project->getId(), $version->getId()]) }}"
          class="um-btn-primary px-3 py-2">
          <i class="bi bi-download me-1"></i> {{ __('technician_quotation.btn_download_pdf') }}
        </a>
        <a href="{{ route('technician.quotation.versions', [$project->getId(), $version->getQuotation()->getId()]) }}"
          class="um-btn-icon um-btn-icon--edit px-3 py-2">
          <i class="bi bi-arrow-left me-1"></i> {{ __('technician_quotation.btn_back') }}
        </a>
      </div>
    </div>

    <div class="cot-doc-wrapper">

      <div class="cot-doc-header">
        <h2>{{ $technician->getName() }}</h2>
        <p>{{ __('technician_quotation.pdf_label_tel') }}: {{ $technician->getPhoneNumber() }} &nbsp;&nbsp;
          {{ __('technician_quotation.pdf_label_email') }}: {{ $technician->getEmail() }}</p>
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

    </div>

  </div>
@endsection
