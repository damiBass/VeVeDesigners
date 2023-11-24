document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("contact-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      var formData = new FormData(this);

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "contact.php", true);

      xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);
            var messageAlert = "alert-" + data.type;
            var messageText = data.message;

            var alertBox =
              '<div class="alert ' +
              messageAlert +
              ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
              messageText +
              "</div>";

            if (messageAlert && messageText) {
              document
                .getElementById("contact-form")
                .querySelector(".messages").innerHTML = alertBox;
              document.getElementById("contact-form").reset();
            }
          } else {
            console.error("Error HTTP:", xhr.status);
          }
        }
      };

      xhr.send(formData);
    });
});
