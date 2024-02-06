<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function delete($id)
    {
        if(Auth::user()->type == 3) { //client
            $attachment = Attachment::find($id)
                ->join('projects', 'projects.project_id', '=', 'attachments.project_id')
                ->where('projects.status','=','0')
                ->where('projects.created_by','=',Auth::user()->id)
                ->delete();
        }else if(Auth::user()->type == 2) { //admin
            $attachment = Attachment::find($id)
                ->join('projects', 'projects.project_id', '=', 'attachments.project_id')
                ->where('projects.status','=','1')
                ->where('projects.assigned_by','=',Auth::user()->id)
                ->delete();

        }else if(Auth::user()->type == 4) { //employee
            $attachment = Attachment::find($id)
                ->join('projects', 'projects.project_id', '=', 'attachments.project_id')
                ->where('projects.status','=','1')
                ->where('projects.assigned_to','=',Auth::user()->id)
                ->delete();

        }

        if($attachment<1){
            return response()->json(['error' => 'Attachment can not Deleted!']);
        }else{
            return response()->json(['success' => 'Attachment Deleted Successfully!']);
        }

//        return response()->json(['success' => 'Attachment Deleted Successfully!']);
    }
}
