import * as mdb from 'mdb-ui-kit'

$(function() {
  let toggle = $('#nav-toggle')
  let leftMenu = $('#left-menu')
  let content = $('#app > .container')
  let radioButtons = document.getElementsByName('accordion-1');
  let currentlyCheckedRadio = null;

  for(let i = 0; i < radioButtons.length; i++) {
    radioButtons[i].addEventListener('click', function() {
      // loop through 4 possible states
      // if submenu is open and slide menu is open
      if (currentlyCheckedRadio === this) {
        currentlyCheckedRadio = null;
        this.checked = false;

        // if submenu is closed and slide menu is open
      } else if (currentlyCheckedRadio !== this) {
        this.checked = true;
        currentlyCheckedRadio = this;

        // if submenu is closed and slide menu is closed
      } else {
        console.log('error')
      }
    });
  }

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

  if (window.innerWidth > 992) {

    document.querySelectorAll('#sub-menu .nav-item').forEach(function(everyitem){

      everyitem.addEventListener('mouseover', function(e){

        let el_link = this.querySelector('a[data-mdb-toggle]');

        if(el_link != null){
          let nextEl = el_link.nextElementSibling;
          el_link.classList.add('show');
          nextEl.classList.add('show');
        }

      });
      everyitem.addEventListener('mouseleave', function(e){
        let el_link = this.querySelector('a[data-mdb-toggle]');

        if(el_link != null){
          let nextEl = el_link.nextElementSibling;
          el_link.classList.remove('show');
          nextEl.classList.remove('show');
        }


      })
    });

  }

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
