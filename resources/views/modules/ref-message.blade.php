<div class="card-box">

    <h4 class="header-title m-t-0 m-b-30">Comments ({{ $messages->count() }})</h4>

    <div>
        @foreach($messages->take(5) as $message)
            <div class="media m-b-30">
                <div class="media-left">
                    @if($message->sender->photo)
                        <img class="media-object img-circle thumb-sm" src="{{ '/images/avatars/'.$message->sender->photo }}">
                    @else
                        <img class="media-object img-circle thumb-sm" src="/assets/images/no_avatar.png">
                    @endif
                </div>
                <div class="media-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="media-heading">{{ $message->sender->first_name.' '.$message->sender->last_name }}</h4>
                        </div>
                        <div class="col-sm-6">
                            @if($message->attachment)
                                <p class="text-right">
                                    <a href="{{ route('site.message.attachment', $message->attachment ) }}">
                                        <span class="label label-primary"><i class="ti-download"></i> {{ $message->file_name }}</span>
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                    <p class="font-13 text-muted m-b-0">{{ $message->message }}</p>

                </div>
            </div>
        @endforeach

        <form action="{{ route('site.message.postSend') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="referral_id" value="{{ $referral->id }}">
            <input type="hidden" name="sender_id" value="{{ $user->id }}">
            <div class="media">
                <div class="media-left">
                    @if($user->photo)
                        <img class="media-object img-circle thumb-sm" alt="64x64" src="{{ '/images/avatars/'.$user->photo }}">
                    @else
                        <img class="media-object img-circle thumb-sm" src="/assets/images/no_avatar.png">
                    @endif
                </div>
                <div class="media-body">
                    <input type="text" class="form-control input-sm" name="message" placeholder="Your message...">
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="file" id="file_attach" name="attachment" data-filename-placement="inside">
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-block btn-xs waves-effect waves-light">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>