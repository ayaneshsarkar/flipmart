const cartButton = document.querySelectorAll('.ajaxCart');

const csrfMeta = document.getElementsByTagName("META")[2].content;

cartButton.forEach(cartButton => {

  cartButton.addEventListener('click', function(e){

    e.preventDefault();
  
    const productSlug = this.nextElementSibling.value;
    
    $.ajax({

      headers: {
        'X-CSRF-TOKEN': csrfMeta
      },

      type: 'post',
      data: {
        productSlug: productSlug
      },
      dataType: 'json',
      url: `/cart`,

      success: function(data) {
        console.log(data);
      }

    });

  });

});

  // $('.ajaxCart').click(function(e) {
  //   e.preventDefault();
    
  //   const productSlug = $('.productSlug').val();

    

  // });

