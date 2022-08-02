$("#dtUsuarios")
  .on("init.dt", function () {})
  .DataTable({
    data: "",
    columns: [
      {
        title: "ID USUARIO",
        className: "text-center text-nowrap",
        responsivePriority: 1,
      },
      {
        title: "DOCUMENTO",
        className: "text-center text-nowrap",
        responsivePriority: 1,
      },
      {
        title: "NOMBRE COMPLETO",
        className: "text-center text-nowrap",
        responsivePriority: 1,
      },
      {
        title: "CORREO",
        className: "text-center text-nowrap",
        responsivePriority: 1,
      },
      {
        title: "TELEFONO",
        className: "text-center text-nowrap",
        responsivePriority: 2,
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
$("#dtUsuarios").on("draw.dt", function () {
  $(".loader").fadeOut("slow");
});

let edit = false;

$(document).ready(function () {
  cargar_select(
    "ModalAsignarSubmodulo",
    false,
    "selectHome",
    "cargarSubModulos",
    "Seleccione la Pagina de Inicio"
    // { modulo: 1 }
  );
  buscar_registros();
});

function buscar_registros() {
  $("#dtUsuarios").DataTable().clear();
  $.ajax({
    data: {
      peticion: "buscarUsuarios",
    }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "php/controller/controller_usuarios.php", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      $(".overlayCargue").fadeIn("slow");
    },
    success: function (result) {
      var estado = result.status;
      switch (estado) {
        case "1":
          $("#dtUsuarios").DataTable().rows.add(result.datos).draw();
          break;
        case "0":
          $("#dtUsuarios").DataTable().draw();
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
      $("#dtUsuarios").DataTable().responsive.recalc();
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
      formData.append("peticion", "editarUsuario");
      var contrasenias = true;
    } else {
      formData.append("peticion", "crearUsuario");
      var contrasenias = validarcontrasenias($("#password"), $("#password1"));
    }
    if (contrasenias) {
      $.ajax({
        cache: false, //necesario para enviar archivos
        contentType: false, //necesario para enviar archivos
        processData: false, //necesario para enviar archivos
        data: formData, //necesario para enviar archivos
        dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
        url: urlBase + "php/controller/controller_usuarios.php", //url a donde hacemos la peticion
        type: "POST",
        beforeSend: function () {
          if (edit == true) {
          } else {
          }

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
                  title: "<strong>Usuario Creado</strong>",
                  html: "<h5>El usuario se ha registrado exitosamente</h5>",
                  showCloseButton: false,
                  confirmButtonText: "Aceptar",
                  confirmButtonColor: "#64a19d",
                  backdrop: true,
                });
              } else {
                Swal.fire({
                  icon: "success",
                  title: "<strong>Usuario Editado</strong>",
                  html: "<h5>El usuario se ha editado exitosamente</h5>",
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
                text: "Ya existe un usuario con este documento",
                showHideTransition: "slide",
                icon: "error",
                position: "top-right",
              });
              break;
            case "3":
              $.toast({
                heading: "Error!",
                text: "Ya existe un usuario con este correo electronico",
                showHideTransition: "slide",
                icon: "error",
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
}

function editar_registro(id) {
  edit = true;
  datos_registro(id);
}

function datos_registro(id) {
  $.ajax({
    data: {
      peticion: "datosUsuario",
      id_usuario: id,
    }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "php/controller/controller_usuarios.php", //url a donde hacemos la peticion
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
            $("#ModalRegistro").find("h5.modal-title").html("Ver Usuario");
            $("#btnRegistro").hide();
            $("#btnRegistro").text("Registrar");
            $("#btnRegistro").attr("onclick", "");
            vercampos("#frmRegistro", 2);
          } else {
            $("#ModalRegistro").find("h5.modal-title").html("Editar Usuario");
            $("#btnRegistro").show();
            $("#btnRegistro").text("Editar");
            $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
          }
          $("#passwords").hide();
          $("#id_usuario").val(result.id_usuario);
          $("#primer_nombre").val(result.primer_nombre);
          $("#segundo_nombre").val(result.segundo_nombre);
          $("#primer_apellido").val(result.primer_apellido);
          $("#segundo_apellido").val(result.segundo_apellido);
          $("#documento").val(result.documento);
          $("#correo").val(result.correo);
          $("#telefono").val(result.telefono);
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
      id_usuario: id,
      estado: estado,
    }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "php/controller/controller_usuarios.php", //url a donde hacemos la peticion
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
  $("#ModalRegistro").find("h5.modal-title").html("Crear Usuario");
  $("#btnRegistro").show();
  $("#btnRegistro").text("Registrar");
  $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
  $("#passwords").show();
  $("#ModalRegistro").modal("show");
}

function reset() {
  vercampos("#frmRegistro", 1);
  limpiarcampos("#frmRegistro");
  edit = false;
}

function showModalAsignarSubmodulo(id) {
  $.ajax({
    data: {
      peticion: "cargarAsignacion",
      id_usuario: id,
    }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "php/controller/controller_usuarios.php", //url a donde hacemos la peticion
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
          $("#ModalAsignarSubmodulo")
            .find("h5.modal-title")
            .html("Asignar Submodulos");
          $("#btnRegistroAsignarSubmodulo").show();
          $("#btnRegistroAsignarSubmodulo").text("Asignar");
          $("#btnRegistroAsignarSubmodulo").attr(
            "onclick",
            "asignar_submodulo('frmRegistroAsignarSubmodulo'," + id + ");"
          );
          $("#modulos").html(result.html);
          $(".chkModulos").each(function (index) {
            new Switchery(this, {
              color: "#28B97B",
              secondaryColor: "#F5365C",
              speed: "0.6s",
              size: "small",
            });
          });

          $(".chkModulos").on("change", function () {
            if (this.checked) {
              $("#selectModulo" + this.value).prop("disabled", false);
              cargar_select(
                "ModalAsignarSubmodulo",
                true,
                "selectModulo" + this.value,
                "cargarSubModulos",
                "Seleccione el/los Submodulo/s",
                { modulo: this.value },
                true
              );
            } else {
              $("#selectModulo" + this.value).prop("disabled", true);
              $("#selectModulo" + this.value)
                .val("")
                .trigger("change");
            }
          });
          for (const modulo in result.asignados) {
            var submodulos = result.asignados[modulo];
            $("#modulo" + modulo).click();
            cambiarvaloreselect(modulo, submodulos,1);
          }
          $("#selectHome").val(result.home).trigger("change");
          $("#ModalAsignarSubmodulo").modal("show");
          break;
        case "2":
          Swal.fire({
            title: "Sin Datos!",
            text: "Hubo un problema en la sql al mostrar los modulos.",
            icon: "info",
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonColor: "#d33",
            cancelButtonText: "Cerrar!",
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

function asignar_submodulo(form, id) {
  var respuestavalidacion = validarcampos("#" + form);
  if (respuestavalidacion) {
    var formData = new FormData(document.getElementById(form)); //necesario para enviar archivos
    formData.append("peticion", "asignarSubmodulo");
    formData.append("id_usuario", id);
    $.ajax({
      cache: false, //necesario para enviar archivos
      contentType: false, //necesario para enviar archivos
      processData: false, //necesario para enviar archivos
      data: formData, //necesario para enviar archivos
      dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
      url: urlBase + "php/controller/controller_usuarios.php", //url a donde hacemos la peticion
      type: "POST",
      beforeSend: function () {
        $(".overlayCargue").fadeIn("slow");
      },
      complete: function () {
        $(".overlayCargue").fadeOut("slow");
      },
      success: function (result) {
        var estado = result.status;
        switch (estado) {
          case "0":
            $.toast({
              heading: "Error!",
              text: "Se ha presentado un error, por favor informar al area de sistemas.",
              showHideTransition: "slide",
              icon: "error",
              position: "top-right",
            });
            break;
          case "1":
            Swal.fire({
              icon: "success",
              title: "<strong>Submodulo/s asignado/s</strong>",
              html: "<h5>El/los submodulo/s ha/n sido asignado/s exitosamente</h5>",
              showCloseButton: false,
              confirmButtonText: "Aceptar",
              confirmButtonColor: "#64a19d",
              backdrop: true,
            });
            reset_asignar_submodulo();
            $("#ModalAsignarSubmodulo").modal("hide");
            break;
          default:
            // Code
            break;
        }
      },
      error: function (xhr) {
        console.log(xhr);
      },
    });
  }
}

function reset_asignar_submodulo() {
  limpiarcampos("#frmRegistroAsignarSubmodulo");
}

function cambiarvaloreselect(modulo, submodulos,tipo) {
  setTimeout(() => {
    if(tipo == 1){
      $("#selectModulo" + modulo)
      .val(submodulos)
      .trigger("change");
    }else if(tipo == 2){
      $("#selectPermiso" + modulo)
      .val(submodulos)
      .trigger("change");
    }    
  }, 500);
}

function todos(id) {
  if ($("#" + id + " option[value='X']").prop("selected")) {
    $("#" + id + " > option").prop("selected", "selected"); // Select All Options
    $("#" + id + " option[value='X']").prop("selected", false);
    $("#" + id + "").trigger("change"); // Trigger change to select 2
  }
}

function showModalAsignarPermiso(id) {
  $.ajax({
    data: {
      peticion: "cargarPermisos",
      id_usuario: id,
    }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "php/controller/controller_usuarios.php", //url a donde hacemos la peticion
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
          $("#ModalAsignarPermiso")
            .find("h5.modal-title")
            .html("Asignar Permisos");
          $("#btnRegistroAsignarPermiso").show();
          $("#btnRegistroAsignarPermiso").text("Asignar");
          $("#btnRegistroAsignarPermiso").attr(
            "onclick",
            "asignar_permiso('frmRegistroAsignarPermiso'," + id + ");"
          );
          $("#procesos").html(result.html);
          $(".chkProcesos").each(function (index) {
            new Switchery(this, {
              color: "#28B97B",
              secondaryColor: "#F5365C",
              speed: "0.6s",
              size: "small",
            });
          });

          $(".chkProcesos").on("change", function () {
            if (this.checked) {
              $("#selectPermiso" + this.value).prop("disabled", false);
              $("#selectPermiso" + this.value).addClass("requerido");
              $(".requerido").on(
                "change click mouseleave keypress",
                function (e) {
                  if ($(this).is("select") == true) {
                    $(this).siblings("span").removeClass("required");
                    $(this)
                      .siblings(".tooltips")
                      .find(".spanValidacion")
                      .fadeOut();
                    $(this)
                      .parents(".tooltips")
                      .find(".spanValidacion")
                      .fadeOut();
                  } else {
                    $(this).removeClass("required");
                    $(this)
                      .parents(".tooltips")
                      .find(".spanValidacion")
                      .fadeOut();
                  }
                }
              );
            } else {
              $("#selectPermiso" + this.value).prop("disabled", true);
              $("#selectPermiso" + this.value).removeClass("requerido");
              $("#selectPermiso" + this.value)
                .val("")
                .trigger("change");
            }
          });

          for (const proceso in result.asignados) {
            var permiso = result.asignados[proceso];
            $("#proceso" + proceso).click();
            cambiarvaloreselect(proceso, permiso,2);
          }

          $("#ModalAsignarPermiso").modal("show");
          break;
        case "2":
          Swal.fire({
            title: "Sin Datos!",
            text: "Hubo un problema en la sql al mostrar los permisos.",
            icon: "info",
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonColor: "#d33",
            cancelButtonText: "Cerrar!",
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

function reset_asignar_permiso() {
  limpiarcampos("#frmRegistroAsignarPermiso");
}

function asignar_permiso(form, id) {
  var respuestavalidacion = validarcampos("#" + form);
  if (respuestavalidacion) {
    var formData = new FormData(document.getElementById(form)); //necesario para enviar archivos
    formData.append("peticion", "asignarPermiso");
    formData.append("id_usuario", id);
    $.ajax({
      cache: false, //necesario para enviar archivos
      contentType: false, //necesario para enviar archivos
      processData: false, //necesario para enviar archivos
      data: formData, //necesario para enviar archivos
      dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
      url: urlBase + "php/controller/controller_usuarios.php", //url a donde hacemos la peticion
      type: "POST",
      beforeSend: function () {
        $(".overlayCargue").fadeIn("slow");
      },
      complete: function () {
        $(".overlayCargue").fadeOut("slow");
      },
      success: function (result) {
        var estado = result.status;
        switch (estado) {
          case "0":
            $.toast({
              heading: "Error!",
              text: "Se ha presentado un error, por favor informar al area de sistemas.",
              showHideTransition: "slide",
              icon: "error",
              position: "top-right",
            });
            break;
          case "1":
            Swal.fire({
              icon: "success",
              title: "<strong>Permiso/s asignado/s</strong>",
              html: "<h5>El/los permiso/s ha/n sido asignado/s exitosamente</h5>",
              showCloseButton: false,
              confirmButtonText: "Aceptar",
              confirmButtonColor: "#64a19d",
              backdrop: true,
            });
            reset_asignar_permiso();
            $("#ModalAsignarPermiso").modal("hide");
            break;
          default:
            // Code
            break;
        }
      },
      error: function (xhr) {
        console.log(xhr);
      },
    });
  }
}
