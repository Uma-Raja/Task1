$(function(){
  $('#loginForm').on('submit', function(e){
    e.preventDefault();
    $('#loginAlert').html('');
    
    $.ajax({
      url: 'php/login.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json'
    })
    .done(function(res){
      if (res.success) {
        localStorage.setItem('token', res.token);
        localStorage.setItem('user', JSON.stringify(res.user));
        location.href = 'profile.html'; // fixed slash
      } else {
        $('#loginAlert').html('<div class="alert alert-danger">'+res.message+'</div>');
      }
    })
    .fail(function(xhr, status, error){
      console.error(error);
      $('#loginAlert').html('<div class="alert alert-danger">Server error</div>');
    });
  });
});
