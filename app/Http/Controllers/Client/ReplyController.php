<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;

class ReplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Form validation
        Reply::create([
            'comment_id' => $request->input('comment_id'),
            'name' => $request->input('name'),
            'content' => $request->input('message'),
        ]);
        return redirect()->back();
    }
}
