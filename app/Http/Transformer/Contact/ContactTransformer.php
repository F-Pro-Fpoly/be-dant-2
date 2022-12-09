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
            'reply_contact' => $Contact->reply_contact ?? null, 
            'type' => $Contact->type,
            'phone' => $Contact->phone,
            'status_id' => $Contact->status_id,
            'status' => $Contact->status->name,
            'created_at' => date_format($Contact->created_at, "Y/m/d")
        ];  
    }
}