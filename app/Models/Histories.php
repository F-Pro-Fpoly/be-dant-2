<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Histories extends Model
{
    protected $table = 'histories';
    protected $fillable = ['file', 'date_examination', 'description', 'doctor_id', 'patient_id'];

    public function searchHistories($input = []){
        $dataInput =[];
        if(!empty($input['file'])){
            $dataInput[] = [
                'file' , "like", "%".$input['file']."%"
            ];
        }
        if(!empty($input['date_examination'])){
            $dataInput[] = [
                'date_examination' , "like", "%".$input['date_examination']."%"
            ];
        }
        if(!empty($input['description'])){
            $dataInput[] = [
                'description' , "=",$input['description']
            ];
        }
        if(!empty($input['doctor_id'])){
            $dataInput[] = [
                'doctor_id' , "=",$input['doctor_id']
            ];
        }
        if(!empty($input['patient_id'])){
            $dataInput[] = [
                'patient_id' , "=",$input['patient_id']
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }
}
