<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
    public function index()
    {
//        switch($role) {
//            case 'admin':
//                $path = '/admin';
//                break;
//            case 'user':
//                $path = '/dashboard';
//                break;
//            default:
//                $path = '/login';
//                break;
//        }
        if(Auth::user()->type == 1){ // supper admin
            $draftProject = Project::where('isactive','=','0')
                ->where('status','=','0')
                ->where('assigned_by','=',null)
//                ->where('created_by','=',Auth::user()->id)
                ->count();
            $pendingProject = Project::where('isactive','=','1')
                ->where('status','=','0')
                ->where('assigned_by','=',null)
//                ->where('created_by','=',Auth::user()->id)
                ->count();
            $runningProject = Project::where('isactive','=','1')
                ->where('status','=','1')
                ->where('assigned_by','!=',null)
//                ->where('created_by','=',Auth::user()->id)
                ->count();
            $doneProject = Project::where('isactive','=','1')
                ->where('status','=','2')
                ->where('assigned_by','!=',null)
//                ->where('created_by','=',Auth::user()->id)
                ->count();
            $cancelProject = Project::where('isactive','=','1')
                ->where('assigned_by','!=',null)
                ->where('status','=','3')->count();
            return view('home')
                ->with(compact('draftProject','pendingProject','runningProject','doneProject','cancelProject'));
        }elseif (Auth::user()->type == 2){ // Admin
            $draftProject = 0;
            $pendingProject = Project::where('isactive','=','1')
                ->where('status','=','0')
                ->where('assigned_by','=',null)
//                ->where('created_by','=',Auth::user()->id)
                ->count();
            $runningProject = Project::where('isactive','=','1')
                ->where('status','=','1')
                ->where('assigned_by','!=',null)
//                ->where('created_by','=',Auth::user()->id)
                ->count();
            $doneProject = Project::where('isactive','=','1')
                ->where('status','=','2')
                ->where('assigned_by','!=',null)
//                ->where('created_by','=',Auth::user()->id)
                ->count();
            $cancelProject = Project::where('isactive','=','1')
                ->where('assigned_by','!=',null)
                ->where('status','=','3')->count();
            return view('home')
                ->with(compact('draftProject','pendingProject','runningProject','doneProject','cancelProject'));
            //dd('Admin');
        }elseif (Auth::user()->type == 3){ // client
            $draftProject = Project::where('isactive','=','0')
                ->where('created_by','=',Auth::user()->id)
                ->count();
            $pendingProject = Project::where('isactive','=','1')
                ->where('status','=','0')
                ->where('assigned_by','=',null)
                ->where('created_by','=',Auth::user()->id)
                ->count();
            $runningProject = Project::where('isactive','=','1')
                ->where('status','=','1')
                ->where('assigned_by','!=',null)
                ->where('created_by','=',Auth::user()->id)
                ->count();
            $doneProject = Project::where('isactive','=','1')
                ->where('status','=','2')
                ->where('assigned_by','!=',null)
                ->where('created_by','=',Auth::user()->id)
                ->count();
            $cancelProject = Project::where('isactive','=','1')
                ->where('assigned_by','!=',null)
                ->where('status','=','3')->count();
            return view('home')
                ->with(compact('draftProject','pendingProject','runningProject','doneProject','cancelProject'));
            //dd('Client');
        }elseif (Auth::user()->type == 4){ //employee
            $draftProject = 0;
            $pendingProject = Project::where('isactive','=','1')
                ->where('status','=','0')
                ->where('assigned_to','=',Auth::user()->id)
//                ->where('created_by','=',Auth::user()->id)
                ->count();
            $runningProject = Project::where('isactive','=','1')
                ->where('status','=','1')
                ->where('assigned_to','=',Auth::user()->id)
//                ->where('created_by','=',Auth::user()->id)
                ->count();
            $doneProject = Project::where('isactive','=','1')
                ->where('status','=','2')
                ->where('assigned_to','=',Auth::user()->id)
//                ->where('created_by','=',Auth::user()->id)
                ->count();
            $cancelProject = Project::where('isactive','=','1')
                ->where('assigned_to','=',Auth::user()->id)
                ->where('status','=','3')->count();
            return view('home')
                ->with(compact('draftProject','pendingProject','runningProject','doneProject','cancelProject'));

//            dd('employee');
        }
//        $wordlist = Wordlist::where('id', '<=', $correctedComparisons)->get();
//        $wordCount = $wordlist->count();
//        $count = Model::where('status','=','1')->count();
//        return view('home')
//            ->with(compact('draftProject','pendingProject','runningProject','doneProject'));
    }
}
