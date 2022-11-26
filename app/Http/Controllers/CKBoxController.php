<?php
namespace App\Http\Controllers;
use Firebase\JWT\JWT;

class CKBoxController extends BaseController 
{
    public function getJWT() {
        $accessKey = 'w1lnWEN63FPKxBNmxHN7WpfW2IoYVYca5moqIUKfWesL1Ykwv34iR5xwfWLy';
        $environmentId = 'LJRQ1bju55p6a47RwadH';
        $payload = array(
            'aud' => $environmentId,
            'iat' => time(),
            'sub' => 'user-123',
            'user' => array(
                'email' => auth()->user()->email ?? null,
                'name' => auth()->user()->name ?? null
            ),
            'auth' => array(
                'collaboration' => array(
                    '*' => array(
                        'role' => 'writer',
                    )
                )
            )
        );
        
        $jwt = JWT::encode($payload, $accessKey, 'HS256');
        
        return response()->json($jwt, 200);
    }
}