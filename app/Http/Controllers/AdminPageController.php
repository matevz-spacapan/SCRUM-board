<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    public function index(){
        // preveri pravice, ali je uporabnik admin?
        
        if(Auth::user()){
            $user = User::find(Auth::user()->id);
            if($user && $user->user_level == 0){
                return view('adminPage.index')->withUser($user);
            }
        }
        return redirect('/home');
    }
    
    
}
