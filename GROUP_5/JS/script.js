// Login Form Handling

// vanilla js convert into jquery library syntax

$(document).ready(function() {
    const $loginForm = $('#loginForm');
    const $registerForm = $('#registerForm');
    const $messageDiv = $('#message');
    const $loginBtn = $('#loginBtn');

    // Login Form Handler
    if ($loginForm.length) {
        $loginForm.on('submit', function(e) {
            e.preventDefault();

            // 1. UI State: Disable button and clear messages
            $loginBtn.prop('disabled', true).text('Logging in...');
            $messageDiv.removeClass('success error').text('');

            // 2. Collect Data
            const formData = $(this).serialize();

            // 3. Send AJAX Request
            $.ajax({
                url: 'API/login.php',
                type: 'POST',
                data: formData,
                dataType: 'json'
            })
            .done(function(data) {
                console.log('Login response:', data);
                if (data.success) {
                    $messageDiv.addClass('success').text(data.message);
                    // Redirect after 1.5s
                    setTimeout(() => {
                        window.location.href = 'dashboard.php';
                    }, 1500);
                } else {
                    let errorMsg = data.message;
                    if (data.debug) {
                        errorMsg += ' (Debug: ' + JSON.stringify(data.debug) + ')';
                    }
                    $messageDiv.addClass('error').text(errorMsg);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $messageDiv.addClass('error').text('An error occurred. Please try again.');
                console.error('Error:', textStatus, errorThrown);
                console.log('Response:', jqXHR.responseText);
            })
            .always(function() {
                // 4. Re-enable button
                $loginBtn.prop('disabled', false).text('Login');
            });
        });
    }

    // Registration Form Handler
    if ($registerForm.length) {
        const $registerBtn = $('#registerBtn');
        
        $registerForm.on('submit', function(e) {
            e.preventDefault();

            // 1. UI State: Disable button and clear messages
            $registerBtn.prop('disabled', true).text('Registering...');
            $messageDiv.removeClass('success error').text('');

            // 2. Collect Data
            const formData = $(this).serialize();

            // 3. Send AJAX Request
            $.ajax({
                url: 'API/register.php',
                type: 'POST',
                data: formData,
                dataType: 'json'
            })
            .done(function(data) {
                if (data.success) {
                    $messageDiv.addClass('success').text(data.message);
                    // Redirect to login after 2s
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 2000);
                } else {
                    $messageDiv.addClass('error').text(data.message);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                $messageDiv.addClass('error').text('An error occurred. Please try again.');
                console.error('Error:', errorThrown);
            })
            .always(function() {
                // 4. Re-enable button
                $registerBtn.prop('disabled', false).text('Register');
            });
        });
    }

    // Logout Handler
    const $logoutBtn = $('#logoutBtn');
    if ($logoutBtn.length) {
        $logoutBtn.on('click', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'API/logout.php',
                type: 'POST',
                dataType: 'json'
            })
            .done(function(data) {
                window.location.href = 'index.php';
            })
            .fail(function() {
                window.location.href = 'index.php';
            });
        });
    }
});
