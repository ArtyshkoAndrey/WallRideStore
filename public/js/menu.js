let radioButtons = document.getElementsByName('accordion-1');
let radioButtons2 = document.getElementsByName('accordion-2');
let radioButtons3 = document.getElementsByName('accordion-3');
// create an empty currentlyCheckedRadio variable
let currentlyCheckedRadio = null;
let currentlyCheckedRadio2 = null;
let currentlyCheckedRadio3 = null;

if(radioButtons !== null) {
  // if the dom has loaded and radioButtons exist, loop through them
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
}

for(let i = 0; i < radioButtons2.length; i++) {

  radioButtons2[i].addEventListener('click', function() {
    // if submenu is open and slide menu is closed
    if (currentlyCheckedRadio2 === this) {
      currentlyCheckedRadio2 = null;
      this.checked = false;
    } else if (currentlyCheckedRadio2 !== this) {
      this.checked = true;
      currentlyCheckedRadio2 = this;
    } else {
      console.log('error')
    }

  });
}

for(let i = 0; i < radioButtons3.length; i++) {

  radioButtons3[i].addEventListener('click', function() {
    // if submenu is open and slide menu is closed
    if (currentlyCheckedRadio3 === this) {
      currentlyCheckedRadio3 = null;
      this.checked = false;
    } else if (currentlyCheckedRadio3 !== this) {
      this.checked = true;
      currentlyCheckedRadio3 = this;
    } else {
      console.log('error')
    }

  });
}
