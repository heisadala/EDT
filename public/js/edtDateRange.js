$(document).ready(function () {

    moment.updateLocale('fr',
        {
            months: [
                "Janvier",
                "Fevrier",
                "Mars",
                "Avril",
                "Mai",
                "Juin",
                "Juillet",
                "Aout",
                "Septembre",
                "Octobre",
                "Novembre",
                "Decembre"
            ],
        }
    );
    var start = moment().subtract(364, 'days');
    var end = moment();
    var label = 'init';

    function cb(start, end, label) {
        console.log("A new date selection was made: " + label + ': ' + start.format('DD MMMM YYYY') + ' to ' + end.format('DD MMMM YYYY'));
        document.getElementById("startDate").innerHTML = start.format('DD/MM/YYYY');
        document.getElementById("endDate").innerHTML = end.format('DD/MM/YYYY');
        $('#reportrange span').html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY'));
        console.log(location);
    }


//   $('input[name="daterange"]').daterangepicker({
    $('#reportrange').daterangepicker({
        opens: 'left',
        showDropdowns: true,
        applyButtonClasses: "btn-success",
        autoApply: false,
        ranges: {
            'DERNIERS 7 JOURS': [moment().subtract(6, 'days'), moment()],
            'DERNIERS 30 JOURS': [moment().subtract(29, 'days'), moment()],
            'CE MOIS CI': [moment().startOf('month'), moment().endOf('month')],
            'LE MOIS DERNIER': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'MOIS': [moment().subtract(11, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'ANNEE': [moment().subtract(1, 'year').startOf('year'), moment().endOf('year')],
        },
        locale: {
            format: "DD/MM/YYYY",
            separator: " - ",
            applyLabel: "Apply",
            cancelLabel: "Cancel",
            fromLabel: "De",
            toLabel: "à",
            customRangeLabel: "Periode",
            weekLabel: "S",
            daysOfWeek: [
                "Di",
                "Lu",
                "Ma",
                "Me",
                "Je",
                "Ve",
                "Sa"
            ],
            monthNames: [
                "Janvier",
                "Fevrier",
                "Mars",
                "Avril",
                "Mai",
                "Juin",
                "Juillet",
                "Aout",
                "Septembre",
                "Octobre",
                "Novembre",
                "Decembre"
            ],
            firstDay: 1
        },
        startDate: start,
        endDate: end,
        minDate: '01/01/2024',
        maxDate: moment(),

  }, cb);

  cb(start, end, label);

});

