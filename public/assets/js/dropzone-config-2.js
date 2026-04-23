$(function(){
  $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
  var counter = 0;
  var actual = 0;
  var cleanUp = true;


  $('#fecha').change(function(){
      btnState();
  });
  $('#fecha').keyup(function(){
      console.log(actual + counter);
      btnState();
  });
  /*function randomString(){
      var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

      for( var i=0; i < 5; i++ )
          text += possible.charAt(Math.floor(Math.random() * possible.length));

      return text;
  }
  var randS = randomString();*/
  Dropzone.options.dzone = {

      uploadMultiple: true,
      autoProcessQueue: false,
      maxFiles: 8,
      parallelUploads: 8,
      maxFilesize: 250,
      acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",

      previewsContainer: '#dropzonePreviewAntes',
      previewTemplate: document.querySelector('#preview-template').innerHTML,
      addRemoveLinks: true,
      dictRemoveFile: 'Quitar',
      //dictFileTooBig: 'La imagen es mayor a 8MB',
      dictRemoveFileConfirmation: "¿Estas seguro que deseas borrar esta imagen?",
      //enqueueForUpload: false,
      // The setting up of the dropzone
      /*createImageThumbnails: true,
      maxThumbnailFilesize: 100,*/

      init:function() {
          // Add server images
          //var myDropzone = this;

          //console.log(actual);
          uid = document.getElementById('uid').value;

          var submitButton = document.querySelector("#submit-all");
          myDropzone = this; // closure

          submitButton.addEventListener("click", function(event) {
              event.preventDefault();
              if($('#fecha').val() !== '') {
                  myDropzone.processQueue(); // Tell Dropzone to process all queued files.
              } else{
                  $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
              }

          });

          $('input[type=radio][name=tipo]').change(function() {
              cleanUp = false;
              //$('#fecha').val('');
              //$('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
              //counter = 0;
              //actual  = 0;
              //myDropzone.removeAllFiles();
              btnState();
              cleanUp = true;
          });
          this.on("addedfile", function() {
              actual++;
              console.log(actual);
              btnState();
          });
          this.on("maxfilesexceeded", function(){
              alert("Limite de Imagenes Excedido");
          });
          indx = 0;
          this.on("sendingmultiple", function(file, xhr, formData){
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              uid= document.getElementById('uid').value;
              console.log(uid);
              formData.append('tipo',$('input[name=tipo]:checked').val());
              formData.append('uid',uid);
              formData.append('fecha',$('#fecha').val());
              formData.append('_token', csrf_token);
              formData.append('cantidad', counter);
          });
          this.on("error", function(file){if (!file.accepted) this.removeFile(file);});
          this.on("removedfile", function(file) {
              if(cleanUp) {
                  $.ajax({
                      type: 'POST',
                      url: 'upload/delete',
                      data: {
                          id: $('.serverfilename', file.previewElement).val(),
                          uid: document.getElementById('uid').value,
                          _token: $('#csrf-token').val()
                      },
                      dataType: 'html',
                      success: function (data) {
                          var rep = JSON.parse(data);
                          if (rep.code === 200) {
                              counter--;
                              $("#photoCounterAntes").text("(" + counter + ")");
                          }

                      }
                  });
              }
              counter--;
              btnState();

          });

      },
      error: function(file, response) {
          $('#message').html('<div class=\'alert alert-danger fade in\'>Error al guardar las imagenes, intentelo nuevamente</div>');
          cleanUp = false;
          myDropzone.removeAllFiles();
          swal(
           'Error',
           'Error al subir las imagenes, intentelo nuevamente!',
           'error'
          );
      },
      success: function(file,response) {
          var myDropzone = this;
          $('.serverfilename', file.previewElement).val(response.filename);
          counter++;
          $("#photoCounterAntes").text( "(" + counter + ")");

          $('#message').html('<div class=\'alert alert-success fade in\'>Las imagenes se Guardaron Exitosamente</div>');
          cargarImg();
          cleanUp = false;
          myDropzone.removeAllFiles();
          swal(
              'Correcto',
              'Las imagenes se guardaron correctamente',
              'success'
          );

      }
  };



  function btnState(){
      if($('#fecha').val() !== '' && actual + counter >= 3 && $('input[name=tipo]').is(':checked')===true ){
          $('#submit-all').removeAttr('disabled').addClass('btn btn-success');
      }else{
          $('#submit-all').attr('disabled','disabled').addClass('btn btn-alert');
      }
      console.log($('input[name=tipo]').is(':checked'));
      console.log($('#fecha').val());

  }

});



//AJAX REQUEST ON IMAGE UPLOAD ->
cargarImg = function(){
  uid = document.getElementById('uid').value;
$.get('/server-images/' + uid.toString(), function(data) {
  $('#antes').html('');
  $('#durante').html('');
  $('#despues').html('');


  if(data.antes.length != 0){
    $.each(data.antes, function (key, value) {

       url = value.url;
       $('#antes').append('<a style="margin-right:8px" class="fancybox" rel="group" href="'+url+'"><img width=150px height=150px src="'+url+'" alt="" /></a>');

       //$('#antes').append('<img class=\'fancybox\' src=\''+ url +'\'  data-big=\' '+ url +' \' style=\'border-width:0px;width:280px; height:280px;\'>');
       $('#foto_antes').text(' Fecha: ' + value.fecha);
    });

  } else {
    $('#antes').append('<h4>No hay imagenes disponibles</h4>');
  }

    if(data.durante.length != 0){

    $.each(data.durante, function (key, value) {
        url = value.url;
        $('#durante').append('<a style="margin-right:8px" class="fancybox" rel="group" href="'+url+'"><img width=150px height=150px src="'+url+'" alt="" /></a>');
        $('#foto_durante').text(' Fecha: ' + value.fecha);
    });
  } else {
    $('#durante').append('<h4>No hay imagenes disponibles</h4>');
  }

  if(data.despues !=''){
    $.each(data.despues, function (key, value) {

        url = value.url;
        $('#despues').append('<a style="margin-right:8px" class="fancybox" rel="group" href="'+url+'"><img width=150px height=150px src="'+url+'" alt="" /></a>&nbsp;&nbsp');
        $('#foto_despues').text(' Fecha: ' + value.fecha);
    });
  } else {
    $('#despues').append('<h4>No hay imagenes disponibles</h4>');
  }
}).fail(function() {
    console.log("herror");
});
};


cargarImg();
