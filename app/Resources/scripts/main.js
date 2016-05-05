$(".offer-count.counter").counterUp({
    delay: 10,
    time: 1000
});

/**
 * Toggle gender buttons
 */
$('.gender-input button').click(function() {
    $(this).toggleClass('active');
    $('#'+$(this).attr('for')).click();
});