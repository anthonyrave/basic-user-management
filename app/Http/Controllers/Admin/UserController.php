<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
