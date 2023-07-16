<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function delete($id)
    {
        Attachment::find($id)->delete();

        return response()->json(['success' => 'Attachment Deleted Successfully!']);
    }
}
