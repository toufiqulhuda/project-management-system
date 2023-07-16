<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Attachments;
use App\Models\Project;
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
//        dd(Auth::user()->name);
        $projects = DB::table('projects as p')
            ->join('users as ur','ur.id','=','p.created_by')
            ->join('roles as r','r.roleid','=','ur.type')
            ->where('ur.id','=',Auth::user()->id)
//            ->join('branch as br','br.branchid','=','u.branch_id')
            ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                'p.created_at','p.created_by_ip')
            ->get();
        return view('project.list')->with(compact('projects'));
    }
    public function publish(Request $request)
    {
        $project = Project::where('project_id', $request->id)
            ->update(['isactive' => $request->status]);

        return redirect()->back()->with("success","Project status successfully Updated!");
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
        $projects = DB::table('projects as p')
            ->join('users as ur','ur.id','=','p.created_by')
            ->join('roles as r','r.roleid','=','ur.type')
            ->where('ur.id','=',Auth::user()->id)
            ->where('p.project_id','=',$projectId)
            ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                'p.created_at','p.created_by_ip')
            ->first();

        $attached_files = Attachment::select('id','file_name','file_path')
            ->join('projects','projects.project_id','=','attachments.project_id')
            ->where('projects.project_id','=',$projectId)
            ->get();
        return view('project.edit')->with(compact('projects','attached_files'));
    }

    /* Update project */
    public function update()
    {
        return view('project.edit');
    }

    /* Details project */
    public function details(Request $request)
    {
        $projectId = $request->query('id');
        $projects = DB::table('projects as p')
            ->join('users as ur','ur.id','=','p.created_by')
            ->join('roles as r','r.roleid','=','ur.type')
            ->where('ur.id','=',Auth::user()->id)
            ->where('p.project_id','=',$projectId)
            ->select('p.project_id', 'p.title','p.description','p.status','p.isactive','ur.name as created_by',
                'p.created_at','p.created_by_ip')
            ->get();
        $attached_files = Attachment::select('id','file_name','file_path')
            ->join('projects','projects.project_id','=','attachments.project_id')
            ->where('projects.project_id','=',$projectId)
            ->get();
        return view('project.details')->with(compact('projects','attached_files'));
    }


}
