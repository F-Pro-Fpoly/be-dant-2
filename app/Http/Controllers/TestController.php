<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Specialist\SpecialistTransformer;
use App\Http\Transformer\User\UserTransformer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;
use App\Models\Specialist;
use Carbon\Carbon;
use App\Exports\test;
use App\Exports\UsersExport;
use App\Models\Booking;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends BaseController
{
    protected $role;
    protected $user;

    function __construct()
    {
        $this->role = new Role();
        $this->user = new User();
    }


    public function show($id)
	{
		$user = User::findOrFail($id);

		return $this->response->item($user, new UserTransformer());
	}

    public function listUser(){
        $users = User::with(['role'])->paginate(10);

		return $this->response->paginator($users, new UserTransformer());
    }

    public function addImg(Request $request) {
        // Storage::disk('local')->put('avatars/1', $request->file('img'));
        // Storage::disk('local')->put('example.txt', 'Contents');
        $date = Carbon::now()->format('Ymds');
        $name = $request->file('image')->store('images','public');
        dd($name);
    }

    public function testSearch(Request $request){
        $input = $request->all();

        $inputArr = [];

        foreach($input as $key => $val){
            $item = [$key, '=', $val];
            array_push($inputArr, $item);
        }
        $data = $this->user->searchUser($inputArr);

        dd($data);
    }


    public function report()
    {
          //ob_end_clean();
        $date = date('YmdHis', time());
        $cate = Page::all();
        //ob_start();
        return Excel::download(new UsersExport, 'users.xlsx');
       
    }

    public function exportPDF() {
        $html = view('pdf.test_pdf');

        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=pdf_test.pdf');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        // header('Content-Length: ' . filesize($html));
        ob_clean();
        flush();
        readfile($html);
        exit;
    }

    
}
