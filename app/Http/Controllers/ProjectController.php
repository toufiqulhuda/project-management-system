<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Attachments;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
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
        if(Auth::user()->type == 1){ // Supper Admin
            $projects = DB::table('projects as p')
                ->join('users as ur','ur.id','=','p.created_by')
                ->leftJoin('users as aur','aur.id','=','p.assigned_to')
                ->join('roles as r','r.roleid','=','ur.type')
                ->where('ur.id','=',Auth::user()->id)
                ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                    'p.created_at','p.created_by_ip','aur.name as assigned_name' )
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            $assigned_users = null;
        }elseif (Auth::user()->type == 2){ // Admin
            $projects = DB::table('projects as p')
                ->join('users as ur','ur.id','=','p.created_by')
                ->leftJoin('users as aur','aur.id','=','p.assigned_to')
                ->join('roles as r','r.roleid','=','ur.type')
                //->where('ur.id','=',Auth::user()->id)
                ->where('r.roleid','=',3)
                ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                    'p.created_at','p.created_by_ip','p.duration','p.start_at','p.end_at','p.cost','p.assigned_to',
                    'p.assigned_at','p.assigned_by','p.assigned_by_ip','aur.name as assigned_name'
                )
                ->orderBy('created_at', 'desc')
                ->paginate(10);
//                `duration``start_at``end_at``status``cost``assigned_to``assigned_at``assigned_by``assigned_by_ip`

            $assigned_users = User::where("type","4")->select("id","name")->get();
        }elseif (Auth::user()->type == 3){ // Client
            $projects = DB::table('projects as p')
                ->join('users as ur','ur.id','=','p.created_by')
                ->join('roles as r','r.roleid','=','ur.type')
                ->where('ur.id','=',Auth::user()->id)
                ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                    'p.created_at','p.created_by_ip','p.assigned_to')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            $assigned_users = User::where("type","4")->select("id","name")->get();
        }elseif (Auth::user()->type == 4){ // employee
            $projects = DB::table('projects as p')
                ->join('users as ur','ur.id','=','p.created_by')
                ->leftJoin('users as abur','abur.id','=','p.assigned_by')
                ->join('roles as r','r.roleid','=','ur.type')
                ->where('p.assigned_to','=',Auth::user()->id)
                ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                    'p.created_at','p.created_by_ip','p.assigned_to','abur.name as assigned_by_name','p.assigned_at')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            $assigned_users = User::where("type","4")->select("id","name")->get();
        }

        return view('project.list')->with(compact('projects','assigned_users'));
    }

    public function publish(Request $request)
    {
        $project = Project::where('project_id', $request->id)->where('status','=','0')
            ->update(['isactive' => $request->status]);
        if($project<1){
            return redirect()->back()->with("error","Unable to update status due to the project has been started!");
        }else{
            return redirect()->back()->with("success","Project status successfully Updated!");
        }

    }
    public function assigned_to(Request $request){
//        dd($request);
        $projectId = $request->ass_project_id;
        $projects = Project::where('project_id', $projectId)
            ->update([
                    'assigned_to' => $request->assigned_to,
                    'assigned_at' => now(),
                    'assigned_by' => Auth::user()->id,
                    'assigned_by_ip' => Request()->ip()
            ]);
        if (is_null($projects)) {
            return redirect()->back()->with("error","Unable to assign Project!");
        }

        return redirect()->back()->with("success","Project assigned successfully!");
    }

    /* Add project */
    public function add()
    {
        return view('project.add');
    }

    /* Save project */
    public function save(Request $request)
    {
        $rules = array(
            'title' => 'required',
            'description' => 'required',
            'isactive' => 'required',
            'attachment' => 'required', //|mimes:csv,txt,xlx,xls,pdf|max:2048
//            'attachment.*' => 'required|mimes:pdf,xlx,csv|max:2048',
        );
        $files = [];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }
        try {
            if($request->file('attachment')) {
                /* project add*/
                $projectModel = new Project;
                $projectModel->title  = $request->title;
                $projectModel->description  = $request->description;
                $projectModel->isactive  = $request->isactive;
                $projectModel->created_at = now();
                $projectModel->created_by = Auth::user()->id;
                $projectModel->created_by_ip = Request()->ip();
                $projectModel->save();
                $project_id = $projectModel->project_id;
                foreach($request->file('attachment') as $key => $file)
                {
                    $fileName = time().rand(1,99).'_'.str_replace(" ","_",$file->getClientOriginalName());
                    $file->move(public_path('uploads'), $fileName);
                    $files[$key]['file_name'] = $fileName;
                    $files[$key]['file_path'] = '/uploads/' . $fileName;

                }
                foreach ($files as $key => $file) {
                    Attachment::create([

                            'file_name' => $file['file_name'],
                            'file_path' => $file['file_path'],
                            'project_id' => $project_id,
                            'created_at' => now(),
                            'created_by' => Auth::user()->id,
                            'created_by_ip' => Request()->ip()

                    ]);

                }


            }else{
                $projectModel = new Project;
                $projectModel->title  = $request->title;
                $projectModel->description  = $request->description;
                $projectModel->isactive  = $request->isactive;
                $projectModel->created_at = now();
                $projectModel->created_by = Auth::user()->id;
                $projectModel->created_by_ip = Request()->ip();
                $projectModel->save();
            }

            return redirect()->back()->with("success","Project insert successfully !");
        } catch(QueryException $ex){
            return back()->withErrors($ex->getMessage())->withInput();
        }


//        return view('project.add');
    }

    /* Edit project */
    public function edit(Request $request)
    {
        $projectId = $request->query('id');
        if(Auth::user()->type == 1){ // Supper Admin
            $projects = null;
            $assigned_users= null;
        }elseif (Auth::user()->type == 2){ //  Admin
            $projects = DB::table('projects as p')
                ->join('users as ur','ur.id','=','p.created_by')
                ->join('roles as r','r.roleid','=','ur.type')
                ->where('r.roleid','=',3)
                ->where('p.status','=',0)
                ->where('p.isactive','=',1)
                ->where('p.project_id','=',$projectId)
                ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                    'p.created_at','p.created_by_ip','p.duration','p.cost','p.assigned_to')
                ->first();
            $assigned_users = User::where("type","4")->select("id","name")->get();
//            dd($assigned_users);
        }elseif (Auth::user()->type == 3){ // Client
            $projects = DB::table('projects as p')
                ->join('users as ur','ur.id','=','p.created_by')
                ->join('roles as r','r.roleid','=','ur.type')
                ->where('p.status','=',0)
                ->where('ur.id','=',Auth::user()->id)
                ->where('p.project_id','=',$projectId)
                ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                    'p.created_at','p.created_by_ip')
                ->first();
            $assigned_users= null;
        }elseif (Auth::user()->type == 4){ // employee
            $projects = DB::table('projects as p')
                ->join('users as ur','ur.id','=','p.created_by')
                ->join('roles as r','r.roleid','=','ur.type')
                ->where('p.status','=',1)
                ->where('p.isactive','=',1)
                ->where('p.assigned_to','=',Auth::user()->id)
                ->where('p.project_id','=',$projectId)
                ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                    'p.created_at','p.created_by_ip')
                ->first();
            $assigned_users= null;

        }


        $attached_files = Attachment::select('attachments.id','attachments.file_name','attachments.file_path','attachments.created_by','roles.role_name')
            ->join('projects','projects.project_id','=','attachments.project_id')
            ->join('users','users.id','=','attachments.created_by')
            ->join('roles','roles.roleid','=','users.type')
            ->where('projects.project_id','=',$projectId)
            ->get();
        return view('project.edit')->with(compact('projects','attached_files','assigned_users'));
    }

    /* Update project */
    public function update(Request $request)
    {
        //dd($request);
        $projectId = $request->id;

        if(Auth::user()->type == 3){ // client
            $rules = array(
                'title' => 'required',
                'description' => 'required',
                'isactive' => 'required',
                //|mimes:csv,txt,xlx,xls,pdf|max:2048
                'attachment.*' => 'required',//|mimes:pdf,xlx,csv|max:2048',
            );
        }elseif (Auth::user()->type == 2){ // Admin
            $rules = array(
                'duration.*' => 'required',
                'cost.*' => 'required',
//                'assigned_to.*' => 'required',
                //|mimes:csv,txt,xlx,xls,pdf|max:2048
                'attachment.*' => 'required',//|mimes:pdf,xlx,csv|max:2048',
            );
        }elseif (Auth::user()->type == 4) { // employee
            $rules = array(
                'start_at.*' => 'required',
                'end_at.*' => 'required',
                //|mimes:csv,txt,xlx,xls,pdf|max:2048
                'attachment.*' => 'required',//|mimes:pdf,xlx,csv|max:2048',
            );
        }

        $files = [];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            if($request->file('attachment')) {
                if(Auth::user()->type == 3){ // client
                    $projects = Project::where('project_id', $projectId)
                        ->where('status','=',0)
                        ->update([
                            'title' => $request->title,
                            'description' => $request->description,
                            'isactive' => $request->isactive,
                            'updated_at' => now(),
                            'updated_by' => Auth::user()->id,
                            'updated_by_ip' => Request()->ip(),
                        ]);
                }elseif (Auth::user()->type == 2){ // Admin
                    $projects = Project::where('project_id', $projectId)
                        ->update([
                            'duration' => $request->duration,
                            'cost' => $request->cost,
//                            'assigned_to' => $request->assigned_to,
//                            'assigned_at' => now(),
//                            'assigned_by' => Auth::user()->id,
//                            'assigned_by_ip' => Request()->ip(),
                        ]);
                }elseif (Auth::user()->type == 4){ // employee
                    $projects = Project::where('project_id', $projectId)
                        ->update([
                            'start_at' => $request->start_at,
                            'end_at' => $request->end_at,
                        ]);
                }
                if (is_null($projects)) {
                    return redirect()->back()->with("error","Project can't updated !");
                }

                foreach($request->file('attachment') as $key => $file)
                {
                    $fileName = time().rand(1,99).'_'.str_replace(" ","_",$file->getClientOriginalName());
                    $file->move(public_path('uploads'), $fileName);
                    $files[$key]['file_name'] = $fileName;
                    $files[$key]['file_path'] = '/uploads/' . $fileName;

                }
                foreach ($files as $key => $file) {
                    Attachment::create([
                        'file_name' => $file['file_name'],
                        'file_path' => $file['file_path'],
                        'project_id' => $projectId,
                        'created_at' => now(),
                        'created_by' => Auth::user()->id,
                        'created_by_ip' => Request()->ip()

                    ]);

                }


            }else{
                if(Auth::user()->type == 3){ // client
                    $projects = Project::where('project_id', $projectId)
                        ->where('status','=',0)
                        ->update([
                            'title' => $request->title,
                            'description' => $request->description,
                            'isactive' => $request->isactive,
                            'updated_at' => now(),
                            'updated_by' => Auth::user()->id,
                            'updated_by_ip' => Request()->ip(),
                        ]);
                }elseif (Auth::user()->type == 2){ // Admin
                    $projects = Project::where('project_id', $projectId)
                        ->update([
                            'duration' => $request->duration,
                            'cost' => $request->cost,
//                            'status' => 1,
//                            'assigned_to' => $request->assigned_to,
//                            'assigned_at' => now(),
//                            'assigned_by' => Auth::user()->id,
//                            'assigned_by_ip' => Request()->ip(),
                        ]);
                }elseif (Auth::user()->type == 4){ // employee
                    $projects = Project::where('project_id', $projectId)
                        ->update([
                            'start_at' => $request->start_at,
                            'end_at' => $request->end_at,
                        ]);
                }

                if ($projects < 1) {
                    return redirect()->back()->with("error","Project can't updated !");
                }
            }
            return redirect()->back()->with("success","Project updated successfully !");
        } catch(QueryException $ex){
            return back()->withErrors($ex->getMessage())->withInput();
        }
        //return view('project.edit');
    }

    /* Details project */
    public function details(Request $request)
    {
        $projectId = $request->query('id');

        $projects = DB::table('projects as p')
            ->join('users as ur','ur.id','=','p.created_by')
            ->leftJoin('users as urat','urat.id','=','p.assigned_to')
            ->leftJoin('users as urab','urab.id','=','p.assigned_by')
            ->join('roles as r','r.roleid','=','ur.type')
//            ->where('ur.id','=',Auth::user()->id)
            ->where('p.project_id','=',$projectId)
            ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                'p.created_at','p.created_by_ip','p.duration','p.cost','p.start_at','p.end_at','urat.name as assigned_to','urab.name as assigned_by','p.assigned_at','p.assigned_by_ip','p.created_at','p.created_by','p.created_by_ip')
            ->first();
        //dd($projects);

        $attached_files = Attachment::select('attachments.id','attachments.file_name','attachments.file_path','roles.role_name')
            ->join('projects','projects.project_id','=','attachments.project_id')
            ->join('users','users.id','=','attachments.created_by')
            ->join('roles','roles.roleid','=','users.type')
            ->where('projects.project_id','=',$projectId)
            ->get();
        //dd($attached_files);
        return view('project.details')->with(compact('projects','attached_files'));
    }


}
