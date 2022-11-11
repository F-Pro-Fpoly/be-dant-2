<?php

namespace App\Http\Controllers;

use App\Http\Transformer\News\NewsTransformer;
use App\Http\Validators\News\InsertNewsValidate;
use App\Http\Validators\News\UpdateNewsValidate;
use App\Models\News;
use App\Http\Transformer\News_category\News_categoryTransformer;
use App\Models\News_category;
use App\Models\File;
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
            }
           News::create([
                'code' => $input['code'],
                'slug' => $input['slug'],
                'featured' => $input['featured'],
                'status' => $input['status'],
                'category_id' => $input['category_id'],
                'name' => $input['name'],
                'file' => 'images'.$input['file'],
                'content' => $input['content'],
                'views' => 0,
                'created_by' => auth()->user()->id
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

    public function listNews_all(Request $request){
        $data = News::where('status', 1)->get();
        return response()->json([
                'status' => 200,
                'data' => $data
        ],200);
    }

    public function listNews_category(Request $request){
        $input = $request->all();
        $News_category = new News_category();
        $data = $News_category->searchNews_category($input);
        return $this->response->paginator($data, new News_categoryTransformer);
    }

    public function listNews_category_all(Request $request){
        $data = News_category::where('status', 1)->get();
        return response()->json([
                'status' => 200,
                'data' => $data
            ],200);
    }

    function getNews_ID($id){
        $data = News::find($id);
        if($data){
            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => "Lấy một tin thành công"
           ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Không tìm thấy tin này"
           ], 400);
        }
    }

    public function updateNews(Request $request, $id){
       $input = $request->all();
       (new UpdateNewsValidate($input));

        try {
            // if(!empty($input['file'])) {
            //     $file = $request->file('file')->store('images','public');
            // }

            $data = News::find($id);
            if($input['file'] === $data->file){
                $input['file'] = $data->file;
            }
            if($data){
                $data->update([
                    'slug' => $input['slug'],
                    'featured' => $input['featured'],
                    'status' => $input['status'],
                    'category_id' => $input['category_id'],
                    'name' => $input['name'],
                    'file' => 'images'.$input['file'],
                    'content' => $input['content'],
                    'updated_by' => auth()->user()->id
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

    // dùng cho client
    function getNewsID($id){
        $data = News::where('slug',$id)->where('status', 1)->first();
        if($data){
            $data->update([
                'view' => $data->view + 1,
            ]);
            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => "Lấy một tin thành công"
           ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Không tìm thấy tin này"
           ], 400);
        }
    }

    function getNews_featured(){
        $data = News::where('status', 1)->where('featured', 1)->limit(3)->get();
        if($data){
            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => "Lấy 3 tin nổi bật thành công"
           ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Không tìm thấy tin nỗi bật này"
           ], 400);
        }
    }

    function getNews_new(){
        $data = News::where('status', 1)->orderBy('created_at', 'DESC')->limit(9)->get();
        if($data){
            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => "Lấy 3 tin nổi bật thành công"
           ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Không tìm thấy tin nỗi bật này"
           ], 400);
        }
    }
}
