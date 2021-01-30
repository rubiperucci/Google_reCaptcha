<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<script src="https://www.google.com/recaptcha/api.js"></script> <!-- API do Google -->
<script> 
   function onSubmit(token) {
     document.getElementById("demo-form").submit(); // Mudar o "demo-form" pelo id do seu formulário
   }
</script> 
</head>
<body>
<form method="POST" id="demo-form">
    <input type="text" name="nome" placeholder="  *Nome Completo" maxlength="100">
    <input type="email" name="email" placeholder="  *E-mail" maxlength="40">
    <!-- Substituir _CHAVE_DO_SITE_ por sua Site Key -->
    <button class="g-recaptcha" 
        data-sitekey="_CHAVE_DO_SITE_" 
        data-callback='onSubmit' 
        data-action='submit'>Enviar</button> 
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
    if($Retorno->success == true && $Retorno->score >= 0.5){
        //a nivel de conhecimento, você pode visualizar a resposta JSON que está recebendo com o seguinte foreach:
        foreach ($Retorno as $key => $value) { 
            echo "$key: $value<br />\n"; 
        };

        //insira o código que deseja rodar, caso o captcha seja validado

    }else{   
        ?>
        <script>alert("Damn Spammer!")</script>
        <?php
    }
}
?>
</body>
</html>
