<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function login(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'email' => ['required', 'email', 'exists:users,email'],
                'password' => ['required'],
            ]);

            // Mengecek credentials (login)
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized',
                ], 'Authentication Failed', 500);
            }

            // Jika hash tidak sesuai maka beri error
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new Exception('Invalid Credentials');
            }

            // Jika berhasil maka loginkan
            $tokenResult = $user->createToken('auth_token')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function register(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'house_number' => $request->house_number,
                'phone_number' => $request->phone_number,
                'city' => $request->city,
                'password' => Hash::make($request->password),
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('auth_token')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'toke_type' => 'Bearer',
                'user' => $user,
            ]);
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        // Jika berhasil maka kirim data
        $tokenResult = $user->createToken('auth_token')->plainTextToken;

        return ResponseFormatter::success([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 'Authenticated');
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:5120'
        ]);

        if ($validator->failed()) {
            return ResponseFormatter::error([
                'error' => $validator->errors()
            ], 'Update photo fails', 401);
        }

        if ($request->file('file')) {
            $user = Auth::user();

            Storage::disk('public')->delete($user->profile_photo_path);
            $file = $request->file->store('assets/user', 'public');

            // Simpan url foto ke database
            $user->profile_photo_path = $file;
            $user->update();

            $tokenResult = $user->createToken('auth_token')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'toke_type' => 'Bearer',
                'user' => $user,
            ]);
        }
    }
}
