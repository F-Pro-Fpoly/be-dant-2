<?php
namespace App\Http\Transformer\Contact;

use App\Models\Contact;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class ContactTransformer extends TransformerAbstract
{
    public function transform(Contact $Contact)
    {
        return [
            'id'   => $Contact->id,
            'name' => $Contact->name,
            'email' => $Contact->email,
            'content' => $Contact->contents,
            'type' => $Contact->type,

        ];
    }
}