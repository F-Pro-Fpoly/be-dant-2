<?php
namespace App\Http\Transformer\VaccineCategory;

use App\Models\Vaccine_category;
use League\Fractal\TransformerAbstract;

class VaccineCategoryTransformer extends TransformerAbstract
{
    public function transform(Vaccine_category $vaccine_category)
    {
        return [
            'id' => $vaccine_category->id,
            'name' => $vaccine_category->name,
            'code' => $vaccine_category->code,
            'slug' => $vaccine_category->slug,
            // 'page_id' => $vaccine_category->total(),
            'parent_id' => $vaccine_category->parent_id ?? null,
            'parent_name' => $vaccine_category->parent->name ?? null,
            'description' => $vaccine_category->description,
            'short_description' => $vaccine_category->short_description,
            'active' => $vaccine_category->active,
        ];
    }
}