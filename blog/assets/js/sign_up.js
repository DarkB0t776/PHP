const unExists = 'Username already exists';
const unFormat = 'Username can only consist of A-Z,a-z and 0-9';
const unLength =
  'Username should not be less than 4 or greater than 30 characters';

const emExists = 'Email already exists';
const emFormat = 'Email is invalid';
const emLength = 'Email should not be greater than 100 characters';

$(document).ready(() => {
  $('#submit').click(() => {
    let username = $('#username').val();
    let email = $('#email').val();
    let pass = $('#password').val();

    $.ajax({
      type: 'POST',
      url: '/ajax/process_signup.php',
      data: `username=${username}&email=${email}&password=${pass}`,
      success: code => {
        if (code === 'signup') {
          $('#message').html(
            '<div class="message__success">Sign Up Successfully</div>'
          );
          window.location.href = '/';
        } else if (code === 'unExists') {
          $('#message').html(`<div class="message__error">${unExists}</div>`);
        } else if (code === 'unFormat') {
          $('#message').html(`<div class="message__error">${unFormat}</div>`);
        } else if (code === 'unLength') {
          $('#message').html(`<div class="message__error">${unLength}</div>`);
        } else if (code === 'emExists') {
          $('#message').html(`<div class="message__error">${emExists}</div>`);
        } else if (code === 'emFormat') {
          $('#message').html(`<div class="message__error">${emFormat}</div>`);
        } else if (code === 'emLength') {
          $('#message').html(`<div class="message__error">${emLength}</div>`);
        } else {
          $('#message').html(
            '<div class="message__error">Something went wrong</div>'
          );
        }
      }
    });

    return false;
  });
});
