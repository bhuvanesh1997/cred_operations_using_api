<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    function index(){
        return view('indexpage');
    }

    function getdata(request $request){
        if($request->id != ""){
            $userlist = User::where('id',$request->id)->first();
            echo json_encode($userlist);exit();
        }
        else{
            $userlist = User::all();
        }
        $html = "";
        $i = 1;
        foreach($userlist as $val){
            $html .= '<tr>';
            $html .= '<td>'.$i++.'</th>';
            $html .= '<td>'.date('d-m-Y',strtotime($val->created_at)).'</td>';
            $html .= '<td>'.$val->name.'</td>';
            $html .= '<td>'.$val->email.'</td>';
            $html .= '<td>'.$val->mobile.'</td>';
            $html .= '<td><a onclick="edit('.$val->id.')">Edit</a><br><a onclick="deletedate('.$val->id.')">Delete</a></td>';
            $html .= '</tr>';
        }
        echo $html;
    }

    function savedata(request $request){
        if($request->edit_id == ""){
            User::insert([
                'name' => $request->fname,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'created_at' => date('Y-m-d h:i:s')
            ]);
            echo json_encode('success');
        }
        else{
            User::whereId($request->edit_id)->update([
                'name' => $request->fname,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'updated_at' => date('Y-m-d h:i:s')
            ]);
            echo json_encode('success');
        }
    }

    function deletedata(request $request){
        if($request->id != ""){
            User::where('id',$request->id)->delete();
            echo json_encode('success');
        }
    }
}
