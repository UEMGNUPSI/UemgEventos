window.onload = function(){
    var click = 1;
    var tamanhoNav = $(".nav-admin").width();
    var tamanhoTitleBar = $(".top-header").outerHeight(true);
    var centro = (tamanhoTitleBar / 2) - ($(".titulo").height() / 2);

    $(".corpo").css({
        "margin-top": tamanhoTitleBar+"px",
        "margin-left": tamanhoNav+"px"
    });
    $("#nav-row").css("margin-left", tamanhoNav+15+"px");
    $(".header-admin").css("height", tamanhoTitleBar+"px");
    $(".titulo").css("top", centro+"px");

    $("#nav-show").click(function(){
        if(!click){
            $(".lbl-nav").addClass("hidden-xs hidden-sm");
            $(".nav-admin").animate({
                width: tamanhoNav+"px",
            }, 200, function(){
                // $(".nav-admin").removeAttr("style");
                $(".lbl-nav").addClass("hidden-xs hidden-sm");

                var tamanhoNav = $(".nav-admin").width();
                var tamanhoTitleBar = $(".top-header").outerHeight(true);
                
                $(".corpo").css({
                    "margin-top": tamanhoTitleBar+"px",
                    "margin-left": tamanhoNav+"px"
                });

                $("#nav-row").css("margin-left", tamanhoNav+15+"px");
            });

            $(".icon-nav").removeAttr("style");
            

            click = 1;
        }
        else{
            $(".nav-admin").animate({
                width: "192px",
            }, 200, function(){
                $(".lbl-nav").removeClass("hidden-xs hidden-sm");

                var tamanhoNav = $(".nav-admin").width();
                var tamanhoTitleBar = $(".top-header").outerHeight(true);

                $(".corpo").css({
                    "margin-top": tamanhoTitleBar+"px",
                    "margin-left": tamanhoNav+"px"
                });
                
                $("#nav-row").css("margin-left", tamanhoNav+15+"px");
                
            });
            
            

            $(".icon-nav").animate({
                "padding-left": "15px"
            }, 100);

            click = 0;
        }
    });

    $("#nav-row").resize(function(){
        var tamanhoTitleBar = $(".top-header").outerHeight(true);
        var centro = (tamanhoTitleBar / 2) - ($(".titulo").height() / 2);

        $(".header-admin").css("height", tamanhoTitleBar+"px");
        $(".titulo").css("top", centro+"px");
    });

    $(window).resize(function(){
        if($(document).width() >= 992){
            $(".nav-admin").removeAttr("style");
            $(".icon-nav").removeAttr("style");
            $(".lbl-nav").addClass("hidden-xs hidden-sm");
        }

        tamanhoNav = $(".nav-admin").width();
        tamanhoTitleBar = $(".top-header").outerHeight(true);

        var centro = (tamanhoTitleBar / 2) - ($(".titulo").height() / 2);
        
		$(".corpo").css({
			"margin-top": tamanhoTitleBar+"px",
			"margin-left": tamanhoNav+"px"
        });
        
        $("#nav-row").css("margin-left", tamanhoNav+15+"px");
        $(".header-admin").css("height", tamanhoTitleBar+"px");
        $(".titulo").css("top", centro+"px");
    });
}