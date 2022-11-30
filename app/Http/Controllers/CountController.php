<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Department;
use App\Models\File;
use App\Models\Histories;
use App\Models\National;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Sick;
use App\Models\Specialist;
use App\Models\status;
use App\Models\Timeslot;
use App\Models\User;
use App\Models\Vaccine;
use App\Models\News;
use App\Models\Contact;
use App\Models\News_category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\Request;
use App\Http\Transformer\Booking\BookingDPTransformer;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CountController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function count(){
            $count = User::count();
            $booking = Booking::count();
            $department = Department::count();
            $file = File::count();
            $historie = Histories::count();
            // $migration= Migrations
            $national = National::count();
            // $page = Pages
            $role = Role::count();
            $schedule = Schedule::count();
            $sick = Sick::count();
            $specialist = Specialist::count();
            $status = status::count();
            $timeslot = Timeslot::count();
            $vaccine = Vaccine::count();
            $contact = Contact::where('status_id', 1)->count();
            $news = News::count();
            $newsCategory = News_category::count();
            try{
                    return response()->json([
                        'data' => [
                            'user-count' => $count,
                            'booking-count' => $booking,
                            'Department-count' => $department,
                            'file-count' => $file,
                            'historie-count' => $historie,
                            'national-count' => $national,
                            'roles-count' => $role,
                            'schedule-count' => $schedule,
                            'sick-count' => $sick,
                            'specialist-count' => $specialist,
                            'status-count' => $status,
                            'timeslot-count' => $timeslot,
                            'vaccine-count' => $vaccine,
                            'contact-count' => $contact,
                            'News-count' => $news,
                            'NewsCategory-count' => $newsCategory
                        ]
                    ]);
            } catch(\Throwable $th){
                return response()->json([
                    'message' => "Lỗi phía server",
                    'data' => $th->getMessage()
                ],400);
            }

        }
        function getStatistic() {
            try{
                $User = User::all()->count();
                $priceBookingInDepartment = Booking::join('departments', 'departments.id', 'bookings.department_id')->sum('departments.price');
                $Booking = Booking::all()->count();
    
                $Contact = Contact::all()->count();
                $noReplyContact = Contact::where('status_id', 9)->count();
    
                return response()->json([
                    'status' => 200,
                    'data' => [
                        'user' => $User,
                        'priceBooking' => $priceBookingInDepartment,
                        'priceBooking_format' => number_format($priceBookingInDepartment)." VNĐ",
                        'booking' => $Booking,
                        'contact' => $Contact,
                        'noReplyContact' => $noReplyContact,   
                    ]
                ], 200);
            }
            catch(\Exception $th){
                $errors = $th->getMessage();
                throw new HttpException(500, $errors);
            }
            
        }
        function getStatisticChart() {
            try{
                $priceSpecialist = Booking::select('specialists.name as specialists_name',Department::raw('SUM(departments.price) as price'))
                                        ->join('departments', 'departments.id', 'bookings.department_id')
                                        ->join('specialists', 'specialists.id', 'departments.specialist_id')
                                        ->groupBy('specialists.name')
                                        ->where('bookings.status_id', 4)
                                        ->get();            
                return $this->response->collection($priceSpecialist, new BookingDPTransformer());
            }
            catch(\Exception $th){
                $errors = $th->getMessage();
                throw new HttpException(500, $errors);
            }       
        }       
}
