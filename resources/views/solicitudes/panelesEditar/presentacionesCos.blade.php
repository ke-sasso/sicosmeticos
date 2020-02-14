<div class="nav-stacked" id="presentaciones1">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pres" id="btnPre">Agregar
        Presentacion
    </button>
    <br/><br/>
</div>


<div id="tabla-pres">
    <table id="dt-pres" class="table table-hover table-striped" cellspacing="0" width="100%">
        <thead>

        <th>N°</th>
        <th>Presentacion</th>

        <th>Opciones</th>


        </thead>
        <tbody>
            @foreach($presentaciones as $presentacion)
            <tr>
                <td>{{$presentacion->idPresentacion}}</td>
                <td>{{$presentacion->textoPresentacion}}</td>
                <td>
                    <a class='btn btn-xs btn-danger borrarPres'><i class='fa fa-times' aria-hidden='true'></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>