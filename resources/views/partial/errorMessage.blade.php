errors 
@if(!empty($error))
<div class="alert alert-danger">
       
     <p>{{$error}}</p>
     
     @if(!empty($disAgreeBtn))
     <p> {!! $disAgreeBtn  !!}
     @endif

          @if(!empty($agreeBtn))
      {!! $agreeBtn  !!}</p>
     @endif
</div>
@endif
