<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Hash, DB};

class UserController extends Controller
{
    public function signup(Request $request) {
        // signup→メールアドレスで認証→認証したらToken発行してマイページに遷移する
        $this->validator($request->all())->validate();

        return response()->json(['success' => '成功！'], 201);
        // return $request;
    }

    public function signin(Request $request) {
        return $request;
    }

    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max: 255'],
            'email' => ['required', 'string', 'email', 'max: 255'],
            'password' => ['required', 'string']
        ]);

        return $validator;
    }
}



