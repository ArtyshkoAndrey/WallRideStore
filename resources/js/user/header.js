import * as mdb from 'mdb-ui-kit'

$(function() {
  let toggle = $('#nav-toggle')
  let leftMenu = $('#left-menu')
  let content = $('#app > .container')

  setTimeout(() => {
    $('.alert').alert('close')
  }, 1500)

  const buttons = document.querySelectorAll('.btn')
  buttons.forEach((button) => {
    new mdb.Button(button)
  })

  toggle.click(function () {
    if (leftMenu.hasClass('open'))
      unBlur ()
    else
      blur()

    toggle.toggleClass('open')
    leftMenu.toggleClass('open')
  })

  content.click (function () {
    if (leftMenu.hasClass('open')) {
      toggle.click()
    }
  })

  $(window).on('resize', function () {
    console.log(window.innerWidth)
    if (window.innerWidth > 992) {
      if (leftMenu.hasClass('open')) {
        toggle.click()
      }
    }
  })

  function blur () {
    content
      .css('cursor', 'pointer')
      // .css('filter', 'blur(2px)')

    $('body').css('overflow', 'hidden')
  }

  function unBlur () {
    content
      .css('cursor', 'default')
      // .css('filter', 'none')

    $('body').css('overflow-y', 'auto')
  }
})
