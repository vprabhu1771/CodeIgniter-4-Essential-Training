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
    <title>Send Email</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <form method="POST" action="/send-email">
        <label for="email">Your Email:</label>
        <input type="email" name="email" required>
        <label for="message">Message:</label>
        <textarea name="message" required></textarea>
        <div class="g-recaptcha" data-sitekey="your-site-key"></div> <!-- Replace with your site key -->
        <button type="submit">Send Email</button>
    </form>
</body>
</html>
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
        return view('email_form');
    }

    public function send()
    {
        helper(['form', 'url']);

        $email = $this->request->getPost('email');
        $message = $this->request->getPost('message');
        $captcha = $this->request->getPost('g-recaptcha-response');

        // Validate Google reCAPTCHA
        $response = $this->validateCaptcha($captcha);
        if (!$response['success']) {
            return redirect()->back()->with('error', 'reCAPTCHA verification failed.');
        }

        // Load Email Library
        $emailService = \Config\Services::email();
        $emailService->setFrom('your-email@gmail.com', 'Your Name');
        $emailService->setTo($email);
        $emailService->setSubject('Test Email');
        $emailService->setMessage($message);

        if ($emailService->send()) {
            return redirect()->back()->with('success', 'Email sent successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to send email.');
        }
    }

    private function validateCaptcha($captcha)
    {
        $secretKey = 'your-secret-key'; // Replace with your secret key
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $response = file_get_contents("$url?secret=$secretKey&response=$captcha");
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