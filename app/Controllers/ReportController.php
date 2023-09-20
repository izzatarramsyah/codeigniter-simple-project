<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\UserModel;
use App\Models\ProductModel;
use App\Models\ProductHistoryModel;
use App\Models\InventoryModel;
use App\Models\SellModel;
use App\Models\SellDetailModel;
use Dompdf\Dompdf;

class ReportController extends BaseController 
{
    public function index() {
        $data['pageTitle'] = 'Report Transaction';
        $data['menu'] = 'reportTransaction';
        $session = session();
        if ($session->has('dataUser')) {
            $data['dataUser'] = array_values(session('dataUser'));
            $data["profileMenu"] = array_values(session("profileMenu"));
            $data["dashboard"] = array_values(session("dashboard"));
            return view('view_menu/view_report', $data);
        }
    }

    public function exportTransaction(){
        $startDate = $this->request->getPost('temp-start-date');
        $endDate = $this->request->getPost('temp-end-date');
        $trxType = $this->request->getPost('temp-transaction-type');
        $session = session();
        $dataUser = array_values(session('dataUser'));
        $filename;
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        $dompdf = new Dompdf();
        if ( $trxType == 'order' ) {
            $filename = 'Report Order Product' . date('y-m-d-H-i-s');
            $data['report_name'] = 'Report Order Product';
            $orderModel = new OrderModel();
            $data['data'] = $orderModel->getAllOrderDetail($startDate, $endDate);
            $dompdf->loadHtml(view('view_printout/pdf_view_order', $data));
        }
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream($filename);
    }
    
}