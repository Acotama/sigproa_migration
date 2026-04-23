<span class="cabecera">
    <script>
        var lat = -11.127036;
        var lon = -77.596699;
    </script>
                           <h3>Ubicación</h3>





                           </span>

                           <div id="container" class="container-fluid">

                           <button onclick="displayMap();">Show Map</button>
                   <form id="frm_location" class="ubicacion" method="POST">
                           <br>

                           <br>

                           <div class="row">
                           <br>
                           <div class="row">
                           <div class="col-md-3 col-md-offset-1">
                           <div class="input-group">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                   <input type="text" class="form-control col-md-12" id="pac-input" placeholder="Busqueda en mapa"/>
                           </div>
                           </div>
                           <div class="col-md-3">
                           <div class="input-group">
                           <span class="input-group-addon">{{ Form::label('latitud', 'Latitud') }}</span>

                           <div>{{ Form::text('latitud', null, array('class' => 'form-control', 'id' => 'lat')) }}</div>
                           </div>
                           </div>
                           <div class="col-md-3">
                           <div class="input-group">
                           <span class="input-group-addon">{{ Form::label('longitud', 'Longitud') }}</span>

                           <div>{{ Form::text('longitud', null, array('class' => 'form-control', 'id' => 'lon')) }}</div>
                           </div>
                           </div>
                           </div>
                           <br>

                           <div class="mapContainer col-md-offset-1 col-md-10">
                           <div class="row">
                           <div id="map" style="display: none"></div>
                           </div>

                           </div>
                           </div>
                           <br>

                           <div class="modal-footer">
                           <a type="button" class="btn btn-danger" href="{{URL::to('/piptotalpriori')}}"><span
                   class="glyphicon glyphicon-arrow-left"></span> VOLVER</a>
                   <input type=hidden id="uid" name="uid" value="{{ $data['cod_unif'] }}"/>
                           <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> GUARDAR
                           </button>
                           </div>
                           </form>

                           <script>

                           function displayMap() {
                               document.getElementById('map').style.display="block";
                               initMap();
                           }

                   //============================== UBICACIÓN ================================
                   // GET LOCATION SAVED OR SET DEFAULT
                   function getLocationInfo() {
                       uid = document.getElementById('uid').value;
                       $.ajax({
                           url: "/procompite-getLocationInfo",
                           type: 'POST',
                           data: {uid: uid},
                           success: function (data) {
                               $('#lat').val(data.data['latitud']);
                               $('#lon').val(data.data['longitud']);
                               if ((data.data['latitud'].length === 0 || !data.data['latitud']) && (data.data['longitud'].length === 0 || !data.data['longitud'])) {
                                   lat = -11.127036;
                                   lon = -77.596699;
                               } else {
                                   lat = parseFloat(data.data['latitud']);
                                   lon = parseFloat(data.data['longitud']);
                               }
               }
           });
       }
       //LOAD GOOGLE MAPS API
                   var map;
                   function initMap() {
                       map = new google.maps.Map(document.getElementById('map'), {
                           center: {lat: lat, lng: lon},
                           zoom: 14,
                           mapTypeId: google.maps.MapTypeId.HYBRID
                       });
                       var marker = new google.maps.Marker({
                           position: {lat: lat, lng: lon},
                           map: map
                       });
                       console.log(lat, lon);
                       google.maps.event.addListener(map, 'click', function (event) {
                           $('#lat').val(event.latLng.lat());
                           $('#lon').val(event.latLng.lng());
                       });
                       google.maps.event.trigger(map, 'resize');
                       google.maps.event.addListenerOnce(map, 'idle', function () {
                           google.maps.event.trigger(map, 'resize');
                       });
                       // Create the search box and link it to the UI element.
                       var input = /** @type {HTMLInputElement} */ (
                               document.getElementById('pac-input'));
                       var searchBox = new google.maps.places.SearchBox(
                               /** @type {HTMLInputElement} */
                               (input));
                       // Listen for the event fired when the user selects an item from the
                       // pick list. Retrieve the matching places for that item.
                       var markers = [];
                       google.maps.event.addListener(searchBox, 'places_changed', function () {
                           var places = searchBox.getPlaces();
                           if (places.length == 0) {
                               return;
                           }
                           // Clear out the old markers.
                           markers.forEach(function (marker) {
                               marker.setMap(null);
                           });
                           markers = [];
                           // For each place, get the icon, name and location.
                           var bounds = new google.maps.LatLngBounds();
                           places.forEach(function (place) {
                               var icon = {
                                   url: place.icon,
                                   size: new google.maps.Size(71, 71),
                                   origin: new google.maps.Point(0, 0),
                                   anchor: new google.maps.Point(17, 34),
                                   scaledSize: new google.maps.Size(25, 25)
                               };
                               // Create a marker for each place.
                               markers.push(new google.maps.Marker({
                                   map: map,
                                   icon: icon,
                                   title: place.name,
                                   position: place.geometry.location
                               }));
                               if (place.geometry.viewport) {
                                   // Only geocodes have viewport.
                                   bounds.union(place.geometry.viewport);
                               } else {
                                   bounds.extend(place.geometry.location);
                               }
                           });
                           map.fitBounds(bounds);
                       });
                   }
       //SAVE LOCATION PARAMS
       $("#frm_location").submit(function (e) {
           e.preventDefault();
           var formData = new FormData($(this)[0]);
           $.ajax({
               url: '/procompite-updateLocationInfo',
               type: 'POST',
               data: formData,
               async: false,
               cache: false,
               contentType: false,
               processData: false,
               beforeSend: function () {
                   $('button').attr('disabled', 'disabled');
               },
               success: function (response) {
                   $('button').removeAttr('disabled');
                   swal(
                           'Correcto',
                           'Datos actualizados correctamente!',
                           'success'
                   );
                   getLocationInfo();
               },
               error: function (response) {
                   $('button').removeAttr('disabled');
                   response = $.parseJSON(response.responseText);
                   swal(
                           'Error',
                           'Error al guardar los cambios',
                           'error'
                   );
               }
           });
           return false;
       });

    </script>
</div>


