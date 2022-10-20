<?php

namespace App\Http\Controllers;

use App\Http\Transformer\page\PageTransformer;
use App\Http\Validators\Page\InsertPageValidate;
use App\Http\Validators\page\UpdatePageValidate as PageUpdatePageValidate;
use App\Http\Validators\Specialist\UpdatePageValidate;
use App\Models\page;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PageController extends BaseController
{
      // add
      public function addPage(Request $request){
       
        $input = $request->all();
        (new InsertPageValidate($input));

        try{
            page::create([
                'name' => $input['name'],
                'slug' => Str::slug($input['name']),
                'font' => $input['font'],
                'status' => $input['status'],
                'sort' => $input['sort'],
                "created_by" => auth()->user()->id
            ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Thêm trang thành công",
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
    // select all
    public function listPage(Request $request){
        $input = $request->all();
        $page = new page();
        $data = $page->searchPage($input);
        return $this->response->paginator($data, new PageTransformer);            
    }
     // select one
    public function pageDetail($id){
        try {
            $page =  page::findOrFail($id);              
            return $this->response->item($page, new PageTransformer); 
          
        } catch (\Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }
    // update
    public function updatePage(Request $request, $id){
        $input = $request->all();
        (new PageUpdatePageValidate($input));
       try {
            $data = page::findOrFail($id);
                $data->update([
                    'name'  => $input['name'] ??  $data->name,
                    'slug'  => Str::slug($input['name']),
                    "font"  => Arr::get($input, 'font', $data->font),
                    "sort"  =>  Arr::get($input, 'sort', $data->sort), 
                    'updated_by' => auth()->user()->id
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Cập nhật trang thành công"
               ], 200);        
       } 
       catch (\Exception $th) {
        throw new HttpException(500, $th->getMessage());
    }
    }
    // delete
    public function deletePage($id){
        try {
            $data = page::findOrFail($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa trang thành công"
        ], 200);
        } 
        catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
