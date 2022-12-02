<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Test implements FromView
{
    protected $_data;

    /**
     * ExportOrderExport constructor.
     */
    public function __construct($data)
    {
        $this->_data = $data;
    }

    /**
     * @return View
     */
    public function view(): View
    {   
        dd($this->_data);
        return view("exports.test", [
            'data' => $this->_data,
        ]);
    }
}