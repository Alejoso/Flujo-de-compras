<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceUploadRequest;
use App\Services\OCRSercive;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OCRController extends Controller
{
    public function process(InvoiceUploadRequest $request, OCRSercive $ocr): View|RedirectResponse
    {
        $viewData = [];

        try {
            $archivo = $request->file('invoice');
            $bytes = $archivo->getContent();
            $nombre = $archivo->getClientOriginalName();

            $viewData['invoiceData'] = $ocr->processInvoice($bytes, $nombre);
        } catch (Exception $e) {
            session()->flash('error', 'No se pudo procesar la factura: '.$e->getMessage());

            return redirect()->back();
        }

        return view('admin.invoice.index')->with('viewData', $viewData);
    }
}
