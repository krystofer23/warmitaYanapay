<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class DataExport implements FromView
{
    protected $datag;

    // /**
    // * @return \Illuminate\Support\Collection
    // */

    public function __construct($data) {
        $this->datag = $data;
    } 

    public function view(): View
    {
        return view('EviView', [
            'data' => $this->datag
        ]);
    }
}
