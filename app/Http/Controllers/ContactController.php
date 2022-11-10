<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Contact\ContactTransformer;
use App\Models\Contact;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ContactController extends BaseController
{
    //add
    public function addContact(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'contents' => 'required',
        
        ],[
            'name.required' => 'Tên không được bỏ trống', 
            'email.required' => 'Email không được bỏ trống',
            'contents.required' => 'Nội dung không được bỏ trống', 
          
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
