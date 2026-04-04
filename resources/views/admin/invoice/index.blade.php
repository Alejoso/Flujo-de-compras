@extends('layouts.admin')
@section('content')
<body>

    <h2>Subir Factura</h2>

    <form action="{{ route('admin.OCR.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="invoice" accept=".pdf,.png,.jpg">
        <button type="submit">Procesar</button>
    </form>

</body>
@endsection