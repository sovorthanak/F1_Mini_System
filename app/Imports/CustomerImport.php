<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $customer = Customer::where('accountname', $row['accountname'])->first();

            if($customer){

                $customer->update([
                   'customername' => $row['customername'],
                    'accountname' => $row['accountname'],
                    'status' => $row['status'],
                    'type' => $row['type'],
                    'accountid' => $row['accountid'],
                    'tariff' => $row['tariff'],
                    'agent' => $row['agent'],
                ]);

            }else{
                Customer::create([
                    'customername' => $row['customername'],
                    'accountname' => $row['accountname'],
                    'status' => $row['status'],
                    'type' => $row['type'],
                    'accountid' => $row['accountid'],
                    'tariff' => $row['tariff'],
                    'agent' => $row['agent'],

                ]);
            }
            // Perform validation or data manipulation if needed

        }
    }
}
