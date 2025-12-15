$(function(){
  $('#registerForm').on('submit', function(e){
    e.preventDefault();
    $('#regAlert').html('');

    $.ajax({
      url: 'php/register.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json'
    })
    .done(function(res){
      if (res.success) {
        $('#regAlert').html('<div class="alert alert-success">'+res.message+'</div>');
        setTimeout(()=> location.href = 'login.html', 900); // fixed slash
      } else {
        $('#regAlert').html('<div class="alert alert-danger">'+res.message+'</div>');
      }
    })
    .fail(function(xhr, status, error){
      console.error(error);
      $('#regAlert').html('<div class="alert alert-danger">Server error</div>');
    });
  });
});
