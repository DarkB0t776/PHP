const categoryType = "Category name can only consist of A-Z,a-z";
const categoryLength =
  "Category name should not be less than 3 or greater than 30 characters";

const categoryExists = "Category already exists";

const roleCreated = "Role created";
const roleUpdated = "Role updated";
const roleType = "Role name can only consist of A-Z,a-z";
const roleLength =
  "Role name should not be less than 3 or greater than 50 characters";

const roleExists = "Role already exists";

$(document).ready(() => {
  $("#create").click(() => {
    let name = $("#name").val();

    $.ajax({
      type: "POST",
      url: "process.php",
      data: `name=${name}`,
      success: code => {
        if (code === "category_success") {
          $("#message").html(
            '<div class="message__success">Category Created</div>'
          );
          window.location.href = "index.php";
        } else if (code === "category_type") {
          $("#message").html(
            `<div class="message__error">${categoryType}</div>`
          );
        } else if (code === "category_length") {
          $("#message").html(
            `<div class="message__error">${categoryLength}</div>`
          );
        } else if (code === "category_exists") {
          $("#message").html(
            `<div class="message__error">${categoryExists}</div>`
          );
        } else if (code === "role_created") {
          $("#message").html(
            `<div class="message__success">${roleCreated}</div>`
          );
          window.location.href = "index.php";
        } else if (code === "role_type") {
          $("#message").html(`<div class="message__error">${roleType}</div>`);
        } else if (code === "role_length") {
          $("#message").html(`<div class="message__error">${roleLength}</div>`);
        } else if (code === "role_exists") {
          $("#message").html(`<div class="message__error">${roleExists}</div>`);
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
