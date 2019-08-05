<?php
    if (isset($_POST['email'])) {
        // ADD YOUR EMAIL WHERE YOU WANT TO RECEIVE THE MESSAGES
        $email_to = "soporte@smarthub.cl";
        $email_subject = "SmartHub - Formulario de contacto";
        function died($error) {
            // your error code can go here
            echo '<div class="alert alert-danger alert-dismissible wow fadeInUp" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Algo salio mal:</strong><br />';
            echo $error."<br />";
            echo '</div>';
            die();
        }
    
        // validation expected data exists
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['phone']) || // un-commet for required
        !isset($_POST['message'])) {
            //died('We are sorry, but there appears to be a problem with the form you submitted.');
            died('Lo sentimos, al parecer hay problemas con el envio del formulario.');
        }

        $name = $_POST['name']; // required
        $email_from = $_POST['email']; // required
        $telephone = $_POST['phone']; // not required
        $message = $_POST['message']; // required
        $error_message = "";
        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if(!preg_match($email_exp,$email_from)) {
            //$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
            $error_message .= 'La dirección de correo que ingresó no es valida.<br />';

        }
      
        $string_exp = "/^[A-Za-z .'-]+$/";

        if(!preg_match($string_exp,$name)) {
          //$error_message .= 'The First Name you entered does not appear to be valid.<br />';
          $error_message .= 'El nombre ingresado no es valido.<br />';
        }
         
        if(strlen($message) < 2) {
          //$error_message .= 'The message you entered do not appear to be valid.<br />';
          $error_message .= 'El mensaje ingresado no es valido.<br />';
        }
         
        if(strlen($error_message) > 0) {
          died($error_message);
        }
         
        $email_message = "Form details below.\n\n";

        function clean_string($string) {
          $bad = array("content-type","bcc:","to:","cc:","href");
          return str_replace($bad,"",$string);
        }

        $email_message .= "Nombre: ".clean_string($name)."\n";
        $email_message .= "Email: ".clean_string($email_from)."\n";
        $email_message .= "Telefono: ".clean_string($telephone)."\n";
        $email_message .= "Mensaje: ".clean_string($message)."\n";

        // create email headers
        $headers = 'From: '.$email_from."\r\n".
        'Reply-To: '.$email_from."\r\n" .
        'X-Mailer: PHP/' . phpversion();

        // parameters
        $parameters = "/usr/sbin/sendmail -t -i";
        mail($email_to, $email_subject, $email_message, $headers, $parameters);

?>
        <div class="alert alert-success alert-dismissible wow fadeInUp" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
           El mensaje ha sido enviado.
         </div>
<?php } ?>