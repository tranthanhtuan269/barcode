function search() {
    let search = $('#search-input').val();
    search = search.trim();

    if (search.length > 0) {
        var data = {
            search: search
        };

        $.ajax({
            url: "/ajax/search",
            data: data,
            success: function(response) {
                $('.dropdown-result-search').show();
                $('.dropdown-result-search ul').html('');
                $('.dropdown-result-search ul').addClass('list-item');
                $.each(response.results, function (key, val) {
                    if(key<3) {
                        var link = "/" + val.slug ;
                        $('.dropdown-result-search ul').append('<li><a class= "text-1-line" href="'+ link +'">'+ val.title +'</a></li>');
                    }
                });
                let url = "/search?" + "search=" + search;
                if(response.results.length > 3) {
                    $('.dropdown-result-search ul').append('<li><a href = "'+ url +'" class="text-warning">'+ (response.results.length - 3) + '  other results' + '</a></li>');
                }
                if(response.results.length < 1) {
                    $('.dropdown-result-search ul').append('<li class="text-danger">No results found</li>');
                }
            },
            error: function(data) {
            }
        });
    }
}

function delay(callback, ms) {
    let timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
        callback.apply(context, args);
        }, ms || 0);
    };
}

$('#search-input').keyup(delay(function (e) {
    search()
}, 500));

$("#search-input").keyup(function(e){
    var code = e.key
    if(code==="Enter") e.preventDefault()
    let search_input = $('#search-input').val()
    search_input = search_input.trim()
    if(search_input.length >= 1) {
        if(code==="Enter"){
            window.location.href = "/search?" + "search=" + search_input
        }
    }
});

$(".btn-search").click(function(e){
    let search_input = $('#search-input').val()
    search_input = search_input.trim()
    window.location.href = "/search?" + "search=" + search_input
});

$("body").mouseup(function(e) {
    var subject = $("#dropdown-result")
    if (e.target.id != subject.attr('id') && !subject.has(e.target).length) {
        $('.dropdown-result-search').hide()
    }
})