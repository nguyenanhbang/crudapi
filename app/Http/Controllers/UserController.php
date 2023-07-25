<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show($id)
    {
        return User::findOrFail($id);
       
    }
    public function index()
    {
        $users = User::
            join('departments', 'users.deparment_id', '=', 'departments.id')
            ->join('users_status', 'users.status_id', '=', 'users_status.id')
            ->select(
                'users.*', 
                'departments.name as departments', 
                'users_status.name as status'
            )
            ->get();
            // ->paginate(); 10k quản lí thì dùng cái này để tự động phân trang 
        return response()->json($users);
    }


    public function create () {
        $users_status = \DB::table("users_status")
        ->select(
            "id as value",
            "name as label"
        )
        -> get();

        $departments = \DB::table("departments")
        ->select(
            "id as value",
            "name as label"
        )
        -> get();

        return response()->json([
            "users_status" => $users_status,
            "departments" => $departments
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            "status_id" => "required",
            "uername" => "required|unique:users,uername",
            "name" => "required",
            "email" => "required|email",
            "password" => "required|confirmed",
            "password_confirmation" => "required|confirmed",
            "deparment_id" => "required",
              
        ], [
            "status_id.required" => " nhap tinh trang",
            "uername.required" => " nhap ten tai khoan",
            "uername.unique" => " ten tai khoan da ton tai",

            "name.required" => " nhap ho va ten",
            "name.max" => " ký tự tối đa 255",
            
            "email.required" => " nhap email",
            "email.email" => " email khong hop le",

            "password.required" => " nhap mat khau",
            "password.confirmed" => "mat khau va xac nhan mat khau khong khop",

            "password_confirmation.required" => " nhap lai mat khau",
            "password_confirmation.confirmed" => "mat khau va xac nhan mat khau khong khop",

            "deparment_id.required" => " nhap phong ban"
        ]);
        
        $user = $request->except(["password", "password_confirmation"]);
        $user["password"] = \Hash::make($request["password"]);
        User::create($user);

        // User::create([
        //     "status_id" => $request["status_id"],
        //     "uername" => $request["uername"],
        //     "name" => $request["name"],
        //     "email" => $request["email"],
        //     "password" => \Hash::make($request["password"]),
        //     "deparment_id" => $request["deparment_id"]

        // ]);

        
    }


    public function edit($id)
    {
        $users = User::find($id);

        $users_status = \DB::table("users_status")
        ->select(
            "id as value",
            "name as label"
        )
        -> get();

        $departments = \DB::table("departments")
        ->select(
            "id as value",
            "name as label"
        )
        -> get();

        return response()->json([
            "users" => $users,
            "users_status" => $users_status,
            "departments" => $departments
        ]); 
    }



    public function update (Request $request, $id) {
        $validated = $request->validate([
            "status_id" => "required",
            "uername" => "required|unique:users,uername,".$id,
            "name" => "required",
            "email" => "required|email",
            "deparment_id" => "required",
              
        ], [
            "status_id.required" => " nhap tinh trang",

            "uername.required" => " nhap ten tai khoan",
            "uername.unique" => " ten tai khoan da ton tai",

            "name.required" => " nhap ho va ten",
            "name.max" => " ký tự tối đa 255",

            "email.required" => " nhap email",
            "email.email" => " email khong hop le",

            "deparment_id.required" => " nhap phong ban"
        ]);


        User::find($id)-> update([
            "status_id"->$request["status_id"],
            "uername"->$request["uername"],
            "name"->$request["name"],
            "email"->$request["email"],
            "deparment_id"->$request["deparment_id"]
        ]);

        if($request["change_password"] == true) {
            $validated = $request->validate([
                "password" => "required|confirmed",
                  
            ], [
                "password_confirmation.required" => " nhap lai mat khau",
                "password_confirmation.confirmed" => "mat khau va xac nhan mat khau khong khop",
            ]);
        }
    }
    
}

            
