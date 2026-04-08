@extends('layouts.admin')
@section('content')

    <h2>{{ __('admin_factura.title') }}</h2>

    <form action="{{ route('admin.OCR.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="invoice" accept=".pdf,.png,.jpg">
        <button type="submit">{{ __('admin_factura.btn_process') }}</button>
    </form>

@endsection
