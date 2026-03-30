<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Services\OCRSercive;
use App\Http\Requests\InvoiceUploadRequest;

class OCRController extends Controller
{
    public function process(InvoiceUploadRequest $request , OCRSercive $ocr): View 
    {
        $viewData = [];
        $archivo = $request->file('invoice');

        $bytes = $archivo->getContent();
        $nombre   = $archivo->getClientOriginalName();
        $invoiceData = $ocr->processInvoice($bytes, $nombre);

        dd($invoiceData);

        $viewData['invoiceData'] = $invoiceData;

        return view('admin.invoice.index');
    }
}
