<?php

namespace App\Http\Controllers\Admin;

use App\Enum\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Admin/User/Index', [
            'users' => User::with('roles')->withTrashed()->get(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach(Role::where('name', RoleEnum::DEFAULT)->pluck('id')->first());

        return redirect()->route('admin.users');
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Admin/User/Create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function restore(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = User::withTrashed()->find($request->integer('userId'));

        $user->restore();

        return redirect()->route('admin.users');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = User::withTrashed()->find($request->integer('userId'));

        if ($request->boolean('forceDelete')) {
            $user->forceDelete();
        } else {
            $user->delete();
        }

        return redirect()->route('admin.users');
    }
}
