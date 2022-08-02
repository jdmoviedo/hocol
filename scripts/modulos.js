$("#dtModulos")
  .on("init.dt", function () {})
  .DataTable({
    data: "",
    columns: [
      {
        title: "ID MODULO",
        className: "text-center text-nowrap",
        responsivePriority: 1,
      },
      {
        title: "MODULO",
        className: "text-center text-nowrap",
        responsivePriority: 1,
      },
      {
        title: "DESCRIPCION",
        className: "text-center text-nowrap",
        responsivePriority: 1,
      },
      {
        title: "ICONO",
        className: "text-center text-nowrap",
        responsivePriority: 1,
      },
      {
        title: "ESTADO",
        className: "text-center text-nowrap",
        responsivePriority: 1,
      },
      {
        title: "",
        className: "text-center text-nowrap",
        responsivePriority: 1,
      },
    ],
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "Todos"],
    ],
    responsive: true,
    ordering: false,
    language: {
      url: urlBase + "scripts/plugins/datatable/language/Spanish.json",
    },
    // createdRow: function (row, data, index) {
    //   if (index % 2) {
    //     $(row).addClass("bg-blue");
    //   }
    // },
  });
$("#dtModulos").on("draw.dt", function () {
  $(".loader").fadeOut("slow");
});

let edit = false;

$(document).ready(function () {
  buscar_registros();
});

function buscar_registros() {
  $("#dtModulos").DataTable().clear();
  $.ajax({
    data: {
      peticion: "buscarModulos",
    }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "php/controller/controller_modulos.php", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      $(".overlayCargue").fadeIn("slow");
    },
    success: function (result) {
      var estado = result.status;
      switch (estado) {
        case "1":
          $("#dtModulos").DataTable().rows.add(result.datos).draw();
          break;
        case "0":
          $("#dtModulos").DataTable().draw();
          $.toast({
            heading: "Información!",
            text: "Sin registros",
            showHideTransition: "slide",
            icon: "info",
            position: "top-right",
          });
          break;
        default:
      }
    },
    complete: function () {
      setTimeout(() => {
        $(".overlayCargue").fadeOut("slow");
      }, 1000);
      $("#dtModulos").DataTable().responsive.recalc();
    },
    error: function (xhr) {
      console.log(xhr);
      Swal.fire({
        icon: "error",
        title: "<strong>Error!</strong>",
        html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
        showCloseButton: true,
        showConfirmButton: false,
        cancelButtonText: "Cerrar",
        cancelButtonColor: "#dc3545",
        showCancelButton: true,
        backdrop: true,
      });
    },
  });
}

function registrar(form) {
  var respuestavalidacion = validarcampos("#" + form);
  if (respuestavalidacion) {
    var formData = new FormData(document.getElementById(form)); //necesario para enviar archivos
    if (edit == true) {
      formData.append("peticion", "editarModulo");
    } else {
      formData.append("peticion", "crearModulo");
    }
    $.ajax({
      cache: false, //necesario para enviar archivos
      contentType: false, //necesario para enviar archivos
      processData: false, //necesario para enviar archivos
      data: formData, //necesario para enviar archivos
      dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
      url: urlBase + "php/controller/controller_modulos.php", //url a donde hacemos la peticion
      type: "POST",
      beforeSend: function () {
        $(".overlayCargue").fadeIn("slow");
      },
      complete: function () {
        setTimeout(() => {
          $(".overlayCargue").fadeOut("slow");
        }, 1000);
      },
      success: function (result) {
        var estado = result.status;
        switch (estado) {
          case "0":
            Swal.fire({
              icon: "error",
              title: "<strong>Error!</strong>",
              html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
              showCloseButton: true,
              showConfirmButton: false,
              cancelButtonText: "Cerrar",
              cancelButtonColor: "#dc3545",
              showCancelButton: true,
              backdrop: true,
            });
            break;
          case "1":
            if (edit == false) {
              Swal.fire({
                icon: "success",
                title: "<strong>Modulo Creado</strong>",
                html: "<h5>El modulo se ha registrado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            } else {
              Swal.fire({
                icon: "success",
                title: "<strong>Modulo Editado</strong>",
                html: "<h5>El modulo se ha editado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            }
            reset();
            $("#ModalRegistro").modal("hide");
            buscar_registros();
            break;
          case "2":
            $.toast({
              heading: "Error!",
              text: "Ya existe un Modulo con este nombre",
              showHideTransition: "slide",
              icon: "info",
              position: "top-right",
            });
            break;
          case "3":
            $.toast({
              heading: "Error!",
              text: "Ya existe esta posición",
              showHideTransition: "slide",
              icon: "info",
              position: "top-right",
            });
            break;
          default:
            // Code
            break;
        }
      },
      error: function (xhr) {
        console.log(xhr);
        Swal.fire({
          icon: "error",
          title: "<strong>Error!</strong>",
          html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
          showCloseButton: true,
          showConfirmButton: false,
          cancelButtonText: "Cerrar",
          cancelButtonColor: "#dc3545",
          showCancelButton: true,
          backdrop: true,
        });
      },
    });
  }
}

function editar_registro(id) {
  edit = true;
  datos_registro(id);
}

function datos_registro(id) {
  $.ajax({
    data: {
      peticion: "datosModulo",
      id_modulo: id,
    }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "php/controller/controller_modulos.php", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      $(".overlayCargue").fadeIn("slow");
    },
    success: function (result) {
      var estado = result.status;
      switch (estado) {
        case "0":
          Swal.fire({
            title: "Error!",
            text: "Se ha presentado un error, comuniquese con el area de sistemas.",
            icon: "error",
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonColor: "#d33",
            cancelButtonText: "Cerrar!",
          });
          break;
        case "1":
          if (edit == false) {
            $("#ModalRegistro").find("h5.modal-title").html("Ver Modulo");
            $("#btnRegistro").hide();
            $("#btnRegistro").text("Registrar");
            $("#btnRegistro").attr("onclick", "");
            vercampos("#frmRegistro", 2);
          } else {
            $("#ModalRegistro").find("h5.modal-title").html("Editar Modulo");
            $("#btnRegistro").show();
            $("#btnRegistro").text("Editar");
            $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
          }
          $("#id_modulo").val(result.id_modulo);
          $("#modulo").val(result.modulo);
          $("#descripcion").val(result.descripcion);
          $("#icono").val(result.icono);
          $("#ModalRegistro").modal("show");
          break;
        case "2":
          $.toast({
            heading: "Información!",
            text: "Sin datos",
            showHideTransition: "slide",
            icon: "info",
            position: "top-right",
          });
          break;
        default:
          break;
      }
    },
    complete: function () {
      setTimeout(() => {
        $(".overlayCargue").fadeOut("slow");
      }, 1000);
    },
    error: function (xhr) {
      console.log(xhr);
      Swal.fire({
        icon: "error",
        title: "<strong>Error!</strong>",
        html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
        showCloseButton: true,
        showConfirmButton: false,
        cancelButtonText: "Cerrar",
        cancelButtonColor: "#dc3545",
        showCancelButton: true,
        backdrop: true,
      });
    },
  });
}

function cambiar_estado(id, estado) {
  $.ajax({
    data: {
      peticion: "cambiarEstado",
      id_modulo: id,
      estado: estado,
    }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "php/controller/controller_modulos.php", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      $(".overlayCargue").fadeIn("slow");
    },
    success: function (result) {
      var estado = result.status;
      switch (estado) {
        case "0":
          Swal.fire({
            title: "Error!",
            text: "Se ha presentado un error, comuniquese con el area de sistemas.",
            icon: "error",
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonColor: "#d33",
            cancelButtonText: "Cerrar!",
          });
          break;
        case "1":
          Swal.fire({
            title: "Cambio de Estado Satisfactorio",
            text: "",
            icon: "success",
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonColor: "#d33",
            cancelButtonText: "Cerrar!",
          });
          buscar_registros();
          break;
        default:
          break;
      }
    },
    complete: function () {
      setTimeout(() => {
        $(".overlayCargue").fadeOut("slow");
      }, 1000);
    },
    error: function (xhr) {
      console.log(xhr);
      Swal.fire({
        icon: "error",
        title: "<strong>Error!</strong>",
        html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
        showCloseButton: true,
        showConfirmButton: false,
        cancelButtonText: "Cerrar",
        cancelButtonColor: "#dc3545",
        showCancelButton: true,
        backdrop: true,
      });
    },
  });
}

function showModalRegistro() {
  $("#ModalRegistro").find("h5.modal-title").html("Crear Modulo");
  $("#btnRegistro").show();
  $("#btnRegistro").text("Registrar");
  $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
  $("#ModalRegistro").modal("show");
}

function reset() {
  vercampos("#frmRegistro", 1);
  limpiarcampos("#frmRegistro");
  edit = false;
}
