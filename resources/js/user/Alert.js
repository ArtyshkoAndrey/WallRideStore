
export default class Alert {

  static autoClose (time) {
    setTimeout( () => {
      $('.alert').alert('close')
    }, time)
  }

  static warning(message) {
    $('#app').append(
      '<div class="alert alert-danger mt-5 position-fixed alert-dismissible fade show" role="alert">' +
      '<strong>' + message + '</strong>' +
      '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
      '<span aria-hidden="true">&times;</span>' +
      '</button>' +
      '</div>'
    )

    this.autoClose(3000)
  }
}
