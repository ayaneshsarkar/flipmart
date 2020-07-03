<script>
  $('#ajaxCart').click(function(e) {
    e.preventDefault();
    
    const productSlug = $('#productSlug').val();

    $.ajax({

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
</script>