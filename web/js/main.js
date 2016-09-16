$(function () {
    $.getJSON('/orders/getAllowedDateTime', [], function (response) {
        $('input[type="datetime"]')
            .datetimepicker( "destroy" )
            .datetimepicker({
                format: "Y-m-d H:i",
                timepicker: true,
                datepicker: true,
                disabledWeekDays: getDisabledWeekDays(response.allowedWeekDays),
                inline: true,
                sideBySide: true,
                allowTimes: response.allowedTimes
            });
    });

    function getDisabledWeekDays(allowedWeekDays) {
        var weekDays = Array.apply(null, {length: 7}).map(Number.call, Number);

        return weekDays.filter(function(x) { return allowedWeekDays.indexOf(x) < 0 });
    }
});