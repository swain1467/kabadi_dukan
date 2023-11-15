<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="g-recaptcha" data-sitekey="6LfTsn0mAAAAAOSJhaC4WiQPgVcUJ2Rumsbs80Ac"></div>
<!-- 6LfTsn0mAAAAAOSJhaC4WiQPgVcUJ2Rumsbs80Ac  -->
<!-- 6LfTsn0mAAAAAGKGCOr_AgYjNk0POiOVh7t-CLM4 -->
<?php
// // Varify captcha start------------------------
// $recaptcha = $_POST['g-recaptcha-response'];
            
// // Put secret key here, which we get
// // from google console
// $secret_key = '6LcMFeYSAAAAAH_-u8ml59qD2pBjkEBMNaQCubwH';

// // Hitting request to the URL, Google will
// // respond with success or error scenario
// $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
//     . $secret_key . '&response=' . $recaptcha;

// // Making request to verify captcha
// $response = file_get_contents($url);

// // Response return by google is in
// // JSON format, so we have to parse
// // that json
// $response = json_decode($response);

// // Checking, if response is true or not
// if ($response->success != true) {
//     $err = TRUE;
//     $err_message .= "<li>Invalid Captcha.</li>\n";
// }
// // Varify captcha End------------------------------
?>