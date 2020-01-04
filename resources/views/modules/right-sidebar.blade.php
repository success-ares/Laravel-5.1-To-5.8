<!-- Right Sidebar -->
<div class="side-bar right-bar">
    <a href="javascript:void(0);" class="right-bar-toggle">
        <i class="zmdi zmdi-close-circle-o"></i>
    </a>
    <h4 class="">Notifications</h4>
    <div class="notification-list nicescroll">
        <ul class="list-group list-no-border user-list">
            @isset($notifications)

            @foreach($notifications as $notification)
            <li class="list-group-item" id="notification-{{ $notification->id }}">
                <div class="user-list-item">
                    @if($notification->notification_image)
                    {{-- User avatar or other images --}}
                    <div class="avatar">
                        <img src="{{ $notification->notification_image }}">
                    </div>
                    @else
                    <div class="icon bg-{{ $notification->notification_icon_style }}">
                        <i class="zmdi zmdi-{{ $notification->notification_icon }}"></i>
                    </div>
                    @endif
                    <div class="user-desc">
                        <span class="name">{{ $notification->notification_header }}</span>
                        @if($notification->notification_text)
                        <span class="desc">{!! $notification->notification_text !!}</span>
                        @endif
                        @if($notification->notification_link)
                        <span class="link" data-notification-id="{{ $notification->id }}">{!! $notification->notification_link !!}</span>
                        <br>
                        @endif
                        <div class="row">
                            <div class="col-sm-10">
                                <span class="time">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="col-sm-2 text-right">
                                <a href="#" class="read-button" data-notification-id="{{ $notification->id }}" title="Mark Read">
                                    <i class="zmdi zmdi-close-circle-o"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach

            @endisset

        </ul>
    </div>
</div>
<!-- /Right-bar -->