<div class="nav-stacked" id="form">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#for" id="agregarSus">Agregar
        Sustancia
    </button>

</div>


<br/>
<table id="dtformula" class="table table-hover table-striped" cellspacing="0" width="100%">
    <thead>
    <th>Correlativo</th>
    <th>N° CAS</th>
    <th>NOMBRE SUSTANCIA</th>
    <th>PORCENTAJE</th>
    <th>Opciones</th>


    </thead>
    <tbody>
        @foreach($formula as $form)
             <tr>
                <td class='id'>{{$form->idDenominacion}}</td>
                <td>{{$form->numeroCAS}}</td>
                <td>{{$form->denominacionINCI}}</td>
                <td class='porc'>{{(float)$form->porcentaje}} %</td>
                <td><a class='borrar'><i class='btn btn-xs btn-danger fa fa-times' aria-hidden='true'></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
