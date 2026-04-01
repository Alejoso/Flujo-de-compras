<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceUploadRequest;
use App\Services\OCRSercive;
use Illuminate\View\View;

class OCRController extends Controller
{
    public function process(InvoiceUploadRequest $request, OCRSercive $ocr): View
    {
        $viewData = [];
        $archivo = $request->file('invoice');

        $bytes = $archivo->getContent();
        $nombre = $archivo->getClientOriginalName();
        $invoiceData = $ocr->processInvoice($bytes, $nombre);

        dd($invoiceData);

        $viewData['invoiceData'] = $invoiceData;

        return view('admin.invoice.index');
    }
}
