$(document).ready(function() {

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

    /**
     * Set gender checkbox when button clicked
     */
    $('.male').click(function() {
        $('male-checkbox').click();
    });

    $('.female').click(function() {
        $('female-checkbox').click();
    });

    if ($('.male-checkbox').is(':checked')) {
        $('.male').addClass('active');
        console.log('1');
    }

    if ($('.female-checkbox').is(':checked')) {
        $('.female').addClass('active');
        console.log('2');
    }
});