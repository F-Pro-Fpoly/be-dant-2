<?php

namespace App\Http\Controllers;

use App\Http\Transformer\News_comment\News_commentTransformer;
use App\Models\News;
use App\Models\News_comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Validator;

class News_commentController extends BaseController
{
    // dùng cho người dùng
    function addNews_comment(Request $request, $id){
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ],[
            'content.required' => 'Nội dung không được bỏ trống', 
        ]);
        if($validator->fails()){
            $arrRes = [
                'errCode' => 1,
                'message' => "Lỗi validate dữ liệu",
                'data' => $validator->errors()
            ];
            return response()->json($arrRes, 402);
        }
        $dataNews = News::where('slug', $id)->first();
        if($dataNews){
        try {
            News_comment::create([
                 'user_id' => auth()->user()->id,
                 'news_id' => $dataNews->id,
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
    }else{
        return response()->json(
            [
                'status' => 400,
                'message' => "không tìm thấy tin này"
            ],400
        );
    }
    }

    function updateNews_comment(Request $request, $id){
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ],[
            'content.required' => 'Nội dung không được bỏ trống', 
        ]);
        
        if($validator->fails()){
            $arrRes = [
                'errCode' => 1,
                'message' => "Lỗi validate dữ liệu",
                'data' => $validator->errors()
            ];
            return response()->json($arrRes, 402);
        }
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
    public function OneNews_comment_by_newsID(Request $request, $id){
        $input = $request->all();
        $News_comment = News_comment::where('status', 1)->get();
        return $this->response->collection($News_comment, new News_commentTransformer);
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
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ],[
            'content.required' => 'Nội dung không được bỏ trống', 
        ]);
        
        if($validator->fails()){
            $arrRes = [
                'errCode' => 1,
                'message' => "Lỗi validate dữ liệu",
                'data' => $validator->errors()
            ];
            return response()->json($arrRes, 402);
        }
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
        $dataNews = News::where('slug', $id)->first();
        if($dataNews){
            $input = $request->all();
            $News_comment = News_comment::where('news_id', $dataNews->id)->where('status', 1)->get();
            return $this->response->collection($News_comment, new News_commentTransformer);
        }
        else{
            return response()->json([
                    'status' => 400,
                    'message' => "Không tìm thấy id tin cho bình luận nảy",
            ],400);
        }
    }
}