<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Redefinição de Senha - Gaming Duo</title>
    <style>
        body {
            background-color: #E6F1F6; /* Light blue background */
            color: #333333; /* Dark grey for text */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #FF6666; /* Light red for border */
        }
        .header img {
            width: 100px;
            height: 100px;
        }
        .header h1 {
            color: #FF6666; /* Light red for the title */
            margin: 0;
        }
        .content {
            padding: 20px;
            background-color: #FFFFFF; /* White for content background */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }
        .content h2 {
            color: #333333; /* Dark grey for headers */
            margin-top: 0;
        }
        .content p {
            color: #333333; /* Dark grey for text */
        }
        .content a {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #FF6666; /* Light red for button */
            color: #FFFFFF; /* White for button text */
            text-decoration: none;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #FF6666; /* Light red for border */
            color: #333333; /* Dark grey for footer text */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="https://cdn.discordapp.com/attachments/809803750835224586/1248907240489091133/il_fullxfull.3329746240_dxht_1.png?ex=66655f01&is=66640d81&hm=983db171692dc8bd3ac4c7997353152f107aed1d2e275890b4771c573823f9aa&" alt="Gaming Duo">
        <h1>Gaming Duo</h1>
    </div>
    <div class="content">
        <h2>Redefinição de Senha</h2>
        <p>Olá,</p>
        <p>Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta na Gaming Duo.</p>
        <a href="{{ $actionUrl }}">Redefinir Senha</a>
        <p>Este link de redefinição de senha irá expirar em 60 minutos.</p>
        <p>Se você não solicitou uma redefinição de senha, por favor, ignore este e-mail ou entre em contato com nosso suporte.</p>
    </div>
    <div class="footer">
        <p>Atenciosamente,<br>Equipe Gaming Duo</p>
        <p>Junte-se à batalha e encontre seu duo perfeito!</p>
    </div>
</div>
</body>
</html>
