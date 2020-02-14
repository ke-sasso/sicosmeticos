<div class="tab-pane fade" id="presentaciones">

    <div class="panel-body">
        <div class="the-box full no-border">
            <div class="container-fluid">

                <div class="row">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table width="100%" style="font-size: 12px;" id="dt-cos"
                                   class="table table-hover table-striped">
                                <thead class="the-box dark full">
                                <tr>
                                    <th>Presentación</th>

                                </tr>
                                </thead>
                                <tbody>
                                @if($presentaciones->isEmpty())
                                    @if(Session::has('message'))
                                        <div class="alert alert-success" role="alert"
                                             style="width: 100%; margin-top: 10px; ">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            {{Session::get('message')}}
                                        </div>
                                    @endif
                                @else
                                    @foreach($presentaciones as $pre)
                                        <tr>
                                            <td>{!!$pre->textoPresentacion!!}</td>

                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>