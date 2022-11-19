<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Contact\ContactTransformer;
use App\Http\Validators\Contact\UpdateContactValidate;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
            'contents.required' => 'Số điện th không được bỏ trống', 
          
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
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Thêm contact thành công",
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
                'message' => "Xóa Contacts thành công"
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
  
    public function updateContact(Request $request, $id){
        $input = $request->all();
        (new UpdateContactValidate($input));
        try {
            $contact = Contact::findOrFail($id);
            $contact->updateContact($input);

            return response()->json([
                "message" => "cập nhập thành công"
            ], 200);
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
