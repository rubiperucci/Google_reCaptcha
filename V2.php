<!DOCTYPE html>
<html lang="pt-br">
<head>
<script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- API do Google -->
</head>
<body>
<form method="POST">
    <input type="text" name="nome" placeholder="  *Nome Completo" maxlength="100">
    <input type="email" name="email" placeholder="  *E-mail" maxlength="40">
    <div class="g-recaptcha" data-sitekey="_CHAVE_DO_SITE_"></div> <!-- Substituir _CHAVE_DO_SITE_ por sua Site Key -->
    <input type="submit" class="btn" value="Enviar">
</form>
<?php
class Captcha{
    public function getCaptcha($SecretKey){ //substituir o _CHAVE_SECRETA_ por sua Secret Key
        $Resposta=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=_CHAVE_SECRETA_&response={$SecretKey}");
        $Retorno=json_decode($Resposta);
        return $Retorno;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $ObjCaptcha = new Captcha();
    $Retorno = $ObjCaptcha->getCaptcha($_POST['g-recaptcha-response']); 
    if($Retorno->success){
        //a nivel de conhecimento, você pode visualizar a resposta JSON que está recebendo com o seguinte foreach:
        foreach ($Retorno as $key => $value) {
            echo "$key: $value<br />\n"; 
        };

        //insira o código que deseja rodar, caso o captcha seja validado

    }else{   
        ?>
        <script>alert("Realize o Captcha!")</script>
        <?php
    }
}
?>
</body>
</html>
