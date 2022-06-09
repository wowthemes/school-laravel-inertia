<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentsController extends Controller
{
    public function store(Request $request)
    {
        $files = $request->file('file');
        $response = [];

        foreach ($files as $file) {
            $orignal_name = $file->getClientOriginalName();
            $path = date('Y') . '/' . date('m');
            
            $res = $file->storeAs($path, $orignal_name);
            $storage = Storage::get($res);
            $model = new Attachment();
            $model->original_name = $orignal_name;
            $model->name = $orignal_name;
            $model->mime = Storage::mimeType($res);
            $model->extension = $file->getClientOriginalExtension();
            $model->size = Storage::size($res);
            $model->path = $res;
            $model->disk = config('filesystems.default');
            $model->user_id = auth()->id();
            $model->save();

            $response[] = $model;

        }

        return response()->json($response);
    }
}
