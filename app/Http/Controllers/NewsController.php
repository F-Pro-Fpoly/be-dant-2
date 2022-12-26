<?php

namespace App\Http\Controllers;

use App\Http\Transformer\News\NewsTransformer;
use App\Http\Validators\News\InsertNewsValidate;
use App\Http\Validators\News\UpdateNewsValidate;
use App\Http\Transformer\News_category\News_categoryTransformer;
use App\Models\News;
use App\Models\News_view;
use App\Models\News_category;
use App\Models\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendNewsletter;
use App\Mail\OrderShipped;
use App\Supports\TM_Error;

class NewsController extends BaseController
{
    public function sendNewsLatter(){
        try{
            $dataNews = News::where('status', 1)->orderBy('created_at', 'DESC')->first();
            Queue::push(new SendNewsletter($dataNews));
            $messager = "Gửi mail thành công";
        }
        catch(\Throwable $th){
            $messager = $th->getMessage();
        }
    }
   public function addNews(Request $request)
    {
        $input = $request->all();
        (new InsertNewsValidate($input));

        try {

            $file_name = $input['file_name'] ?? null;
           News::create([
                'code' => $input['code'],
                'slug' => $input['slug'],
                'featured' => $input['featured'],
                'status' => $input['status'],
                'category_id' => $input['category_id'],
                'name' => $input['name'],
                'file' => $file_name,
                'content' => $input['content'],
                'views' => 0,
                'created_by' => auth()->user()->id ?? null
           ]);
            $messager = "";
            if($input['featured'] == 1){
                try{
                    $dataNews = News::where('status', 1)->orderBy('created_at', 'DESC')->first();
                    Queue::push(new SendNewsletter($dataNews));
                    $messager = "Gửi mail thành công";
                }
                catch(\Throwable $th){
                    $messager = $th->getMessage();
                }
                
           }
        //    dd($path);
           return response()->json([
                'status' => 200,
                'message' => "Thêm tin thành công",
                'mail' => $messager,
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
///////
    public function listNews_all(Request $request){
        $data = News::where('status', 1)->orderBy('created_at', 'DESC')->get();
        $data_count = News::where('status', 1)->count();
        return response()->json([
                'status' => 200,
                'data' => $data,
                'data_count' => $data_count
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

       try{

            $file_name = $input['file_name'] ?? null;
            // return $file_name;
            $data = News::find($id);
            if($data){
                $data->update([
                    'slug' => $input['slug'] ?? $data->slug,
                    'featured' => $input['featured'] ?? $data->featured,
                    'status' => $input['status'] ?? $data->status,
                    'category_id' => $input['category_id'] ?? $data->category_id,
                    'name' => $input['name'] ?? $data->name,
                    'file' => $file_name ?? $data->file,
                    'content' => $input['content'] ?? $data->content,
                    'updated_by' => auth()->user()->id ?? null
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Cập nhật tin thành công"
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
    function getNewsID(Request $request, $id){
        $data = News::where('slug',$id)->where('status', 1)->first();
        if($data){
            $data->update([
                'view' => $data->view + 1,
            ]);

            $dataView = News_view::create([
                'number' => 1,
                'news_id' => $data->id
            ]);

            $input = $request->all();
            $News = News::where('slug',$id)->where('status', 1)->first();
            $dataNews = $News->searchNews($input);
            return $this->response->item($News, new NewsTransformer);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Không tìm thấy tin này"
           ], 400);
        }
    }

    function getNews_featured(){
        $data = News::where('status', 1)->where('featured', 1)->limit(9)->get();
        if($data){
            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => "Lấy 9 tin nổi bật thành công"
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
        $data = News::where('status', 1)->orderBy('created_at', 'DESC')->limit(3)->get();
        if($data){
            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => "Lấy 3 tin mới thành công"
           ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Không tìm thấy tin nỗi bật này"
           ], 400);
        }
    }
    public function listall(Request $request){
        $input = $request->all();
        $News = News::where('status', 1)->orderBy('created_at', 'DESC')->paginate($input['limit']??5);
        //$data = $News->searchNews($input);
        return $this->response->paginator($News, new NewsTransformer);
    }
    // public function listall(Request $request){
    //     $input = $request->all();
    //     $News = new News();
    //     $data = $News->searchNews($input);
    //     return $this->response->paginator($data, new NewsTransformer);
    // }

    public function getTopWeek1(){
        try{
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $now = date('Y-m-d H:i:s', strtotime('-1 week'));

            $ts = strtotime($now);
            $start = (date('w', $ts) == 0) ? $ts : strtotime('last monday', $ts);
            $start_date = date('Y-m-d H:i:s', $start);
            $end_date = date('Y-m-d H:i:s', strtotime('next sunday', $start));
            
            $data = News_view::select('news.*','news_category.name as category_name', News_view::raw('COUNT(news_views.news_id) as viewWeek'))
                            ->join('news', 'news.id', 'news_views.news_id')
                            ->join('news_category', 'news_category.id', 'news.category_id')
                            ->where('news_views.created_at', ">", $start_date)
                            ->where('news_views.created_at', "<", $end_date)
                            ->groupBy('news_views.news_id')
                            ->orderBy('viewWeek','desc')
                            ->take(1)->get(); // Lộc shadow đòi dùng take cho thành data:{[dữ liệu]}
                            //->first();  dùng first ra data:{dữ liệu} lộc shadow không sài được  

            return response()->json([
                'status' => 200,
                'data' => $data
            ], 200);
        }
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    public function getTopWeek3(){
        try{
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $now = date('Y-m-d H:i:s', strtotime('-1 week'));

            $ts = strtotime($now);
            $start = (date('w', $ts) == 0) ? $ts : strtotime('last monday', $ts);
            $start_date = date('Y-m-d H:i:s', $start);
            $end_date = date('Y-m-d H:i:s', strtotime('next sunday', $start));
            
            $data = News_view::select('news.*','news_category.name as category_name', News_view::raw('COUNT(news_views.news_id) as viewWeek'))
                            ->join('news', 'news.id', 'news_views.news_id')
                            ->join('news_category', 'news_category.id', 'news.category_id')
                            ->where('news_views.created_at', ">", $start_date)
                            ->where('news_views.created_at', "<", $end_date)
                            ->groupBy('news_views.news_id')
                            ->orderBy('viewWeek','desc')
                            ->skip(1)->take(3)->get();
            return response()->json([
                'status' => 200,
                'data' => $data
            ], 200);
        }
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}