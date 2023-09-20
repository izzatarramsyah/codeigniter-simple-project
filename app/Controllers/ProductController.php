<?php

namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\MstProductModel;
use App\Models\ProductInModel;
use Dompdf\Dompdf;

use \Datetime;

class ProductController extends BaseController  {

    public function index()  {
        $data['pageTitle'] = 'Info Product';
        $data['menu'] = 'listProduct';
        $session = session();
        if ($session->has('dataUser')) {
            $data['dataUser'] = array_values(session('dataUser'));
            $data["profileMenu"] = array_values(session("profileMenu"));
            $data["dashboard"] = array_values(session("dashboard"));
            return view('view_menu/view_product', $data);
        }
    }

    public function getListProduct() {
        $mstProductModel = new MstProductModel();
        return $this->response->setJSON([
            "object" => $mstProductModel->findAll(),
        ]);
    }

    public function getProduct() {
        $mstProductModel = new MstProductModel();
        $productId = $this->request->getPost('productId');
        return $this->response->setJSON([
            "object" => $mstProductModel->getProduct($productId),
        ]);
    }

    public function addProduct() {
        $mstProductModel = new MstProductModel();
        $productInModel = new ProductInModel();
        try {
            $type = $this->request->getPost('slc-add-stock');
            $dataUser = array_values(session("dataUser"));
            if ( $type == 'single' ) {
                $product_code = $this->request->getPost('inp-product-code');
                $product_name= $this->request->getPost('inp-product-name');
                $description = $this->request->getPost('inp-product-desc');
                $product_price = $this->request->getPost('inp-product-price');
                $quantity = $this->request->getPost('inp-product-qty');
                $data = [
                    "product_code" => $product_code,
                    "product_name" => $product_name,
                    "description" => $description,
                    "product_price" => $product_price,
                    "quantity" => $quantity,
                    "created_by" => $dataUser[0]["username"]
                ];
                $mstProductModel->saveProduct($data);
                $productIn = [
                    "product_code" => $product_code,
                    "quantity" => $quantity,
                    "created_by" => $dataUser[0]["username"],
                    "lastupd_by" => $dataUser[0]["username"],
                ];
                $productInModel->saveProductIn($productIn);
                return $this->response->setJSON([
                    "message" => "Success adding new product"
                ]);
            } else {
                $file = $this->request->getFile('file-add-stock');
                $extention = $file->getClientExtension();
                if ( $extention == 'xls' ) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else if ( $extention == 'xlsx' ) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadSheet = $reader->load($file);
                $dataExcel = $spreadSheet->getActiveSheet()->toArray();
                $count = 0;
                foreach($dataExcel as $key => $row) {
                    if ( $key == 0 ) {
                        continue;
                    }
                    $data = [
                        "product_code" => $row[0],
                        "product_name" => $row[1],
                        "description" => $row[2],
                        "product_price" => $row[3],
                        "quantity" => $row[4],
                        "created_by" => $dataUser[0]["username"]
                    ];
                    $mstProductModel->saveProduct($data);
                    $productIn = [
                        "product_code" => $row[0],
                        "quantity" => $row[4],
                        "created_by" => $dataUser[0]["username"],
                        "lastupd_by" => $dataUser[0]["username"],
                    ];
                    $productInModel->saveProductIn($productIn);
                    $count ++;
                }
                return $this->response->setJSON([
                    "message" => "Success adding ". $count ." new product"
                ]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateProduct()  {
        $mstProductModel = new MstProductModel();
        $ProductIn = new ProductIn();
        try {
            $productCode = $this->request->getPost('productCode');
            $productName = $this->request->getPost('productName');
            $productPrice = $this->request->getPost('productPrice');
            $productQty = $this->request->getPost('productQty');
            $productDesc = $this->request->getPost('productDesc');
            $session = session();
            $data = array_values(session('dataUser'));
            if ($mstProductModel->updateProduct($productName, $productDesc, $productPrice, $productQty, $productCode)) {
                return $this->response->setJSON([
                    'message' => 'success update product'
                ]);
            } else {
                return $this->response->setJSON([
                    'message' => 'failed update product'
                ]);
            }
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteProduct()  {
        $productCode = $this->request->getPost('productCode');
        try {
            $mstProductModel = new MstProductModel();
            if (  $mstProductModel->deleteProduct($productCode) ) {
                return $this->response->setJSON([
                    'message' => 'success delete product'
                ]);
            } else {
                return $this->response->setJSON([
                    'message' => 'failed delete product'
                ]);
            }
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}