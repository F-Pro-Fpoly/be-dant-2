<?php

namespace App\Http\Controllers;

use App\Http\Transformer\News\NewsTransformer;
use App\Http\Validators\News\InsertNewsValidate;
use App\Http\Validators\News\UpdateNewsValidate;
use App\Models\News;
use App\Http\Transformer\News_category\News_categoryTransformer;
use App\Models\File;
use App\Models\News_category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NewsController extends BaseController
{
   public function addNews(Request $request)
    {
        $input = $request->all();
        (new InsertNewsValidate($input));

        try {
            if(!empty($input['file'])) {
                $file = $request->file('file')->store('images','public');
                $file = File::create([
                    'alt' => $input['alt']??null,
                    'url' => $file,
                    "created_by" => auth()->user()->id,
                ]);
            }

           News::create([
            'code'        =>    $input['code'],
            'slug'        =>    $input['slug'],
            'featured'    =>    $input['featured'],
            'status'      =>    $input['status'] ? 1: 2,
            'category_id' =>    $input['category_id'],
            'name'        =>    $input['name'],
            'content'     =>    $input['content'],
            'view'        =>    $input['view'],


        ]);

           return response()->json([
                'status' => 200,
                'message' => "Thêm tin thành công"
           ], 200);
        } catch (\Throwable $th) {
           return response()->json(
                [
                    'status' => 500,
                    'message' => $th->getMessage() 
                ],500
                );
        }

    }
    public function listNews(Request $request){
        $input = $request->all();
        $News = new News();
        $data = $News->searchNews($input);
        return $this->response->paginator($data, new NewsTransformer);
    }

    public function listNews_category(Request $request){
        $input = $request->all();
        $News_category = new News_category();
        $data = $News_category->searchNews_category($input);
        return $this->response->paginator($data, new News_categoryTransformer);
    }

    public function updateNews(Request $request, $id){
       $input = $request->all();
       (new UpdateNewsValidate($input));

        try {
            $data = News::find($id);
            if($data){
                $data->update([
                    //code chỉnh sửa
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Cập nhật đặt tin thành công"
               ], 200);
            }
            else{
                return response()->json([
                    'status'  => 400,
                    'message' => 'Không tìm thấy tin',
                ],400);
            }
        } 
        catch (Exception $th){
            throw new HttpException(500, $th->getMessage());
        }
    }

    // delete
    public function deleteNews($id){
        try {
            $data = News::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa tin thành công"
            ], 200);
        }
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
