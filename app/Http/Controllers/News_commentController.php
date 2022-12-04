<?php

namespace App\Http\Controllers;

use App\Http\Transformer\News_comment\News_commentTransformer;
use App\Models\News;
use App\Models\News_comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class News_commentController extends BaseController
{
    // dùng cho người dùng
    function addNews_comment(Request $request, $id){
        $input = $request->all();
        try {
            News_comment::create([
                 'user_id' => auth()->user()->id,
                 'news_id' => $id,
                 'content' => $input['content'],
                 'status' => 1,
                 'created_by' => auth()->user()->id
            ]);
            return response()->json([
                 'status' => 200,
                 'message' => "Bình luận thành công"
            ], 200);
        }catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => 500,
                    'message' => $th->getMessage()
                ],500
            );
        }
    }

    function updateNews_comment(Request $request, $id){
        $input = $request->all();
        $data = News_comment::find($id);
        if($data->user_id == auth()->user->id){
            try{
                $data->update([
                    'content' => $input['content'],
                    'status' => 1,
                    'updated_by' => auth()->user()->id,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Bình luận thành công"
               ], 200);
            }catch (\Throwable $th) {
                return response()->json([
                        'status' => 500,
                        'message' => $th->getMessage()
                    ],500); 
            }
        }
        else{
            return response()->json([
                    'status' => 400,
                    'message' => "Không tìm thấy bình luận nảy",
            ],400);
        }
    }
    function deleteNews_comment(Request $request, $id){
        try {
            $data = News_comment::find($id);
            if($data->user_id == auth()->user()->id){
                $data->delete();
                return response()->json([
                    'status' => 200,
                    'message' => "Xóa tin thành công"
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Bạn không thể xóa bình luận này vì nó không phải của bạn"
                ], 400);
            }
        }
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    // dùng cho admin
    public function listNews_comment_by_newsID_admin(Request $request, $id){
        $input = $request->all();
        $News_comment = News_comment::where('news_id', $id)->get();
        return $this->response->collection($News_comment, new News_commentTransformer);
    }
    public function OneNews_comment_by_newsID_admin(Request $request, $id){
        $input = $request->all();
        $News_comment = News_comment::find($id);
        return $this->response->item($News_comment, new News_commentTransformer);
    }
    function updateNews_comment_admin(Request $request, $id){
        $input = $request->all();
        $data = News_comment::find($id);
        if($data){
            try{
                $data->update([
                    'content' => $input['content'],
                    'status' => 1,
                    'updated_by' => auth()->user()->id,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Bình luận thành công"
               ], 200);
            }catch (\Throwable $th) {
                return response()->json([
                        'status' => 500,
                        'message' => $th->getMessage()
                    ],500); 
            }
        }
        else{
            return response()->json([
                    'status' => 400,
                    'message' => "Không tìm thấy bình luận nảy",
            ],400);
        }
    }
    function deleteNews_comment_admin(Request $request, $id){
        try {
            $data = News_comment::find($id);
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
    
    // Dùng bình thường để xem
    public function listNews_comment_by_newsID(Request $request, $id){
        $input = $request->all();
        $News_comment = News_comment::where('news_id', $id)->where('status', 1)->get();
        return $this->response->collection($News_comment, new News_commentTransformer);
    }
}