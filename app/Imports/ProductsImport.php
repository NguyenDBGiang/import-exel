<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Jobs\CreateProductExel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProductsImport implements ToCollection, WithHeadingRow
{
    use Importable;

    function __construct() 
    {

    }

    public function headingRow(): int
    {
        return 1;
    }

    public function collection(Collection $rows)
    {
        $arrData = array();
        $countRows = 1;
        if (count($rows->toArray()) > 0) {
            foreach ($rows->toArray() as $row) {
                if (!empty(array_filter($row))) {
                    $newData = [];
                    $newData['product_short_name'] = $row['ten_tat'];
                    $newData['product_id_name'] = $row['id'];
                    $newData['product_name'] = $row['ten_hang'];
                    $newData['calculation_unit_1'] = $row['dv_tinh1'];
                    $newData['calculation_unit_2'] = $row['dv_tinh_2'];
                    $newData['calculation_unit_3'] = $row['dv_tinh_3'];
                    $newData['unit_factor_1'] = $row['he_so_1'];
                    $newData['unit_factor_2'] = $row['he_so_2'];
                    $newData['product_import_price'] = $row['gia_nhap'];
                    $newData['product_sale_price'] = $row['gia_ban'];
                    $newData['product_min_sale_price'] = $row['gia_ban_toi_thieu'];
                    $newData['product_max_sale_price'] = $row['gia_ban_toi_da'];
                    $newData['product_declared_price'] = $row['gia_ke_khai'];
                    $newData['product_specific_cost_import_price'] = $row['gia_nhap_gia_von'];
                    $newData['product_list_price'] = $row['gia_niem_yet'];
                    $newData['product_specific_cost'] = $row['gia_von_dich_danh'];
                    $newData['product_hapu_price'] = $row['gia_hapu'];
                    $newData['hapu_updated_at'] = $row['ngay_cap_nhat_gia_hapu'] ? Date::excelToDateTimeObject($row['ngay_cap_nhat_gia_hapu']) : null;
                    $newData['number_dkcl'] = $row['so_dkcl'];
                    $newData['specifications'] = $row['quy_cach'];
                    $newData['place_code'] = $row['ma_noi_de'];
                    $newData['place'] = $row['noi_de'];
                    $newData['location'] = $row['vi_tri'];
                    $newData['product_type'] = $row['loai_hang'];
                    $newData['classify'] = $row['phan_loai'];
                    $newData['product_group'] = $row['nhom_hang'];

                    $arrData[] = $newData;
                    $countRows ++;
                    if ($countRows >= 1000) {
                        CreateProductExel::dispatch($arrData)->onQueue('createProductExel');
                        $arrData = array();
                        $countRows = 1;
                    }
                }
            }
            CreateProductExel::dispatch($arrData)->onQueue('createProductExel');
        }
    }
}