<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Contracts\AdminInterface;

class AdminController extends \SleepingOwl\Admin\Http\Controllers\AdminController {

    public function __construct(Request $request, AdminInterface $admin, Application $application)
    {
        parent::__construct($request, $admin, $application);
    }

    public function index() {
        return \AdminSection::view(view('admin/index'), 'name');
    }

    public function login(Request $request) {
        if ($request->post() && Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            Auth::login(User::query()->where('email', $request->email)->first());
            return response()->redirectTo('/admin');
        }

        return view('admin/login');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('admin/login');
    }

    public function doAjax(Request $request): JsonResponse {
        $widgetClass = $request->component;
        $action = (new $widgetClass)->runCommand($request->command, $request->params);

        return response()->json($action)->header('Content-Type', 'application/json');
    }

    public function table() {
        return 1;
    }

}
