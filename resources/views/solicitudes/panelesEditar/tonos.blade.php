<div class="nav-stacked" id="tonos">
    <a class="btn btn-primary" id="btnTono">
        <i class="fa fa-plus"></i> Agregar Tono
    </a>
    <br/>
    <div class="row" id="">
        <div class="col-xs-8">
        <table id="tono" width="100%">
                <thead>                    
                    <th>Tono:</th>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="tonos[]"></td>
                        <td><a class='btn btn-danger borrar'>Eliminar<i class='fa fa-trash' aria-hidden='true'></i></a></td>
                    </tr>
                    
                </tbody>
            </table>            
        </div>
    </div>
    <br>
    <table id="dtTono" style="font-size: 12px;" class="table table-hover table-striped" width="100%">
        <thead>
            <th width="20%">Correlativo</th>
            <th width="35%">Nombre del Tono</th>
            <th>Opciones</th>
        </thead>
        <tbody>
        @for($i = 0; $i < count($solicitud->tonos); $i++)
            <tr>
                <td>{!!$i+1!!}</td>
                <td>{!!$solicitud->tonos[$i]->tono!!}</td>
                <td><a class="btn btn-danger btnEliminarTono" data-id="{{$solicitud->tonos[$i]->idTono}}"><i class="fa fa-trash" aria-hidden="true">Eliminar</i></a></td>
            </tr>
        @endfor
        </tbody>
    </table>
</div>