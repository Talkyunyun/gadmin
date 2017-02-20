$(function() {
    $('.openwin').click(function() {
        var url = $(this).attr('data-url');
        var name = $(this).attr('data-name');
        layer.open({
            type: 2,
            title: name,
            shadeClose: false,
            shade: 0.8,
            area: ['800px', '90%'],
            content: url
        });
    });
});