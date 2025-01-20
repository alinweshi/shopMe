<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function viewProfile()
    {
        $admin = Auth::guard('admin')->user()->first();
        // dd($admin);
        return view('backend.admin.profile.view_profile', compact('admin'));
    }
}
