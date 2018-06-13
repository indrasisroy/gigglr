@if($pannel == '1')
<div class="panel-body">
@endif
    @if(count($reply_messeges) > 0)
        @foreach($reply_messeges as $all_reply)
            <h4>{{$all_reply->reply_by_user}}</h4>
            <span>{{date('d M Y , h:i A', strtotime($all_reply->reply_date))}}</span>
            <div class="seperator"></div>
            <div class="seperator"></div>
            <p>{{ucwords($all_reply->reply_content)}}</p><hr></hr>
        @endforeach
    @endif

@if($pannel == '1')
</div>
@endif