$(document).ready(() => {
  $("#create").click(() => {
    let name = $("#name").val();

    $.ajax({
      type: "POST",
      url: "process.php",
      data: `name=${name}`,
      success: code => {
        if (code === "success") {
          $("#message").html(
            '<div class="message__success">Category Created</div>'
          );
          window.location.href = "index.php";
        } else if (code === "type") {
          $("#message").html(
            '<div class="message__error">Category name can only consist of A-Z,a-z</div>'
          );
        } else if (code === "length") {
          $("#message").html(
            '<div class="message__error">Category name should not be less than 3 or greater than 30 characters</div>'
          );
        } else if (code === "exists") {
          $("#message").html(
            '<div class="message__error">Category already exists</div>'
          );
        } else {
          $("#message").html(
            '<div class="message__error">Something went wrong</div>'
          );
        }
      },
      beforeSend: () => {
        $("#message").html("loading...");
      }
    });
    return false;
  });
});
