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
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            // Manejar la respuesta del servidor
            if (
              xhr.responseText.includes(
                "El formulario de contacto se envió con éxito."
              )
            ) {
              // Éxito, puedes realizar las acciones necesarias
              console.log("Formulario enviado con éxito");
              document
                .getElementById("contact-form")
                .querySelector(".messages").innerHTML = xhr.responseText;
              document.getElementById("contact-form").reset();

              // Recargar la página y volver al inicio después de un breve retraso (por ejemplo, 1 segundo)
              setTimeout(function () {
                location.reload();
                // O puedes usar location.href = "#inicio"; si tienes un ancla con el id "inicio"
              }, 1000);
            } else {
              // La respuesta no coincide con el éxito esperado
              console.error("Error: La respuesta no es la esperada.");
            }
          } else {
            // Manejar errores de HTTP
            console.error("Error HTTP:", xhr.status);
          }
        }
      };

      // Enviar la solicitud con los datos del formulario
      xhr.send(formData);
    });
});
