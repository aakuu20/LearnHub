$(document).ready(function() {
   
    //on click Join class, hide create class and show join class form
    $("#joinClass").click(function()  {
        $("#first").slideUp("slow", function(){
            $("#second").slideDown("slow");
          });
      });
        //on click create class, hide joinclass and  show  create class form
         $("#createClass").click(function() {
              $("#second").slideUp("slow", function(){
                 $("#first").slideDown("slow");
          });
      });
 
 });