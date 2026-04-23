<span class="cabecera">
    <h3>Metadatos Imágen</h3>
</span>

<div id="container" class="container-fluid">
    <div class="row">
        <div class="col-md-12">            
            <div class="row">
                <?php
                  $data = json_decode($taller['exifdata']);                  
                  $exp = explode(';',$taller['imgcdata']);
                ?>
                <ul>
                    <li>Fecha Captura de Imagen: <b> <?php 
                    if( isset($data->DateTime) )
                        { 
                            echo $data->DateTime;
                        } 
                    elseif( isset($data->DateTimeOriginal) )
                        {
                            echo $data->DateTimeOriginal; 
                        } 
                    else { 
                        echo 'No tiene';
                    } ?></b></li>                
                    <li>Nombre de Imagen antes de subir: <b>{{$exp[1]}} </b> </li>
                    <li>Fecha de Modificacion de Imagen: <b> {{$exp[0]}}</b> </li>
                </ul>
            </div>
        </div>
    </div>
</div>
