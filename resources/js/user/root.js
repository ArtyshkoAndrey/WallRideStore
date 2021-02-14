$(function() {
  let rowMap = $('#row-map')

  if(rowMap) {
    $('#shop-image').height(rowMap.height())
    $(window).resize(() => {
      if ($(window).width() > 768) {
        $('#shop-image').height(rowMap.height())
      }
    })
  }
})

window.passwordTypeToggle = function (button, elID) {
  let el = $('#' + elID)
  let icon = $(button).children('i')
  if (el.attr('type') === 'password') {
    el.attr('type', 'text')
    icon.removeClass('fa-eye')
    icon.addClass('fa-eye-slash')
  } else if (el.attr('type') === 'text') {
    el.attr('type', 'password')
    icon.addClass('fa-eye')
    icon.removeClass('fa-eye-slash')
  }
}

window.onload = function () {
  setTimeout(() => {
    $('.alert').alert('close')
  }, 3000)
}
