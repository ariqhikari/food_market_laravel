<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\{User, Transaction};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $users = User::paginate(10);
        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => $this->passwordRules(),
            'address' => ['required', 'string', 'max:255'],
            'roles' => ['required', 'string', 'max:255', 'in:USER,ADMIN'],
            'house_number' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
        ]);

        $data = $request->all();

        $data['password'] = Hash::make($request->password);
        $data['profile_photo_path'] = $request->file('profile_photo_path')->store('assets/user', 'public');

        User::create($data);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return App\Models\User;
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return App\Models\User;
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return App\Models\User;
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => $this->passwordRules(),
            'address' => ['string', 'max:255'],
            'roles' => ['string', 'max:255', 'in:USER,ADMIN'],
            'house_number' => ['string', 'max:255'],
            'phone_number' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
        ]);

        $data = $request->all();

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->file('profile_photo_path')) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $data['profile_photo_path'] = $request->file('profile_photo_path')->store('assets/user', 'public');
        }

        $user->update($data);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return App\Models\User;
     */
    public function destroy(User $user)
    {
        $transactions = Transaction::where('user_id', $user->id)->get();
        foreach ($transactions as $transaction) {
            $transaction->delete();
        }

        Storage::disk('public')->delete($user->profile_photo_path);
        $user->delete();

        return redirect()->route('users.index');
    }
}
