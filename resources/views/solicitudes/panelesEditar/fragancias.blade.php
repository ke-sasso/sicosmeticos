<div class="nav-stacked" id="fragancias">
    <a class="btn btn-primary" id="btnFrag">
        <i class="fa fa-plus"></i> Agregar Fragancia
    </a>
    <br/><br/>
    <div class="row">
        <div class="col-xs-8">           
            <table id="frag" width="100%">
                <thead>                    
                    <th>Fragancia:</th>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="fragancias[]"></td>
                        <td><a class='btn btn-danger borrar'>Eliminar<i class='fa fa-trash' aria-hidden='true'></i></a></td>
                    </tr>
                    
                </tbody>
            </table>            
        </div><!-- /.input-group -->
    </div>
    <br>
    <table id="dtfragancia" style="font-size: 12px;" class="table table-hover table-striped" width="100%">
        <thead>
            <th width="20%">Correlativo</th>
            <th width="35%">Nombre de Fragancia</th>
            <th>Opciones</th>
        </thead>
        <tbody>
        @for($i = 0; $i < count($solicitud->fragancias); $i++)
            <tr>
                <td>{!!$i+1!!}</td>
                <td>{!!$solicitud->fragancias[$i]->fragancia!!}</td>
                <td><a class="btn btn-danger btnEliminarFrag" data-id="{{$solicitud->fragancias[$i]->idFragancia}}"><i class="fa fa-trash" aria-hidden="true">Eliminar</i></a></td>
            </tr>
        @endfor
        </tbody>
    </table>

</div>