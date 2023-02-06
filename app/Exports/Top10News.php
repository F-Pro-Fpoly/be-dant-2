<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Top10News implements FromView
{
    protected $_data;
    protected $_from;
    protected $_to;
    protected $_title;



    /**
     * OrderDetailExport constructor.
     */
    public function __construct($data, $from, $to,$title)
    {
        $this->_data = $data;
        $this->_from = $from;
        $this->_to = $to;
        $this->_title = $title;


    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view("exports.Top10News", [
            'data' => $this->_data,
            'from' => $this->_from,
            'to' => $this->_to,
            'title' => $this->_title,


        ]);
    }
}