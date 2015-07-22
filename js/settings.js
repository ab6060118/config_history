$(function() {
    var OCAdminActivity = {};

    OCAdminActivity.init = {
    };

    OCAdminActivity.Filter = {
        filter: 'admin_activity',
        currentPage: 0,
    };

    OCAdminActivity.Operation = {
        content: $('#activity_list'),

        getActivities: function() {
            OCAdminActivity.Filter.currentPage++;

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
                } else if(data.length) {
                } else {
                }
            });
        },

        appendContent: function(activities) {
            // console.dir(activity);
            $.each(activities, function(key, activity) {
                var row = $('<tr>');
                row.append($('<td>').text(activity.subjectformatted.trimmed));
                row.append($('<td>').text(activity.timestamp));
                OCAdminActivity.Operation.content.append(row);
                console.dir(activity.subjectformatted);
            });
        },
    };

    OCAdminActivity.View = {
    };

    OCAdminActivity.Operation.getActivities();
});
