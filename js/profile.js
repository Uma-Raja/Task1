$(document).ready(function () {
  const token = localStorage.getItem('token');

  if (!token) {
    location.href = 'login.html';
    return;
  }

  // LOAD PROFILE
  $.ajax({
    url: '/Task1/php/profile.php',
    method: 'GET',
    headers: { Authorization: 'Bearer ' + token },
    dataType: 'json',
    success: function (res) {
      if (!res.success) return alert(res.message);
      $('#name').val(res.user.name || '');
      $('#email').val(res.user.email || '');
      $('#phone').val(res.user.phone || '');
      $('#dob').val(res.user.dob || '');
      $('#address').val(res.user.address || '');
    }
  });

  // UPDATE PROFILE
  $('#profileForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: '/Task1/php/profile.php',
      method: 'POST',
      headers: { Authorization: 'Bearer ' + token },
      data: $(this).serialize(),
      dataType: 'json'
    });
  });
});

// LOGOUT — delegated (IMPORTANT)
$(document).on('click', '#logoutBtn', function () {
  $.ajax({
    url: '/Task1/php/logout.php',
    method: 'POST',
    headers: {
      Authorization: 'Bearer ' + localStorage.getItem('token')
    },
    complete: function () {
      localStorage.clear();
      window.location.replace('login.html');
    }
  });
});
