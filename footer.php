</div>

<script src="js/jquery-3.2.1.min.js"></script>

<script src="js/bootstrap.min.js"></script>

<script src="js/jquery.waypoints.js"></script>

<script src="js/jquery.counterup.js"></script>

<script src="js/metisMenu.js"></script>

<script language="javascript">
$(function() {
    $('#side-menu').metisMenu();
    
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });
});


$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

	var topOffset = 50;
        var height = (($(window).height() > 0) ? $(window).height() : $(document).height()) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        $("#page-wrapper").css("min-height", (height) + "px");
    
    var url = window.location;
    if(url.pathname.indexOf("pacienti") > 1 || url.pathname.indexOf("consultatii") > 1){
        var arrayPath = url.pathname.split('/');
        arrayPath[arrayPath.length - 1] = "pacienti.php";
        var newArrayPath = arrayPath.join('/');
	url= url.origin + newArrayPath;
    }
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});
</script>

</body>

</html>