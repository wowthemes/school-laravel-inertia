<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentsController extends Controller
{
    public function store(Request $request)
    {
        $files = $request->file('file');

        dd($files);
    }
}
