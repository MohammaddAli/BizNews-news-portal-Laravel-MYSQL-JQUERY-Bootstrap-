<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactUS as ContactModel;
use Illuminate\Support\Facades\Session;

class ContactUsController extends Controller
{
    public function index(){
        return view('contactUs');
    }
    public function contactUs(Request $request){
        $request->validate([
            'name'=> "required",
            'email' => 'required|email',
            'message' => 'required',
            'subject' => 'required',
        ]);

        Mail::to('muhammadali1994@yahoo.com')->send(new ContactUs($request));

        ContactModel::create([
        'name'=>  $request->name,
        'email' => $request->email,
        'message' =>  $request->message,
        'subject' =>  $request->subject,
        'user_id'=>  $request->userId,
    ]);

        Session::flash('done', 'the email has been sent successfully');

        return redirect()->back();
    }
}
