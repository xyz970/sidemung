<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiResponse;
    public function login(LoginRequest $request)
    {
        //get credentials from request
        $credentials = $request->validated();
        try {
            if (!$token = JWTAuth::attempt($credentials)) return $this->internalErrorResponse("Cek kembali password atau email anda",);
        } catch (JWTException $e) {
            return $this->internalErrorResponse("Ada yang salah :(");
        }

        //Token created, return with success response and jwt token
        $data = array(
            'user' => Auth::user(),
            'success' => true,
            'token' => $token,
        );

        return $this->successResponseData('Login',$data);   
    }

    public function register(RegisterRequest $request)
    {
        User::create($request->validated());
        return $this->successResponse('Register Berhasil');
    }

    public function logout()
    {
        JWTAuth::invalidate();
        Auth::logout();

        return $this->successResponse('Berhasil Logout');
    }

    public function check()
    {
        return $this->successResponseData('Data',Auth::user());
    }

    public function update_profile(Request $request)
    {
        $input = $request->only(['password','phone']);
        $auth = Auth::user();
        $user = User::find($auth->id)->update($input);
        return $this->successResponse("Profile berhasil diupdate");

    }
}
