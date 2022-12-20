<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Contact\ContactTransformer;
use App\Http\Validators\Contact\UpdateContactValidate;
use App\Mail\OrderShipped;
use App\Models\Contact;
use App\Supports\TM_Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Mail\ContactMail;

class ContactController extends BaseController
{
    //add
    public function addContact(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'contents' => 'required',
            'phone' => 'required',
        
        ],[
            'name.required' => 'Tên không được bỏ trống', 
            'email.required' => 'Email không được bỏ trống',
            'contents.required' => 'Nội dung không được bỏ trống', 
            'phone.required' => 'Số điện thoại không được bỏ trống', 
          
        ]);
        
        if($validator->fails()){
            return response()->json(
                [
                    'status' => 400,
                    'message' => $validator->errors(),           
                ],400
            );
        }

        try{
            $contact = Contact::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'contents'  => $request->contents,
                'phone'     => $request->phone,
                'type'      => $request->type, 
                'id_contact_firebase'      => $request->id_contact_firebase, 
            ]);

            
              // bắn  thông báo firebase

            //   $fields  = [      
            //     'id' =>  mt_rand(100000,999999),
            //     'notification' => "Có một liên hệ mới",   
            //     "content"  => $request->contents,
            //     "user_name" => $request->name
            // ];
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL =>  env('FIREBASE_DBR_URL', ''),
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS =>json_encode($fields),
            //     CURLOPT_HTTPHEADER => array(
            //     'Content-Type: application/json'
            //     ),
            // ));
            
            // $response = curl_exec($curl);
            
            // curl_close($curl);

            return response()->json([
                'status' => 200,
                'message' => "Liên hệ đã gửi thành công",
            ], 200);
                
        } catch(\Throwable $th){
            return response()->json(
                [
                    'status' => 500,
                    'message' => $th->getMessage() ,
                    'line' => $th->getLine()
                ],500
            );
        }
       
    }

    public function deleteContact($id){
        try {
            $data = Contact::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa liên hệ thành công"
        ], 200);
        } 
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    public function listContact(Request $request){

        $input = $request->all();
        try {
            $Contact = new Contact();
            $data = $Contact->searchContact($input); 
            return $this->response->paginator($data, new ContactTransformer);            
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage()) ;
        }
    }

    public function listcontact_ID($id){
        try {
            $contact = Contact::findOrFail($id);
            return $this->response->item($contact, new contactTransformer());
        } catch (\Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }    
    }
  
    public function replyContact(Request $request, $id){
        $input = $request->all();

        try {

            $contact = Contact::findOrFail($id);
            $contact->reply_contact = $input['reply_contact'];
            $contact->status_id = 8;
            $contact->save();
            
            $e = $contact->email;
            Mail::send('email.contactEmail',compact('contact'), function ($email) use ($e) {
                $email->from('phuly4795@gmail.com','Fpro Hopital');
                $email->subject('Fpro Hopital - Trả lời liên hệ');
                $email->to($e, 'Quý khách');
            });


            return response()->json([
                "message" => "Trả lời thành công"
            ], 200);
            
        } catch (\Exception $th) {
            $res = new TM_Error($th);
            return $this->response->error($res->getMessage(), $res->getStatusCode());
        }
    }
    
}
