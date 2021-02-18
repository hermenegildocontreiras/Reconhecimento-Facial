
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<!--Título-->
		<title>Tela de Fotografia</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content=""/>
			
		<!--OpenType-->
		<meta property="og:locale" content="pt" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="" />
		<meta property="og:description" content="" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="" />
		
		<!--CSS-->
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<div class="area">
			<video autoplay="true" id="webCamera" style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-74%);
    display: flex;
    margin: 0 auto;
"> 
			</video>
			<form target="POST">
				<textarea  style="display: none;" type="text" id="base_img" name="base_img"></textarea>
				<!-- <button type="button" onclick="takeSnapShot()">Tirar foto e salvar</button> -->
                <img src="./snap.png" onclick="takeSnapShot()" style="
    position: absolute;
    width: 75px;
    left: 50%;
    top: 71%;
    transform: translateX(-50%);
">
<p style="margin: 0;
    position: absolute;
    top: 68%;
    left: 50%;
    transform: translateX(-50%);" id="numeroFoto">Foto</p>
<p style="
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 82%;
    margin: 0;
">Tirar Foto e Salvar </p>
			</form>
			<img id="imagemConvertida"/>
			<p id="caminhoImagem" class="caminho-imagem"><a href="" target="_blank"></a></p>
			<!--Scripts-->
			<script src="fotografar.js"></script>
		</div>
	</body>
</html>