<div class="tab-pane fade" id="tonos">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-8">
                <label>Tonos:</label>
                @foreach($tonos as $t)
                    <input type="text" class="form-control" name="tonos[]" value="{{$t->tono}}"/><br/>
                @endforeach
            </div><!-- /.input-group -->
        </div>
    </div>
</div>
