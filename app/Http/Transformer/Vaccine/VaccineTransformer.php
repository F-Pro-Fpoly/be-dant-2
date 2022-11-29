<?php
namespace App\Http\Transformer\Vaccine;

use App\Models\Sick;
use App\Models\Vaccine;
use App\Models\Vaccine_category;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class VaccineTransformer extends TransformerAbstract
{
    public function transform(Vaccine $vaccine)
    {

        $sick_ids = json_decode($vaccine->sick_ids);
        $sick_ids_arr = [];

        foreach($sick_ids as $sick_id) {
            $sick_name = Sick::where('id', $sick_id)->value('name');
            $sick_ids_arr [] = [
                'id' => $sick_id,
                'name' => $sick_name
            ];
        }

        $category_ids = json_decode($vaccine->category_ids);
        $category_ids_arr = [];

        foreach ($category_ids as $category_id) {
            $category_name = Vaccine_category::where('id', $category_id)->value('name');
            $category_ids_arr [] = [
                'id' => $category_id,
                'name' => $category_name
            ];
        }

        return [
            'id'   => $vaccine->id,
            'code' => $vaccine->code,
            'name' => $vaccine->name,
            'slug' => $vaccine->slug,
            'price' => $vaccine->price,
            'description' => $vaccine->description,
            'sick_id' => $vaccine->sick_id,
            'national_id' => $vaccine->national_id,
            'sick' => $sick_ids_arr,
            'category' => $category_ids_arr,
            'is_active' => $vaccine->is_active,
            'img_id' => $vaccine->img_id,
            'img_link' => $vaccine->file->url ? env('APP_URL', null)."{$vaccine->file->url}" : null,
            'national_name' => $vaccine->national->name,
            'sick_ids' => $sick_ids,
            'category_ids' => $category_ids
        ];
    }
}