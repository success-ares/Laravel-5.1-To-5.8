<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Service\EmailSenderService;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jobs\sendContactJob;

class ContactController extends Controller
{
	use EmailSenderService;
	
    /**
     * Post message
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSendMessage(Request $request)
    {
        // validate
        $this->validate($request, [
			'email'         => 'required|email',
            'message'       => 'required'
        ]);

		// find admin
        $admin = User::where('type', 'admin')->firstOrFail();

		$input = array(
			'email'		 => $request->input( 'email' ),
			'message'	 => $request->input( 'message' )
		);
		// send email to admin
        if( config('settings.sendEmail') ){
            // $this->sendContact($admin, $input);
            sendContactJob::dispatch($admin, $input);
        }

        return redirect()->back()->with('success', 'Message sent!');
    }
}
