// Age input popover

$('#age').popover({
    content: $('#popover-content').html(),
    html: true
}).click(function() {
    $('.button-container').click(function () {
        $('#age').val($(this).text()).popover('hide');
        if (typeof markers !== undefined) {
            ajaxUpdate();
        }
    });
});

$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});