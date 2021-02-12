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
