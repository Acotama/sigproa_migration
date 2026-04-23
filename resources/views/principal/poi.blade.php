    
    <?php 

    $sectores = Auth::user()->unidad()->pluck('sector')->toArray() 

    ?>
    <br>
    <div class="well">
        <div class="text-center"><span style="font-weight: bold;font-size: 36px;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;text-transform: uppercase;">Bienvenido</span></div>
        <p class="lead text-center">Talleres Educacion (POI)</p>
    </div>       
    <div class="row">
        <div class="col-md-12">
            <div class="row">
            <?php if( in_array('EDUCACION', $sectores) or Auth::user()->hasRole('admin') or Auth::user()->hasRole('adminpoi') ){ ?>
                <div class="col-md-6 center">
                    <div class="imgContainer">                        
                        <img src="{{ asset('img/educacion-1920x0-c-f.jpg') }}" alt="Educación" class="image">
                        <div class="middle">
                            <a href="poi/educacion/programacion" class="text">Educación</a>
                        </div>
                    </div>
                </div>
            <?php } ?>            
        </div>
    </div>