$(document).ready(function() {
    init();
});

function init() {
    const $body = $(document);
    const $loginForm = $body.find('.login-form');
    const action = $loginForm.attr('action');
    const method = $loginForm.attr('method');

    $loginForm.on('submit', function(ev){
        /*ev.preventDefault();
        formData = $loginForm.serialize();
        console.log(formData);
        $.ajax({
            url: action,
            method: method,
            success: function(data) {
                console.log(data);
            }
        });*/
    })
}