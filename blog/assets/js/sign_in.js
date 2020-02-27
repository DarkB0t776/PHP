const incorrectData = 'Username or Password is incorrect';

$(document).ready(() => {
  $('#submit').click(() => {
    let username = $('#username').val();
    let pass = $('#password').val();

    $.ajax({
      type: 'POST',
      url: '/ajax/process_signin.php',
      data: `username=${username}&password=${pass}`,
      success: code => {
        if (code === 'signin') {
          $('#message').html(
            '<div class="message__success">Sign In Successfully</div>'
          );
          window.location.href = '/';
        } else if (code === 'incorrect_data') {
          $('#message').html(
            `<div class="message__error">${incorrectData}</div>`
          );
        }
      }
    });
    return false;
  });
});
