<?php
namespace App\Http\Transformer\Newsletter;

use App\Models\Newsletter;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class NewsletterTransformer extends TransformerAbstract
{
    public function transform(Newsletter $newsletter)
    {
        return [
            'email' => $newsletter->email,
        ];
    }
}