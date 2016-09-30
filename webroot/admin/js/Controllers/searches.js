jQuery(function($) {
    var headers = $('.search-active');
    var i = 1;
    setTimeout(function(){
        var colorchanger = setInterval(function(){
            if (i%2 === 0) {
                headers.css({
                    'opacity': '1'
                });
            } else {
                headers.css({
                    'opacity': '0.6'
                });
            };
            i++;
            if (i === 7) {
                clearInterval(colorchanger);
            }
        }, 100);
    }, 300);
});