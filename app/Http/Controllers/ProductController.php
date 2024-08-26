<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\FileUpload;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Log;

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
            Log::error($e);
        }

        return redirect()->route('welcome');
    }
}
