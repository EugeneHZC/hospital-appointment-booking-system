// Controls Login and Sign Up button navigation
(function() {
  'use strict';

  document.addEventListener('DOMContentLoaded', function() {
    
    // Login button - redirects to login.php
    var loginBtn = document.getElementById('login-btn');
    if (loginBtn) {
      loginBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = 'login/login.php';
      });
    }
    
    // Sign Up button - redirects to newpatient.php
    var signupBtn = document.getElementById('signup-btn');
    if (signupBtn) {
      signupBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = 'login/newpatient.php';
      });
    }
    
    if (!loginBtn) {
      console.warn('landing-buttons.js: Login button (#login-btn) not found on this page');
    }
    if (!signupBtn) {
      console.warn('landing-buttons.js: Sign Up button (#signup-btn) not found on this page');
    }
  });
})();