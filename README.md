# Selfauth
self-hosted auth_endpoint using simple login mechanism

# Warning: while Selfauth will work with old versions of PHP, the ability to get sufficiently random strings was not added until version 5.6.  While older versions are not completely insecure, it is strongly recommended you upgrade to a newer version of PHP.

# Warning: currently selfauth only supports authentication, not authorization.  Meaning scopes will not work yet.  If you need access to these features, it is advisable to use something else for now.

Setup
-----

To set up Selfauth, create a folder on your webserver and add the files in this repository to it. You can name the folder anything you like, but in this example we will work with 'auth' under `https://example.com/auth/`.

1. Create a folder called 'auth' on your webserver and add at least `index.php` and `setup.php`.

2. Go to `https://example.com/auth/setup.php` and fill in the form: pick the URL you're trying to log in for (in our case `https://example.com`) and choose a password.

3. Find the index-page of your domain and add the following code inside the `<head>` tag:
    ```html
    <link rel="authorization_endpoint" href="https://example.com/auth/" />
    ```
    ... where `https://example.com/auth/` is the URL you installed Selfauth to.
    (The exact location of your HTML `<head>` could be hidden in your CMS. Look for help in their documentation. Setting a HTTP Link header like `Link: <https://example.com/auth/>; rel="authorization_endpoint"` should work too.)

4. Go to a place to login with IndieAuth and enter your URL. (IndieAuth.com has a test-form on the frontpage. Enter your URL and it will discover your new endpoint. Click on that button. Other IndieAuth clients will redirect you to your Selfauth immediately.)

5. Fill in your password and click login!


License
-------

Copyright 2017 by Ben Roberts and contributors

Available under the Creative Commons CC0 1.0 Universal and MIT licenses.

See CC0-LICENSE.md and MIT-LICENSE.md for the text of these licenses.

