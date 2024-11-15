<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ApprovalController extends Controller
{
  public function index()
  {
    $approvals = Approval::with('user')->latest()->get();
    return view('approval.index', compact('approvals'));
  }

  public function approve(Request $request, User $user)
  {
    Approval::where('user_id', $user->id)->update(['status' => 'Approved']);
    $user->assignRole('admin');
    Alert::success('Success', 'Member request has been approved!');
    return redirect()->back();
  }

  public function reject(Request $request, User $user)
  {
    Approval::where('user_id', $user->id)->update(['status' => 'Rejected']);
    Alert::success('Success', 'Member request has been rejected!');
    return redirect()->back();
  }

  public function request(Request $request)
  {
    Approval::create([
      'user_id' => Auth::id()
    ]);
    Alert::success('Success', 'Your request has been sent!');
    return redirect()->back();
  }
}
