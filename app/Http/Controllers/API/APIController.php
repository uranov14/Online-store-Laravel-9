<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class APIController extends Controller
{
    public function registerUser(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ];

            $customMessage = [
                'name.required' => 'Name is required!',
                'email.required' => 'Email Address is required!',
                'email.email' => 'Valid Email is required!',
                'email.unique' => 'Email already exists!',
                'password.required' => 'Password is required!'
            ];

            $validator =Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            //Create User Account
            //Insert the user Details in users table
            $user = new User;
            $user->name = $data['name'];
            $user->mobile = $data['mobile'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->status = 1;

            //Set Default Timezone to Ukraine
            date_default_timezone_set("Europe/Kyiv");
            $user->created_at = date("Y-m-d H:i:s");
            $user->updated_at = date("Y-m-d H:i:s");

            $user->save();

            return response()->json([
                'status'=>true,
                'message'=>"User registered succesfully!"
            ], 201);
        }
    }

    public function loginUser(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'email' => 'required|email|exists:users',
                'password' => 'required'
            ];

            $customMessage = [
                'email.required' => 'Email Address is required!',
                'email.email' => 'Valid Email is required!',
                'email.exists' => 'Email does not exists!',
                'password.required' => 'Password is required!'
            ];

            $validator =Validator::make($data, $rules, $customMessage);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            return response()->json([
                'status'=>true,
                'message'=>"User login succesfully!"
            ], 201);
        }
    }
}
