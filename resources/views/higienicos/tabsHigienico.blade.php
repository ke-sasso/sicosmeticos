<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel with-nav-tabs panel-success">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#generalesh" data-toggle="tab">Generales</a></li>
                    <li><a href="#propietario" data-toggle="tab">Propietario</a></li>
                    <li><a href="#profesional" data-toggle="tab">Profesional</a></li>
                    <li><a href="#classh" data-toggle="tab">Clasificación</a></li>
                    <li><a href="#marcah" data-toggle="tab">Marca</a></li>
                    <li><a href="#presentacionesh" data-toggle="tab">Presentaciones</a></li>
                    <li><a href="#fragancia" data-toggle="tab">Fragancias</a></li>
                    <li><a href="#tonos" data-toggle="tab">Tonos</a></li>
                    <li><a href="#fab" data-toggle="tab">Fabricantes</a></li>
                    <li><a href="#imp" data-toggle="tab">Importadores</a></li>
                    <li><a href="#dist" data-toggle="tab">Distribuidores</a></li>

            </div>

            <div id="panel-collapse-1" class="collapse in">
                <div class="panel-body">
                    <div class="tab-content">
                        @include('higienicos.paneles.generales')
                        @include('panelesGenerales.propietario')
                        @include('panelesGenerales.profesional')
                        @include('higienicos.paneles.clasificacion')
                        @include('higienicos.paneles.marca')
                        @include('higienicos.paneles.presentaciones')
                        @include('panelesGenerales.tonos')
                        @include('panelesGenerales.fragancias')
                        @include('panelesGenerales.fabricantes')
                        @include('panelesGenerales.importadores')
                        @include('panelesGenerales.distribuidores')

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>