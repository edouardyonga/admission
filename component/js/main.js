
// $(document).ready(
//   // hide btech and mtech
//   $("#step2").hide(),
//   $("#step3").hide(),

//     $(".next1").click(function(){
//       $("#step1").hide();
//       $("#step2").show('slow');

      
//       $("div#next").removeClass("next1"); 
//       $("div#next").addClass("next2");
//       $("h1#step span").text("2");

      
//   }),
//     $("div#next .next2").click(function(){
//       alert("its reaching");
//       $("#step2").hide();
//       $("#step3").show('slow');
      

//       $("#step").text("3");
      
//   }),
//     $(".next3").click(function(){

//   })
// );


$(document).ready(
  // hide btech and mtech
  $("#btech-descr").hide(),
  $("#mtech-descr").hide(),

    $("#hnd").click(function(){
      $("div#mtech").removeClass("btn-danger");
      $("div#mtech").addClass("btn-info"); 
      $("div#btech").removeClass("btn-danger");
      $("div#btech").addClass("btn-info"); 
      $("div#hnd").removeClass("btn-info");
      $("div#hnd").addClass("btn-danger"); 


      $("#hnd-descr").show();
      $("#btech-descr").hide();
      $("#mtech-descr").hide();
  }),
    $("#btech").click(function(){
      $("div#mtech").removeClass("btn-danger");
      $("div#mtech").addClass("btn-info");
      $("div#hnd").removeClass("btn-danger");
      $("div#hnd").addClass("btn-info");
      $("div#btech").removeClass("btn-info");
      $("div#btech").addClass("btn-danger");

      $("#btech-descr").show();
      $("#mtech-descr").hide();
      $("#hnd-descr").hide();
  }),
    $("#mtech").click(function(){
      $("div#btech").removeClass("btn-danger");
      $("div#btech").addClass("btn-info");
      $("div#hnd").removeClass("btn-danger");
      $("div#hnd").addClass("btn-info");
      $("div#mtech").removeClass("btn-info");
      $("div#mtech").addClass("btn-danger");       
      $("#mtech-descr").show();
      $("#hnd-descr").hide();
      $("#btech-descr").hide();
  })
);

  
 



 $(".answer_pan").hide();

$(document).ready(function(){
	 $(".answer_pan").hide();

	$(".answer").click(function(){
	  $(".answer_pan").slideToggle();
	});

});

 $(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable .row").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

 function reloadPage() {
  elmt = document.getElementById('answ');
  cont = elmt.innerHTML;
  cont.load();
  alert(cont);
 }
 