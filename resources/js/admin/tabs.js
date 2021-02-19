$(function () {
  let tabsButton = $('.wrapper-tabs > .tabs > button')
  tabsButton.on('click', function () {
    let element =  $(this)
    let idTabContent = element.data('tabsContentId')
    tabsButton.removeClass('active')
    element.addClass('active')

    $('.wrapper-tabs > .tabs-content').removeClass('active')
    console.log(idTabContent)
    $('#' + idTabContent).addClass('active')
  })
})
