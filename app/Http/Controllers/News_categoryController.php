<?php

namespace App\Http\Controllers;

use App\Http\Transformer\News\NewsTransformer;
use App\Http\Validators\News_category\InsertNews_categoryValidate;
use App\Http\Validators\News_category\UpdateNews_categoryValidate;
use App\Models\News;
use App\Http\Transformer\News_category\News_categoryTransformer;
use App\Models\News_category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class News_categoryController extends BaseController
{
   public function addNews_category(Request $request)
    {
        $input = $request->all();
        (new InsertNews_categoryValidate($input));

        try {

           News_category::create([
                //code thêm
                'code' => $input['code'],
                'slug' => $input['slug'],
                'status' => $input['status'],
                'name' => $input['name'],
                'created_by' => auth()->user()->id
           ]);

           return response()->json([
                'status' => 200,
                'message' => "Thêm danh sách tin thành công"
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

    function getNews_categoryID($id){
        dd($id);
        $data = News_category::find($id);

        if($data){
            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => "Lấy một danh sách tin thành công"
           ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Không tìm thấy dnah sách tin này"
           ], 400);
        }
    }

    public function updateNews_category(Request $request, $id){
       $input = $request->all();
       (new UpdateNews_categoryValidate($input));

        try {
            $data = News_category::find($id);
            if($data){
                $data->update([
                    //code chỉnh sửa
                    'code' => $input['code'],
                    'slug' => $input['slug'],
                    'status' => $input['status'],
                    'name' => $input['name'],
                    'updated_by' => auth()->user()->id
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Cập nhật danh sách tin thành công"
               ], 200);
            }
            else{
                return response()->json([
                    'status'  => 400,
                    'message' => 'Không tìm thấy danh sách tin',
                ],400);
            }
        }
        catch (Exception $th){
            throw new HttpException(500, $th->getMessage());
        }
    }

    // delete
    public function deleteNews_category($id){
        try {
            $data = News_category::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa danh sách tin thành công"
            ], 200);
        }
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    // dùng cho client
    public function getNews_category(Request $request){
        $input = $request->all();
        $News_category = new News_category();
        $data = $News_category->searchNews_category($input);
        return $this->response->paginator($data, new News_categoryTransformer);
    }

    public function getNews(Request $request){
        $input = $request->all();
        $News = new News();
        $data = $News->searchNews($input);
        return $this->response->paginator($data, new NewsTransformer);
    }

    public function getNewsInCategory($id){
        if($id)
            try {
                $data = News::where('category_id', $id)->where('status', 1)->get();
                return response()->json([
                    'status' => 200,
                    'data' => $data,
                    'message' => "Danh sách tin theo loại tin"
                ], 200);
            }
            catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
            }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Không tồn tại danh sách tin theo loại này"
            ], 400);
        }
    }
}
