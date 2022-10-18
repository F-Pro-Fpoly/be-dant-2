<?php
namespace App\Http\Transformer\Histories;

use App\Models\Histories;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class HistoriesTransformer extends TransformerAbstract
{
    public function transform(Histories $histories)
    {
        return [
            "id" => $histories->id,
            'file'=> $histories->file,
            'date_examination' => $histories->date_examination,
            'description' => $histories->description,
            'doctor_id' => $histories->doctor_id,
            'patient_id' => $histories->patient_id,
        ];
    }
}