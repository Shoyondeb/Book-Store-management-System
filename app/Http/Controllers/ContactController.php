<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        try {
            // Send email to yourself
            Mail::to('shoyondeb18246@gmail.com')->send(new ContactMail($request->all()));

            return redirect()->back()
                ->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to send message. Please try again later.');
        }
    }

    // Make sure your contact page returns flash data
    public function show()
    {
        return Inertia::render('Footer/Contact', [
            'flash' => session()->get('flash') // Pass flash messages
        ]);
    }
}
