<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use PasswordValidationRules;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return ResponseFormatter::success($users, 'Data list user berhasil diambil');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => $this->passwordRules(),
            'address' => ['required', 'string', 'max:255'],
            'roles' => ['required', 'string', 'max:255', 'in:USER,ADMIN'],
            'house_number' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $validator->errors(),
            ], 'Store User Failed', 500);
        }

        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);

            if ($request->file('profile_photo_path')) {
                $data['profile_photo_path'] = $request->file('profile_photo_path')->store('assets/user', 'public');
            }

            $user = User::create($data);

            return ResponseFormatter::success($user, 'Data user ditambah');
        } catch (QueryException $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e->errorInfo,
            ], 'Query Exception', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return ResponseFormatter::success($user, 'Data user berhasil diambil');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => $this->passwordRules(),
            'address' => ['required', 'string', 'max:255'],
            'roles' => ['required', 'string', 'max:255', 'in:USER,ADMIN'],
            'house_number' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $validator->errors(),
            ], 'Store User Failed', 500);
        }

        try {
            $data = $request->all();

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->file('profile_photo_path')) {
                Storage::disk('public')->delete($user->profile_photo_path);
                $data['profile_photo_path'] = $request->file('profile_photo_path')->store('assets/user', 'public');
            }

            $user->update($data);

            return ResponseFormatter::success($user, 'Data user berhasil diupdate');
        } catch (QueryException $e) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $e->errorInfo,
            ], 'Query Exception', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $transactions = Transaction::where('user_id', $user->id)->get();
        foreach ($transactions as $transaction) {
            $transaction->delete();
        }

        Storage::disk('public')->delete($user->profile_photo_path);
        $user->delete();

        return ResponseFormatter::success(null, 'Data user berhasil dihapus');
    }
}
