const commentLength =
  'Comment should not be less than 2 or greater than 200 characters';

$(document).ready(() => {
  $('#post').click(() => {
    let content = $('#content').val();
    let authorId = $('#author_id').val();
    let postId = $('#post_id').val();

    $.ajax({
      type: 'POST',
      url: '/ajax/process_comment.php',
      data: `content=${content}&user_id=${authorId}&post_id=${postId}`,
      success: code => {
        if (code === 'posted') {
          $('#message').html(
            '<div class="message__success">Comment Posted Successfully</div>'
          );
          location.reload();
        } else if (code === 'comment_length') {
          $('#message').html(
            `<div class="message__error">${commentLength}</div>`
          );
        }
      }
    });
    return false;
  });
});
