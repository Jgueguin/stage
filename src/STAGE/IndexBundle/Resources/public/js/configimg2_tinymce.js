tinymce.init({
  selector: 'textarea',
  language:'fr_FR',
  height: 350,
  subfolder:"",

  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars fullscreen lists',
    'insertdatetime media nonbreaking save table contextmenu directionality ',
    'emoticons template paste textcolor colorpicker textpattern imagetools  toc responsivefilemanager save'
  ],

  toolbar1: 'undo redo | insertion | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

  toolbar2: 'print preview media | forecolor backcolor emoticons | ',

  toolbar3: 'save',

  image_advtab: true,
  paste_data_images: true,
  file_picker_types: 'file image media',

  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
],
  // enable automatic uploads of images represented by blob or data URIs
 automatic_uploads: true,

});
