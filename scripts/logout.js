// Universal logout functionality for all user types
(function() {
  document.addEventListener('DOMContentLoaded', function() {
    // Find ANY logout button (by class or attribute)
    var logoutButton = document.querySelector('.btn-danger, #logout-btn, [data-logout="true"]');
    
    if (logoutButton) {
      logoutButton.addEventListener('click', function(e) {
        e.preventDefault();
    
        
        // Redirect to login page or index.html
        window.location.href = '../index.html';
      });
    }
  });
})();