$(function() {   
  tinyMCE.init({
		selector: 'textarea', 
		language:'fr_FR',
		height: 350,
		
		plugins: [
		'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		'searchreplace wordcount visualblocks visualchars  fullscreen',
		'insertdatetime media nonbreaking  table contextmenu directionality',
		'emoticons template paste textcolor colorpicker textpattern imagetools  toc  '
		],
             
		toolbar1: "undo redo | insertion | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		toolbar2: " print preview media | forecolor backcolor ",
		toolbar3: "  link | image", file_browser_callback: RoxyFileBrowser,
		image_advtab: true,
		paste_data_images: true,
	}); 
});


function RoxyFileBrowser(field_name, url, type, win) {
  var roxyFileman = '../fileman/index.html';
  if (roxyFileman.indexOf("?") < 0) {     
    roxyFileman += "?type=" + type;   
  }
  else {
    roxyFileman += "&type=" + type;
  }
  roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
  if(tinyMCE.activeEditor.settings.language){
    roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
  }
  tinyMCE.activeEditor.windowManager.open({
     file: roxyFileman,
     title: 'Roxy Fileman',
     width: 850, 
     height: 650,
     resizable: "yes",
     plugins: "media",
     inline: "yes",
     close_previous: "no"  
  }, {     window: win,     input: field_name    });
  return false; 
}