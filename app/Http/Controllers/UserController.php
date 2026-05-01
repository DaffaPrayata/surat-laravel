<?php

namespace App\Http\Controllers;

use App\Enums\Config as ConfigEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Config;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('pages.user', [
            'data' => User::render($request->search),
            'search' => $request->search,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
{
    try {
        $newUser = $request->validated();

        $newUser['password'] = Hash::make('password123'); // default
        $newUser['role'] = 'STAFF';
        $newUser['is_active'] = true;

        User::create($newUser);

        return back()->with('success', 'User berhasil ditambahkan');
    } catch (\Throwable $e) {
        return back()->with('error', $e->getMessage());
    }
}


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        try {
            $newUser = $request->validated();

            // checkbox is_active
            $newUser['is_active'] = isset($newUser['is_active']);

            // reset password jika dicentang
            if ($request->filled('reset_password')) {
                $newUser['password'] = Hash::make(
                    Config::getValueByCode(ConfigEnum::DEFAULT_PASSWORD)
                );
            }

            $user->update($newUser);

            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();
            return back()->with('success', __('menu.general.success'));
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
