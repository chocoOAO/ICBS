<?php

namespace App\Http\Controllers;
use App\Models\Contract;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Livewire\Settlement;
class PDFController extends Controller
{
    public function exportPDF(Request $request)
    {
        $data = $request->all();
        $data2 = session('exportData');
        $dompdf = new Dompdf();
        if ($data['type'] == 'chicken-out') {
            $view = View::make('pdf.chicken-out-pdf', compact('data'));
        } else if ($data['type'] == 'traceability') {
            $view = View::make('pdf.traceability-pdf', compact('data'));
        } else if ($data['type'] == 'settlement') {
            $view = View::make('pdf.settlement-pdf', compact('data2'));
        } else if ($data['type'] == 'contract') {
            if (Contract::where('id', $data['contract'])->get()->toArray()[0]['type'] == 1) {
                $view = View::make('pdf.contract.contract-type-1-pdf', compact('data'));
            } else if (Contract::where('id', $data['contract'])->get()->toArray()[0]['type'] == 2) {
                $view = View::make('pdf.contract.contract-type-2-pdf', compact('data'));
            } else if (Contract::where('id', $data['contract'])->get()->toArray()[0]['type'] == 3) {
                $view = View::make('pdf.contract.contract-type-3-pdf', compact('data'));
            }
        }
        
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A3', 'landscape');
        //設定可以顯示中文
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->set_option('defaultFont', 'font5');
        $dompdf->render();
        // Attachment: 0 直接顯示, 1 強制下載
        $dompdf->stream("test.pdf", ['Attachment' => 0]);
        //$dompdf->stream();
        //$data['inputs'][0]['created_at']
    }
}
