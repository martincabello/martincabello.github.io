<?php

$response = [];

if($_POST) {

    if (isset($_POST['password']) && $_POST['password']!="") {
       $response["error"]= 'Algo salió mal';
    } else {
        $fname = "";
        $lname = "";
        $email = "";
        $subject = "";
        $message = "";
        $email_body = "<div>";
        $email_body .= 
        "<div>
            <h2>Este correo fue generado desde el formulario de contacto del sitio web clinicabrelo.cl</h2>
        </div>";
        if(isset($_POST['fname'])) {
            $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
            $email_body .= 
                "<div>
                    <label><b>Nombre:</b></label>&nbsp;<span>".$fname."</span>
                </div>";
        }
    
        if(isset($_POST['lname'])) {
            $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
            $email_body .= 
                "<div>
                    <label><b>Apellido:</b></label>&nbsp;<span>".$lname."</span>
                </div>";
        }
    
        if(isset($_POST['email'])) {
            $email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['email']);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    
        }
        if(isset($_POST['subject'])) {
            $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
        }
    
        if(isset($_POST['message'])) {
            $message = htmlspecialchars($_POST['message']);
            $email_body .= "<div>
                                <label><b>Mensaje:</b></label>
                                <div>".$message."</div>
                            </div>";
        }
    
        $recipient = "contacto@clinicabrelo.cl";
        $email_body .= "</div>";
        $headers  = 'MIME-Version: 1.0' . "\r\n"
        .'Content-type: text/html; charset=utf-8' . "\r\n"
        .'From: ' . $email . "\r\n";
    
         
        if(mail($recipient, $subject, $email_body, $headers)) {
            $response["success"] = 'Gracias por contactarnos';
        } else {
            $response["error"]= 'Ocurrió un problema, puedes contactarnos al (+56) 412 223 974.';
        }
    }
} else {
    $response["error"]= 'Algo salió mal, puedes contactarnos al (+56) 412 223 974.';
}
echo json_encode($response);
?>
