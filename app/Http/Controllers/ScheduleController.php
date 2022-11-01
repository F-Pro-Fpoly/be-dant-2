<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Schedule\ScheduleDetailTransformer;
use App\Models\Schedule;
use AWS\CRT\HTTP\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Transformer\Schedule\ScheduleTransformer;
use App\Http\Transformer\TimeSlot\TimeSlotTransformer;
use App\Http\Validators\Schedule\CreateScheduleValidate;
use App\Http\Validators\TimeslotDetail\CreateTimeSlotDetailValidate;
use App\Models\Timeslot;
use App\Models\timeslotDetail;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

class ScheduleController extends BaseController
{
    public function listSchedule(Request $request) {
        $input = $request->all();
        try {
            if(auth()->user()->role_id == 2) {
                $input['created_by'] = auth()->user()->id;
            }
            $schedule = (new Schedule())->searchSchedule($input);
            // return $schedule;
            // dd($schedule);
            return $this->response->collection($schedule, new ScheduleTransformer());
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function createSchedule(Request $request) {
        $input = $request -> all();
        (new CreateScheduleValidate($input));

        $user_created = auth()->user()->id;
        try {
            if(is_array($input['timeslot_id'])) {
                foreach($input['timeslot_id'] as $index => $item) {
                    $date_time = date("YmdHis", time());
                    $code = "LICH{$date_time}".rand(0, 1000);
                    Schedule::create([
                        'code' => $code,
                        'date' => $input['date'],
                        'timeslot_id' => $item,
                        'status_id' => 6,
                        'status_code' => "STILLEMPTY",
                        'description' => null,
                        'doctor_id' => $user_created,
                        'created_by' => $user_created
                    ]);
                }
            }

            return response()->json([
                'message' => "Thêm lịch thành công"
            ], 200);
            
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function getTimeslot(Request $request) {
        $input = $request -> all();
        try {
            $timeslot = (new Timeslot())->searchTimeSlot($input);

            return $this->response->collection($timeslot, new TimeSlotTransformer());
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

}
