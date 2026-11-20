/**
 * Webokids - cuenta regresiva del template de ventas (templates/sales-template.php).
 *
 * Fuente:      js/partials/sales-countdown.js
 * Minificado:  js/partials-min/sales-countdown.min.js
 * Compilar:    php ditto build:partial-js sales-countdown   (o npm run build:js)
 *
 * Lee la fecha de .date-init y los textos de data-labels en #countdown.
 */
(function ($, document) {
    'use strict';

    var countdown = document.getElementById('countdown');
    var input = document.querySelector('.date-init');
    if (countdown === null || input === null) return;

    // ACF puede entregar el mes en español ("Dic 24, 2025 23:59:59").
    var monthMap = {
        Ene: 'Jan', Feb: 'Feb', Mar: 'Mar', Abr: 'Apr', May: 'May', Jun: 'Jun',
        Jul: 'Jul', Ago: 'Aug', Sep: 'Sep', Oct: 'Oct', Nov: 'Nov', Dic: 'Dec'
    };

    function parseDate(value) {
        var match = value.match(/^(...)\s(\d{1,2}),\s(\d{4})\s(\d{2}):(\d{2}):(\d{2})$/);
        if (match && monthMap[match[1]]) {
            value = monthMap[match[1]] + ' ' + match[2] + ', ' + match[3] + ' ' + match[4] + ':' + match[5] + ':' + match[6];
        }
        return new Date(value).getTime();
    }

    function pad(number) {
        return number <= 9 ? '0' + number : String(number);
    }

    var labels = $(countdown).data('labels') || { days: 'Días', hours: 'Horas', minutes: 'Minutos', seconds: 'Segundos' };
    var end = parseDate(input.value.trim());
    var timer = null;

    function item(value, label, labelClass) {
        return '<div class="item-count"><span>' + value + '</span><br><span' + (labelClass ? ' class="' + labelClass + '"' : '') + '>' + label + '</span></div>';
    }

    function tick() {
        var distance = end - Date.now();

        if (isNaN(distance) || distance < 0) {
            if (timer) clearInterval(timer);
            $('.count-down').addClass('d-none');
            $('.products-list').addClass('d-none');
            $('.closed-off').removeClass('d-none').find('.galleries').trigger('refresh.owl.carousel');
            return false;
        }

        var days = Math.floor(distance / 86400000);
        var hours = Math.floor((distance % 86400000) / 3600000);
        var minutes = Math.floor((distance % 3600000) / 60000);
        var seconds = Math.floor((distance % 60000) / 1000);

        countdown.innerHTML =
            item(pad(days), labels.days) +
            item(pad(hours), labels.hours, 'h-m') +
            item(pad(minutes), labels.minutes, 'h-m') +
            item(pad(seconds), labels.seconds, 'h-m');
        return true;
    }

    $(function () {
        $('.products-list .woocommerce').addClass('row');
        $('.products-list .woocommerce a').addClass('col-6 col-md-4 col-lg-3 mb-4');

        if (tick()) {
            timer = setInterval(tick, 1000);
        }
    });
})(jQuery, document);
