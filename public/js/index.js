$("#myCarousel").hover(
        function () {
            $(".carousel-indicators li").css("visibility", "visible");
            $(".carousel-indicators .active").css("visibility", "visible");
        }, function () {
    $(".carousel-indicators li").css("visibility", "hidden");
});




