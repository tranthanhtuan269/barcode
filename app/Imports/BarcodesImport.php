<?php

namespace App\Imports;

use App\Models\BarCode;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class BarcodesImport implements ToModel, WithHeadingRow
{

    use Importable;
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $find = BarCode::where('barcode', $row['barcode'])->first();
        if($find){

        }else{
            return new BarCode([
            'ordinal_number'     => $row['ordinal_number'],
            'barcode'            => $row['barcode'],
            'name'               => $row['name'],
            'model'              => $row['model'],
            'manufacturer'       => $row['manufacturer'],
            'avg_price'          => $row['average_price'],
            'currency_unit'      => $row['currency_unit'],
            'specification'      => $row['specification'],
            'feature'            => $row['feature'],
            'description'        => $row['description'],
            'image'              => $row['image'],
            'user_id'            => 1,
            'created_at'         => date("Y-m-d H:i:s"),
            'updated_at'         => date("Y-m-d H:i:s")
            ]);
        }
    }
}