<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
class UserController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(){
        // event(new UserRegistered(auth()->user()));
        // Mail::to('truongthang5602@gmail.com')->send(new WelcomeMail(auth()->user()));
        $keyword = request()->get('keyword');
        $search = request()->get('search');
        if($keyword){
            $users = $this->userService->getUsersWithRolesFilter($keyword);
        }else{
            $users = $this->userService->getUsers();
        }
        if($search){
            $users = $this->userService->search($search);
        }
        return view('users.index', [
            'users' => $users
        ]);
    }

    public function import(Request $request){
        $this->userService->importUsers($request);
        return redirect()->route('user.list')->with('success', 'User imported successfully!');
    }

    public function export(){
        return $this->userService->exportUsers();
    }

    public function store(Request $request){
        $this->userService->createUser($request->all());

        return redirect()->route('user.list')->with('success', 'User created successfully!');
    }

    public function update(Request $request, $id){
        $this->userService->updateUser($id, $request->all());
        return redirect()->route('user.list')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);

        if ($result === 'admin') {
            return redirect()->route('user.list')
                ->with('error', 'Cannot delete admin account!');
        }

        return redirect()->route('user.list')
            ->with('success', 'User deleted successfully!');
    }

    public function deleteSelected(Request $request){
        $ids = json_decode($request->selected_ids, true);
        $this->userService->deleteSelectedUser($ids);
        // activity('delete account')->log(auth()->user()->name . ' deleted ' . $name);

        return redirect()->route('user.list')
            ->with('success', 'Users deleted successfully!');
    }

}
