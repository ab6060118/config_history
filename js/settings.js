$(document).ready(function() {
    var OCConfigurationHistory = {};

    OCConfigurationHistory.init = function() {
        $('#lesshistory').hide();
        $('#nomoremsg').hide();
        OCConfigurationHistory.Operation.loading.hide();
        OCConfigurationHistory.Operation.getActivities();
    };

    OCConfigurationHistory.Filter = {
        filter: 'configuration_history',
        currentPage: 0,
        pageSize: 5,
    };

    OCConfigurationHistory.Operation = {
        content: $('#configuration_history'),
        loading: $('#loading_configuration'),

        getActivities: function() {
            OCConfigurationHistory.Filter.currentPage++;

            OCConfigurationHistory.Operation.loading.show();
            $('#morehistory').attr({disabled: 'disabled'});
            
            $.ajax({
                url:OC.generateUrl('/apps/ownnotes/fetch'),
                method:'GET',
                data: {
                    filter: OCConfigurationHistory.Filter.filter,
                    page: OCConfigurationHistory.Filter.currentPage,
                },
            })
            .done(function(data) {
                if(data.length < OCConfigurationHistory.Filter.pageSize) {
                    $('#morehistory').hide();
                    $('#nomoremsg').show();
                }

                OCConfigurationHistory.Operation.appendContent(data);
            });

            if(OCConfigurationHistory.Filter.currentPage > 1) {
                $('#lesshistory').show();
            }
        },

        appendContent: function(activities) {
            // console.dir(activity);
            $.each(activities, function(key, activity) {
                // console.dir(activity);
                var date = new Date(activity.timestamp*1000);
                var row = $('<tr>');
                row.append($('<td>').html(activity.subjectformatted.full));
                row.append($('<td>').text(date.toLocaleDateString()+' '+date.toString().match(/\d\d:\d\d:\d\d/)));
                OCConfigurationHistory.Operation.content.append(row);
            });

            OCConfigurationHistory.Operation.loading.hide();
            $('#morehistory').removeAttr('disabled');
        },

        getMore: function() {
            OCConfigurationHistory.Operation.getActivities()
        },

        showLess: function() {
            OCConfigurationHistory.Filter.currentPage--;
            OCConfigurationHistory.Operation.content.find('tr').slice(OCConfigurationHistory.Filter.pageSize * OCConfigurationHistory.Filter.currentPage).remove();
            if(OCConfigurationHistory.Filter.currentPage == 1) {
                $('#lesshistory').hide();
            }

            $('#morehistory').show();
            $('#nomoremsg').hide();
        },
    };

    OCConfigurationHistory.View = {
    };


    OCConfigurationHistory.init();

    $('#morehistory').on('click', function() {
        OCConfigurationHistory.Operation.getMore();
    });

    $('#lesshistory').on('click', function() {
        OCConfigurationHistory.Operation.showLess();
    });
});
