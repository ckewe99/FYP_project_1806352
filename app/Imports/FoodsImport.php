<?php

namespace App\Imports;

use App\Models\Food;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FoodsImport implements ToModel, WithHeadingRow
{

    protected $date_range_id;

    public function  __construct($date_range_id)
    {
        $this->date_range_id = $date_range_id;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!isset($row['name'])) {
            return null;
        }
        return new Food([
            'name' => $row['name'],
            'price' => $row['price'],
            'stall_id' => $row['stall_id'],
            'dessert' => $row['dessert'],
            'session' => $row['session'],
            'days' => $row['days'],
            'date_range_id' => $this->date_range_id,
            'matrix' => $row['matrix'],
        ]);
    }
}
