<?php namespace App\Http\Controllers\Site;

use App\Message;
use App\Notification;
use App\Referral;
use App\Service\MessageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class MessageController extends Controller
{

    use MessageService;

    // user
    protected $user;


    /**
     * MessageController constructor.
     * @param Request $request
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Post message
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSendMessage(Request $request)
    {
        // validate
        $this->validate($request, [
            'referral_id'   => 'required|integer',
            'sender_id'     => 'required|integer',
            'message'       => 'required',
            'attachment'    => 'mimes:jpeg,png,rar,zip,pdf,doc,docx|max:10240'
        ]);

        // get referral
        $referral = Referral::where('id', $request->input('referral_id') )->with('product.biz')->firstOrFail();

        // access check
        if ($this->user->id !== $referral->parent_id && $this->user->id !== $referral->product->biz->user_id ){
            abort(403);
        }

        // create new message
        $message = new Message();
        $message->referral_id = $request->input('referral_id');
        $message->sender_id = $request->input('sender_id');
        $message->message = clean($request->input('message'), ['HTML.Allowed' => ''] );

        // Attachments
        if ($request->hasFile('attachment')){

            // get file, his name and extension
            $file = $request->file('attachment');
            $fileName = $file->getClientOriginalName();

            // generate name for attachment
            $attachment = str_random(35);

            $file->move(storage_path('message_attachments'), $attachment);

            // add file name and attachment random name
            $message->file_name = $fileName;
            $message->attachment = $attachment;
        }

        // save message
        $message->save();

        // create new notification
        $notification = new Notification();

        if ($this->user->id == $referral->product->biz->user_id){
            // to seller
            $notification->user_id              = $referral->parent_id;
        }else{
            // to business owner
            $notification->user_id              = $referral->product->biz->user_id;
        }

        $notification->notification_header      = 'You have new message!';
        $notification->notification_text        = 'Text: '.str_limit($message->message, 150);
        if ($this->user->photo){
            $notification->notification_image   = asset('images/avatars/'.$this->user->photo);
        }else{
            $notification->notification_image   = asset('assets/images/no_avatar.png');
        }

        $notification->notification_link        = '<a href="'. route('site.ref.view', $referral->id ).
            '" role="button" class="btn btn-xs btn-primary notification-link">More</a>';
        $notification->save();

        return redirect()->back()->with('success', 'Message added!');
    }


    /**
     * Download attachment file
     * @param $attachment
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getAttachment($attachment)
    {
        // get message
        $message = Message::where('attachment', $attachment)->firstOrFail();

        return response()->download(storage_path('message_attachments').'/'.$message->attachment, $message->file_name);
    }
}
