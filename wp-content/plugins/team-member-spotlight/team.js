jQuery(document).ready(function ($) {
    $('#team-member-form').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        const data = {
            action: 'add_team_member',
            nonce: team_ajax.nonce,
            name: form.find('[name="name"]').val(),
            position: form.find('[name="position"]').val(),
            bio: form.find('[name="bio"]').val(),
            featured_until: form.find('[name="featured_until"]').val()
        };

        $.post(team_ajax.ajax_url, data, function (response) {
            const msg = $('#team-message');
            msg.html(response.data).css('color', response.success ? 'green' : 'red');
            if (response.success) {
                form[0].reset();
                setTimeout(() => location.reload(), 1000);
            }
        });
    });
});
