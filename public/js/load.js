/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready( function( ) {
    $("#inzeraty").fadeIn("fast",function( ) {
        $("#firmy").fadeIn("fast",function( ) {
            $("#diskuze").fadeIn("fast",function( ) {
                $("#clanky").fadeIn("fast");
            });
        });
    });
    $("#banner-left").animate( { width: '150px'} );
    $("#banner-right").animate( { width: '150px'} );
    $(".area").fadeIn("slow");

    $('.leave').leavePage();
});


/* 
* Function to animate leaving a page
*/
$.fn.leavePage = function() {   
    
  this.click(function(event){

    event.preventDefault();
    linkLocation = this.href;
    
    $("#banner-left").animate( { width: '0px'} );
    $("#banner-right").animate( { width: '0px'} );
    $("#container").fadeOut("slow",function(){
      window.location = linkLocation;
    });      
  }); 
};
