OCAdminActivity = {
};
$(document).ready(function() {
    $.ajax({
        url:OC.generateUrl('/apps/ownnotes/fetch'),
        data: { filter: 'all', page: '1'},
        method:'GET',
    })
    .done(function(data) {
        console.dir(data);
    });
});
