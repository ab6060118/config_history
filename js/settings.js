$(document).ready(function() {
    var OCConfigurationHistory = {};

    OCConfigurationHistory.init = function() {
        OCConfigurationHistory.View.lessBtn.hide();
        OCConfigurationHistory.View.noMoreMsg.hide();
        OCConfigurationHistory.View.loading.hide();
        OCConfigurationHistory.Operation.getActivities();
    };

    OCConfigurationHistory.Filter = {
        filter: 'configuration_history',
        currentPage: 0,
        pageSize: 5,
    };

    OCConfigurationHistory.Operation = {
        getActivities: function() {
            OCConfigurationHistory.Filter.currentPage++;

            OCConfigurationHistory.View.loading.show();
            OCConfigurationHistory.View.moreBtn.attr({disabled: 'disabled'});
            
            $.ajax({
                url:OC.generateUrl('/apps/config_history/fetch'),
                method:'GET',
                data: {
                    filter: OCConfigurationHistory.Filter.filter,
                    page: OCConfigurationHistory.Filter.currentPage,
                },
            })
            .done(function(data) {
                if(data.length < OCConfigurationHistory.Filter.pageSize) {
                    OCConfigurationHistory.View.moreBtn.hide();
                    OCConfigurationHistory.View.noMoreMsg.show();
                }

                OCConfigurationHistory.Operation.appendContent(data);
            });

            if(OCConfigurationHistory.Filter.currentPage > 1) {
                OCConfigurationHistory.View.lessBtn.show();
            }
        },

        appendContent: function(activities) {
            $.each(activities, function(key, activity) {
                console.dir(activity);
                var date = new Date(activity.timestamp*1000);
                var row = $('<tr>');

                date = date.toLocaleDateString() + ' ' + date.toString().match(/\d\d:\d\d:\d\d/);
                row.append($('<td>').html(activity.subjectformatted.full));
                row.append($('<td>').text(date));
                OCConfigurationHistory.View.content.append(row);
            });

            OCConfigurationHistory.View.loading.hide();
            OCConfigurationHistory.View.moreBtn.removeAttr('disabled');
        },

        getMore: function() {
            OCConfigurationHistory.Operation.getActivities();
        },

        showLess: function() {
            OCConfigurationHistory.Filter.currentPage--;
            OCConfigurationHistory.View.content.find('tr').slice(OCConfigurationHistory.Filter.pageSize * OCConfigurationHistory.Filter.currentPage).remove();
            if(OCConfigurationHistory.Filter.currentPage === 1) {
                OCConfigurationHistory.View.lessBtn.hide();
            }

            OCConfigurationHistory.View.moreBtn.show();
            OCConfigurationHistory.View.noMoreMsg.hide();
        },
    };

    OCConfigurationHistory.View = {
        content: $('#configuration_history'),
        loading: $('#loading_configuration'),
        moreBtn: $('#morehistory'),
        lessBtn: $('#lessBtn'),
        noMoreMsg: $('#nomoremsg'),
    };


    OCConfigurationHistory.init();

    OCConfigurationHistory.View.moreBtn.on('click', function() {
        OCConfigurationHistory.Operation.getMore();
    });

    OCConfigurationHistory.View.lessBtn.on('click', function() {
        OCConfigurationHistory.Operation.showLess();
    });
});
