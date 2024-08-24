<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_short_name', 50)
                ->comment('Tên tắt hàng');
            $table->char('product_id_name', 50)
                ->comment('Mã ID định danh hàng');
            $table->string('product_name', 255)
                ->comment('Tên thực hàng');

            $table->string('calculation_unit_1', 255)->nullable()
                ->comment('Đơn vị tính 1');
            $table->string('calculation_unit_2', 255)->nullable()
                ->comment('Đơn vị tính 2');
            $table->string('calculation_unit_3', 255)->nullable()
                ->comment('Đơn vị tính 3');
            $table->double('unit_factor_1')->nullable()
                ->comment('Hệ số 1');
            $table->double('unit_factor_2')->nullable()
                ->comment('Hệ số 2');

            $table->double('product_import_price')->default(0)
                ->comment('Giá Nhập');
            $table->double('product_sale_price')->default(0)
                ->comment('Giá bán');
            $table->double('product_min_sale_price')->default(0)
                ->comment('Giá bán tối thiểu');
            $table->double('product_max_sale_price')->default(0)
                ->comment('Giá bán tối đa');
            $table->double('product_declared_price')->default(0)
                ->comment('Giá kê khai');
            $table->double('product_specific_cost_import_price')->default(0)
                ->comment('Giá nhập giá vốn');
            $table->double('product_list_price')->default(0)
                ->comment('Giá niêm yết');
            $table->double('product_specific_cost')->default(0)
                ->comment('Giá vốn đích danh');

            $table->double('product_hapu_price')->default(0)
                ->comment('Giá Hapu');
            $table->date('hapu_updated_at')->nullable()
                ->comment('Ngày cập nhật Giá Hapu');

            $table->string('number_dkcl', 255)->nullable()
                ->comment('Số ĐKCL');
            $table->string('specifications', 255)->nullable()
                ->comment('Quy cách');
            $table->char('place_code', 50)->nullable()
                ->comment('Mã nơi để');
            $table->string('place', 255)->nullable()
                ->comment('Nơi để');
            $table->string('location', 255)->nullable()
                ->comment('Vị trí');
            $table->string('product_type', 255)->nullable()
                ->comment('Loại hàng');
            $table->string('classify', 255)->nullable()
                ->comment('Phân loại');
            $table->string('product_group', 255)->nullable()
                ->comment('Phân loại');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
