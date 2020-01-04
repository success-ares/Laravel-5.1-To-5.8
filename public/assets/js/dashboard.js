$(function() {
    $( document ).ready( function() {
        $( ".share-btn a" ).click(function(e) {
            e.preventDefault();
            centeredPopup(this.href,'Futurelab','700','300','yes');return false
        });
         $(document).on('click', '.reff-more-detail .expand', function(e){

                $(".item-collapse, .reff-more-detail, .item-expand" ).toggle(200);
                $(".form-referral .checkbox").addClass('check-expanded'); 

        });

        $(document).on('click', '.check-expanded #checkbox2', function(e){

            if ($(this).is(":checked")) {
                $(".item-collapse, .reff-more-detail, .item-expand").toggle(200);
                $(".form-referral .checkbox").removeClass('check-expanded'); 
            }
        }); 
         

    });
});

function centeredPopup(url, title, w, h) {  
    // Fixes dual-screen position                         Most browsers      Firefox  
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;  
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;  

    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;  
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;  

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;  
    var top = ((height / 2) - (h / 2)) + dualScreenTop;  
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);  

    // Puts focus on the newWindow  
    if (window.focus) {  
        newWindow.focus();  
    }  
}