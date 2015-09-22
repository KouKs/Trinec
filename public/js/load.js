/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready( function( ) {
    $("#container").fadeIn("slow",function( ) {
        $("#banner-left").animate( { width: '150px'} );
        $("#banner-right").animate( { width: '150px'} );
    });

    $('.leave').leavePage();
});


/* 
* Function to animate leaving a page
*/
$.fn.leavePage = function() {   
    
  this.click(function(event){

    event.preventDefault();
    linkLocation = this.href === undefined ? this.form.action : this.href;

    $("#banner-left").animate( { width: '0px'} );
    $("#banner-right").animate( { width: '0px'} );
    $("#container").fadeOut("slow",function(){
      window.location = linkLocation;
    });      
  }); 
};
