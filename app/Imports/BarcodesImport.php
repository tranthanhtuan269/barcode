<?php

namespace App\Imports;

use App\Models\Barcode;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class BarcodesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $find = Barcode::where('barcode', $row[1])->first();
        if($find){

        }else{
            return new Barcode([
            'ordinal_number'     => $row[0],
            'barcode'            => $row[1],
            'name'               => $row[2],
            'model'              => $row[3],
            'manufacturer'       => $row[4],
            'avg_price'          => $row[5],
            'currency_unit'      => $row[6],
            'specification'      => $row[7],
            'feature'            => $row[8],
            'description'        => $row[9],
            'image'              => $row[10],
            'user_id'            => 1,
            'created_at'         => date("Y-m-d H:i:s"),
            'updated_at'         => date("Y-m-d H:i:s")
            ]);
        }
    }
}