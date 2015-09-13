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