// Toggle between up and down arrows for order history collapsible
$(".fa-angle-down").on('click', function(event){
    $(this).next().css("display", "block");
    $(this).css("display", "none");
});

$(".fa-angle-up").on('click', function(event){
    $(this).prev().css("display", "block");
    $(this).css("display", "none");
});