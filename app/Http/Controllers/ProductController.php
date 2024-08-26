<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\FileUpload;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Log;
use App\Jobs\CreateProductExel;

class ProductController extends Controller
{
        
    /**
     * import Product
     *
     * @param  mixed $request
     * @return void
     */
    public function import(Request $request)
    {
        $file = $request->file('fileImport');
        if(!$file) return response('Không tìm thấy file', 400);
        try {
            $uploadOptions = array(
                'file_extension' => array('xls', 'xlsx')
            );
            $fileUpload = FileUpload::doUpload($file, $uploadOptions);

            if ($fileUpload['success']) {
                Excel::import(new ProductsImport(), $file );
            } else {
                
            }
        } catch (\Exception $ex){
            Log::error($ex);
        }

        return redirect()->route('welcome');
    }


    public function importAry(Request $request)
    {
        try {
            $arrData = array();
            if ($request->data) {
                Log::info(count($request->data));
                foreach ($request->data as $row) {
                    if (!empty(array_filter($row))) {
                        $newData = [];
                        $newData['product_short_name'] = $row['Tên tắt'] ?? "";
                        $newData['product_id_name'] = $row['ID'] ?? "";
                        $newData['product_name'] = $row['Tên hàng'] ?? "";
                        $newData['calculation_unit_1'] = $row['ĐV Tinh1'] ?? "";
                        $newData['calculation_unit_2'] = $row['ĐV Tính 2'] ?? "";
                        $newData['calculation_unit_3'] = $row['ĐV Tính 3'] ?? "";
                        $newData['unit_factor_1'] = $row['Hệ số 1'] ?? null;
                        $newData['unit_factor_2'] = $row['Hệ số 2'] ?? null;
                        $newData['product_import_price'] = $row['Giá Nhập'] ?? 0;
                        $newData['product_sale_price'] = $row['Giá bán'] ?? 0;
                        $newData['product_min_sale_price'] = $row['Giá bán tối thiểu'] ?? 0;
                        $newData['product_max_sale_price'] = $row['Giá bán tối đa'] ?? 0;
                        $newData['product_declared_price'] = $row['Giá kê khai'] ?? 0;
                        $newData['product_specific_cost_import_price'] = $row['Giá nhập giá vốn'] ?? 0;
                        $newData['product_list_price'] = $row['Giá niêm yết'] ?? 0;
                        $newData['product_specific_cost'] = $row['Giá vốn đích danh'] ?? 0;
                        $newData['product_hapu_price'] = $row['Giá Hapu'] ?? 0;
                        $newData['hapu_updated_at'] = isset($row['Ngày cập nhật Giá Hapu']) ? date("Y-m-d", strtotime($row['Ngày cập nhật Giá Hapu']))  : null;
                        $newData['number_dkcl'] = $row['Số ĐKCL'] ?? "";
                        $newData['specifications'] = $row['Quy cách'] ?? "";
                        $newData['place_code'] = $row['Mã nơi để'] ?? "";
                        $newData['place'] = $row['Nơi để'] ?? "";
                        $newData['location'] = $row['Vị trí'] ?? "";
                        $newData['product_type'] = $row['Loại hàng'] ?? "";
                        $newData['classify'] = $row['Phân loại'] ?? "";
                        $newData['product_group'] = $row['Nhóm hàng'] ?? "";

                        $arrData[] = $newData;
                    }
                }
                Log::error(count($arrData));
                CreateProductExel::dispatch($arrData)->onQueue('createProductExel');
            }
        } catch (\Exception $ex){
            Log::error($ex);
            return response()->json(['status_code' => 400]);
        }

        return response()->json(['status_code' => 200]);
    }
}
