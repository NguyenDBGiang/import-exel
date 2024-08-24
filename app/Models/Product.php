<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_short_name',
        'product_id_name',
        'product_name',
        'calculation_unit_1',
        'calculation_unit_2',
        'calculation_unit_3',
        'unit_factor_1',
        'unit_factor_2',
        'product_import_price',
        'product_sale_price',
        'product_min_sale_price',
        'product_max_sale_price',
        'product_declared_price',
        'product_specific_cost_import_price',
        'product_list_price',
        'product_specific_cost',
        'product_hapu_price',
        'hapu_updated_at',
        'number_dkcl',
        'specifications',
        'place_code',
        'place',
        'location',
        'product_type',
        'classify',
        'product_group',
    ];
}
