<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Validator;
use Auth;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('permission:users-list|users-create|users-edit|users-delete', ['only' => ['index','store', 'show']]);
        $this->middleware('permission:users-create', ['only' => ['create','store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit','create','store']]);// ,'update'
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data = User::orderBy('id','ASC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        if(!Auth::user()->isAdmin()){
            abort(403);
        }
        
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Show the form for editing users own data.
     *
     * @return \Illuminate\Http\Response
     */
    public function editOwn(){
        
        $user = User::find(Auth::user()->id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        // if user not admin and user tries to update another user -> abort
        if (!Auth::user()->isAdmin() && $id != Auth::user()->id) {
            abort(403);
        }
        
        $this->validate($request, [
            'username' => 'required|unique:users,username,'.$id,
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        
        if ($user->isAdmin()) {
            return redirect()->route('users.index')->with('success','User updated successfully');
        }
        return redirect()->route('home');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}