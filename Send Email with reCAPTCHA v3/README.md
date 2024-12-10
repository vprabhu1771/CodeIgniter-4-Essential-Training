Sending emails in CodeIgniter 4 via Gmail SMTP with Google reCAPTCHA involves these steps:

### Steps to Implement:
1. **Set up Gmail SMTP**: Configure Gmail SMTP for sending emails.
2. **Enable Google reCAPTCHA**: Integrate Google reCAPTCHA to validate the form.
3. **Create the Email and reCAPTCHA Forms**: Create a form for the user to fill out.
4. **Process Form Submission**: Validate the reCAPTCHA and send the email.

Here’s the implementation:

---

### 1. **Configuration for Gmail SMTP**

**Update `app/Config/Email.php`**:
```php
public $fromEmail = 'your-email@gmail.com'; // Your Gmail address
public $fromName = 'Your Name';
public $SMTPHost = 'smtp.gmail.com';
public $protocol = 'smtp';
public $SMTPUser = 'your-email@gmail.com';
public $SMTPPass = 'your-app-password'; // Gmail App Password
public $SMTPPort = 587;
public $SMTPTimeout = 60; // Timeout in seconds
public $SMTPCrypto = 'tls';
public $mailType = 'html';
public $charset = 'utf-8';
public $newline = "\r\n";
public $wordWrap = true;
```

---

### 2. **Set up Google reCAPTCHA**

1. Go to [Google reCAPTCHA Admin Console](https://www.google.com/recaptcha/admin).
2. Register your site and get the **site key** and **secret key**.
3. Add the **site key** to your form and use the **secret key** in the server validation.

---

### 3. **Create the Form**

**Create `app/Views/email_form.php`**:
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email with reCAPTCHA v3</title>
    <script src="https://www.google.com/recaptcha/api.js?render=YOUR_SITE_KEY"></script>
</head>
<body>
    <h1>Contact Form</h1>
    <form action="/send-email" method="post" id="contactForm">
        <!-- Other form fields go here -->
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="text" name="message" placeholder="Your Message" required>
        
        <input type="hidden" name="recaptcha_token" id="recaptchaToken">
        <button type="submit">Send Email</button>
    </form>

    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('YOUR_SITE_KEY', {action: 'submit'}).then(function(token) {
                document.getElementById('recaptchaToken').value = token;
            });
        });
    </script>
</body>
</html>
```

### 3. **Configuration**

Add the reCAPTCHA keys to your `.env` file or `app/config/App.php`:

**.env:**
```ini
RECAPTCHA_SITE_KEY=YOUR_SITE_KEY
RECAPTCHA_SECRET_KEY=YOUR_SECRET_KEY
```

**Accessing Keys in the Controller:**
```php
$siteKey = getenv('RECAPTCHA_SITE_KEY');
$secretKey = getenv('RECAPTCHA_SECRET_KEY');
```

---

### 4. **Controller Logic**

**Create `app/Controllers/EmailController.php`**:
```php
<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Email\Email;

class EmailController extends Controller
{
    public function index()
    {
        // Load the form view
        return view('email_form');
    }

    public function send()
    {
        // Your reCAPTCHA secret key
        $recaptchaSecret = getenv('RECAPTCHA_SECRET_KEY');
        $recaptchaToken = $this->request->getPost('recaptcha_token');

        // Verify the reCAPTCHA token with Google's API
        $response = $this->verifyRecaptcha($recaptchaToken, $recaptchaSecret);

        if ($response['success'] && $response['score'] >= 0.5) {
            // Prepare and send the email
            $email = \Config\Services::email();
            $email->setTo('recipient@example.com'); // Change to recipient's email
            $email->setFrom('sender@example.com', 'Your Name'); // Change sender's email and name
            $email->setSubject('Test Email with reCAPTCHA v3');
            $email->setMessage('This is a test email sent after verifying reCAPTCHA v3.');

            if ($email->send()) {
                return redirect()->to('/success')->with('message', 'Email sent successfully.');
            } else {
                return redirect()->to('/error')->with('message', 'Failed to send the email.');
            }
        } else {
            return redirect()->to('/error')->with('error', 'reCAPTCHA verification failed.');
        }
    }

    private function verifyRecaptcha($token, $secret)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secret,
            'response' => $token
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        if ($response === false) {
            throw new \RuntimeException('Unable to verify reCAPTCHA');
        }

        return json_decode($response, true);
    }
}
```

---

### 5. **Routing**

**Update `app/Config/Routes.php`**:
```php
$routes->get('/send-email', 'EmailController::index');
$routes->post('/send-email', 'EmailController::send');
```

---

### 6. **Test and Debug**

1. Navigate to `/send-email` to access the form.
2. Fill in the email, message, and pass the reCAPTCHA challenge.
3. Submit the form to send an email.

### Notes:
- Ensure Gmail SMTP is enabled and "Less secure app access" is allowed or generate an App Password if 2FA is enabled.
- Handle errors gracefully and log email issues for debugging (`$emailService->printDebugger()`).

Let me know if you need further assistance!


### Explanation:
- **`send-email`**: Loads the form for users to fill out.
- **`send-email`**: Handles the form submission, verifies the reCAPTCHA, and sends the email.
- **`verifyRecaptcha()`**: A helper function to validate the reCAPTCHA token with Google's server.
- **reCAPTCHA v3**: Adds an invisible token that scores the interaction (e.g., `score >= 0.5` is considered human). Adjust the threshold as needed.

**Note**: This code assumes you are using PHP's built-in functions for HTTP requests. For production, consider using `cURL` or a library like `Guzzle` for better error handling and security.