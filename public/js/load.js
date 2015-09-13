/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready( function( ) {
    $("#inzeraty").fadeIn("fast",function( ) {
        $("#firmy").fadeIn("fast",function( ) {
            $("#diskuze").fadeIn("fast",function( ) {
                $("#clanky").fadeIn("fast",function( ) {
                    $("#banner-left").animate( { width: '150px'} );
                    $("#banner-right").animate( { width: '150px'} );
                });
            });
        });
    });
});


/* 
* Function to animate leaving a page

$.fn.leavePage = function() {   
    
  this.click(function(event){

    // Don't go to the next page yet.
    event.preventDefault();
    linkLocation = this.href;
    
    // Fade out this page first.
    $('body').fadeOut(500, function(){
      
      // Then go to the next page.
      window.location = linkLocation;
    });      
  }); 
};


/* 
* Call the leavePage function upon link clicks with the "transition" class

$('.transition').leavePage();

*/