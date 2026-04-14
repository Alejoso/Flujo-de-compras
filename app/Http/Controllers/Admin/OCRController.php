<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\InvoiceUploadRequest;
use App\Services\OCRService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OCRController extends Controller
{
    public function process(InvoiceUploadRequest $request, OCRService $ocr): View|RedirectResponse
    {
        $viewData = [];

        try {
            $archivo = $request->file('invoice');
            $bytes = $archivo->getContent();
            $nombre = $archivo->getClientOriginalName();

            $viewData['invoiceData'] = $ocr->processInvoice($bytes, $nombre);
        } catch (Exception $e) {
            session()->flash('error', __('admin_invoice.flash_process_error', ['error' => $e->getMessage()]));

            return redirect()->back();
        }

        return view('admin.invoice.index')->with('viewData', $viewData);
    }
}
