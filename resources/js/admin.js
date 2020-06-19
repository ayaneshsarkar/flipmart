const { cssNumber } = require("jquery");

$('.hamberger').click(function() {
  $('.wrapper').toggleClass('active');
})

// function tabletFunction(tabletWidth) {
//   if(tabletWidth.matches) {
//     document.querySelector('.wrapper').classList.toggle('active');
//   }
// }

// const tabletWidth = window.matchMedia("(max-width: 768px)");
// tabletFunction(tabletWidth);
// tabletWidth.addEventListener(tabletFunction);