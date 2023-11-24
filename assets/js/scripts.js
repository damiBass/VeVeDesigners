window.addEventListener("load", function () {
  /* =============================================================================
      -----------------------------  Contact Validation   -----------------------------
      ============================================================================= */

  document
    .getElementById("contact-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      // Crear un objeto FormData con los datos del formulario
      var formData = new FormData(this);

      // Crear una instancia de XMLHttpRequest
      var xhr = new XMLHttpRequest();

      // Configurar la solicitud
      xhr.open("POST", "contact.php", true);

      // Configurar el manejo de la respuesta
      xhr.onreadystatechange = function () {
        console.log(xhr.responseText);
        if (xhr.readyState == 4 && xhr.status == 200) {
          // Manejar la respuesta del servidor
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
        }
      };

      // Enviar la solicitud con los datos del formulario
      xhr.send(formData);
    });
});
