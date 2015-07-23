$(function() {
    var OCAdminActivity = {};

    OCAdminActivity.init = function() {
        $('#lessadminacvitity').hide();
        OCAdminActivity.Operation.getActivities();
    };

    OCAdminActivity.Filter = {
        filter: 'admin_activity',
        currentPage: 0,
    };

    OCAdminActivity.Operation = {
        content: $('#activity_list'),

        getActivities: function() {
            OCAdminActivity.Filter.currentPage++;
            console.dir(OCAdminActivity.Filter.currentPage);

            $.ajax({
                url:OC.generateUrl('/apps/ownnotes/fetch'),
                method:'GET',
                data: {
                    filter: OCAdminActivity.Filter.filter,
                    page: OCAdminActivity.Filter.currentPage,
                },
            })
            .done(function(data) {
                if(data.length) {
                    OCAdminActivity.Operation.appendContent(data);
                } else {
                }
            });

            if(OCAdminActivity.Filter.currentPage > 1) {
                $('#lessadminacvitity').show();
            }
        },

        appendContent: function(activities) {
            // console.dir(activity);
            $.each(activities, function(key, activity) {
                var date = new Date(activity.timestamp*1000);
                var row = $('<tr>');
                row.append($('<td>').html(activity.subjectformatted.markup.trimmed));
                row.append($('<td>').text(date.toLocaleDateString()+' '+date.toString().match(/\d\d:\d\d:\d\d/)));
                OCAdminActivity.Operation.content.append(row);
            });
        },

        getMore: function() {
            OCAdminActivity.Operation.getActivities()
        },

        showLess: function() {
            OCAdminActivity.Filter.currentPage--;
            OCAdminActivity.Operation.content.find('tr').slice(5*OCAdminActivity.Filter.currentPage).remove();
            if(OCAdminActivity.Filter.currentPage == 1) {
                $('#lessadminacvitity').hide();
            }
        },
    };

    OCAdminActivity.View = {
    };


    $(document).ready(function() {
        OCAdminActivity.init();
        $('#moreadminacvitity').on('click', function() {
            OCAdminActivity.Operation.getMore();
        });
        $('#lessadminacvitity').on('click', function() {
            OCAdminActivity.Operation.showLess();
        });
    });
});

