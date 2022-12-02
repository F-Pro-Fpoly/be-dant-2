<?php

namespace App\Http\Controllers;

use App\Exports\Turnover;
use App\Models\Booking;
use App\Models\Department;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ReportController extends Controller
{
   public function turnover(Request $request)
   {

      $input = $request->all();
    
      $date  = date('YmdHis', time());
        try {
           
            $data = Booking::select('specialists.name as specialists_name',Department::raw('SUM(departments.price) as price'))
            ->join('departments', 'departments.id', 'bookings.department_id')
            ->join('specialists', 'specialists.id', 'departments.specialist_id')
            ->groupBy('specialists.name')
            ->where('bookings.status_id', 4)
            ->get();            
            
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }



    return Excel::download(new Turnover($data), 'turnover_' . $date . '.xlsx');
   }
}
