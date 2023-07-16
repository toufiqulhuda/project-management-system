<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /*
|--------------------------------------------------------------
| All user list
|--------------------------------------------------------------
| Here all user list of this system
|
*/
    public function index()
    {
        $users = DB::table('users as u')
            ->join('users as ur','ur.id','=','u.created_by')
            ->join('roles as r','r.roleid','=','u.type')
//            ->join('branch as br','br.branchid','=','u.branch_id')
            ->select('u.id', 'u.name','u.email','u.address','u.contact','r.role_name','u.isactive','ur.name as created_by',
                'u.created_at','u.created_by_ip','u.images')
            ->get();
//        return $users;
        return view('user.userList')->with(compact('users'));
    }
/*
|--------------------------------------------------------------
| Login User Profile
|--------------------------------------------------------------
| Here the information of login user's
|
*/
	public function showUserProfile(){
        $users = User::select('users.name', 'users.email','users.address','users.contact','users.images','roles.role_name as type')
                ->join('roles', 'roles.roleid', '=', 'users.type')
                ->where('id',Auth::user()->id)
                ->first();

        return view('user.userProfile')->with(compact('users'));
	}


    /*
|--------------------------------------------------------------
| Active / In-Active user
|--------------------------------------------------------------
| Here admin can change user status Active / In-Active
|
*/
    public function changeUserStatus(Request $request)
    {
//        return $request;
        $users = User::where('id', $request->id)
            ->update(['isactive' => $request->status]);

        return redirect()->back()->with("success","Status successfully Update!");
    }

    public function addUserView(){
        $userTypeList = Role::select('roleid','role_name')
        ->where('isactive','1')->get();
//        dd($userTypeList);
        return view('user.addUser')->with(compact('userTypeList'));
    }

    public function registarUser(Request $request){

        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'type' => 'required',
            'password_confirm' => 'required|same:password',
            'password' => ['required', Password::min(8)->mixedCase()->symbols()->numbers()],
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'created_by' => Auth::user()->id,
            'created_by_ip' => Request()->ip()
        ]);
        // return view('user.addUser');
        return redirect()->back()->with("success","User Successfully Created!");
        // return redirect()->back()->withErrors($validator, 'login');
    }
    /*
|--------------------------------------------------------------
| Login User Profile
|--------------------------------------------------------------
| Here the information of login user's
|
*/
    public function editUserView(Request $request){
            $userId = $request->query('id');
            $users = DB::table('users')
                ->where('id',$userId)
                ->select('id','name', 'email','address','contact','images','type')
                ->first();

            return view('user.editUser')->with(compact('users'));


    }

    public function editUser(Request $request){
//        return $request;
        $rules = array(
            'name' => 'required',
            'type' => 'required',
            'contact' => 'required',

        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }
        $users = User::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'address' => $request->address,
                'contact' => $request->contact,
                'type' => $request->type,
            ]);

        return redirect()->back()->with("success","Status successfully Update!")->withInput();

//        return view('user.editUser')->with(compact('users'));


    }
    /*
|--------------------------------------------------------------
| Change any User Password
|--------------------------------------------------------------
| Admin can changed any user's password
|
*/

    public function showResetPasswordForm(){
        return view('user.resetUserPassword');
    }

    public function resetPassword(request $request){

        $resetPassword='123456';

        $users = User::where('username',$request->get('username'))->first();
        //return $users;
        $users->password = bcrypt($resetPassword);
        $users->save();
        return view('admin.resetuserpassword')->with("success","Password reset successfully !");
    }
    /*
|--------------------------------------------------------------
| Change login User Password
|--------------------------------------------------------------
| User can changed his own password
|
*/

    public function showChangePasswordForm(){
        return view('user.changePassword');
    }

    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");

    }
    public function showUserRoleForm(){
        //$users = User::all();
        //$role = Role::all();
        //$role = DB::table('roles')
        $roles = Role::join('users', 'users.id', '=', 'roles.created_by')
            ->select('roles.roleid', 'roles.role_name','roles.description','users.name as created_by','roles.created_at','roles.created_by_ip','roles.isactive')
            ->get();
        //return $role;
        return view('role.roleList')->with(compact('roles'));
    }
/* *********************Role **********************************/
    public function showAddRoleForm(){
        return view('role.addRole');
    }
    public function saveRole(request $request){
        $rules = array(
            'name' => 'required',
            'description' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            $Role = new Role;
            $Role->role_name  = $request->name;
            $Role->description  = $request->description;
            $Role->created_at = now();
            $Role->created_by = Auth::user()->id;
            $Role->created_by_ip = Request()->ip();
            $Role->save();
            return redirect()->back()->with("success","User role insert successfully !");
        } catch(QueryException $ex){
            return back()->withErrors($ex->getMessage())->withInput();
        }
        // return view('admin.userrole');
    }
    public function showUpdateRoleForm(Request $request){
        $roleId = $request->query('id');
        $role = Role::find($roleId)
            ->select('roleid','role_name', 'description')
            ->first();
        return view('role.updateRole')->with(compact('role'));
    }
    public function updateRole(request $request){
        $update_id = $request->id;
        $rules = array(
            'role_name' => 'required',
            'description' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            $Role = Role::find($update_id);
            $Role->role_name  = $request->role_name;
            $Role->description  = $request->description;
            $Role->updated_at = now();
            $Role->updated_by = Auth::user()->id;
            $Role->updated_by_ip = Request()->ip();
            $Role->update();
            return redirect()->back()->with("success","User role insert successfully !");
        } catch(QueryException $ex){
            //dd($ex->getMessage());
            return back()->withErrors($ex->getMessage())->withInput();
        }
        // return view('admin.userrole');
    }

    public function changeRoleStatus(Request $request){
        $roles = Role::find($request->id)
            ->update(['isactive' => $request->status]);

        return redirect()->back()->with("success","Status successfully Update!");
    }

}
