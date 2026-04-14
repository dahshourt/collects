<?php

namespace App\Http\Controllers\User;

use App\Factories\Users\UserFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\users\UpdateUserController;
use App\Http\Requests\users\UserRequest;
use App\Models\group;
use App\Models\User;
use App\Models\user_group;
use App\traits\LogsActivity;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ValidatesRequests, LogsActivity;

    private $model;

    function __construct(UserFactory $Category)
    {
        $this->model = $Category::index();
        $this->view  = 'users';
        $view        = 'user';
        $route       = 'users';
        $title       = 'users';
        $form_title  = 'Users';
        view()->share(compact('view', 'route', 'title', 'form_title'));
    }

    public function create_user()
    {
        $groups = Group::latest()->get();
        return view('user.create', compact('groups'));
    }

    public function index()
    {
        $users = $this->model->index();
        $this->writeLog('User', 'Viewed users list', 'View', 'User Management');
        return view('user.index', compact('users'));
    }

    public function store_user(UserRequest $request)
    {
        $this->model->store_user($request);

        $this->writeLog(
            'User',
            'Created new user: ' . $request->input('user_name', 'N/A')
                . ' | Email: ' . $request->input('email', 'N/A')
                . ' | Role: ' . $request->input('role', 'N/A'),
            'Create',
            'User Management'
        );

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $groups = Group::latest()->get();
        $this->writeLog('User', 'Viewed edit form for user: ' . $user->user_name, 'View', 'User Management');
        return view('user.edit', compact('groups', 'user'));
    }

    public function update(User $user, UpdateUserController $request)
    {
        $this->model->update($user, $request);

        $this->writeLog(
            'User',
            'Updated user ID ' . $user->id . ' | Username: ' . $user->user_name
                . ' | Changed fields: ' . $this->formatRequestDetails($request->except(['_token', '_method', 'password'])),
            'Update',
            'User Management'
        );

        return redirect()->route('users.index')->with('status', 'Updated Successfully');
    }
}
