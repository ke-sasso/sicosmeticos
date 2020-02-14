<div class="row">
    @if(Session::has('message'))
        <div class="alert alert-success" role="alert" style="width: 100%; margin-top: 10px; ">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{Session::get('messageTF')}}
        </div>
    @endif

    <div class="col-xs-8">
        <label>Fragancias:</label>
        @foreach($frag as $f)
            <input type="text" class="form-control" name="fragancias[]" value="{{$f->fragancia}}"
                   readonly="true"/><br/>
        @endforeach
    </div><!-- /.input-group -->
</div>
   