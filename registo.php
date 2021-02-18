<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reconhecimento Facial</title>

    <link rel="stylesheet" type="text/css" href="./css/estilo.css" />
    <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css">

</head>

<body class="bodyHv">
    <div class="title"></div>

    <div class="container">
        <div class="left"></div>
        <div class="right">
            <div class="formBox">
                <div class="bg-img">
                    <form class="pl-4 pr-4" style="margin-top: 40px" id="formularioCadastro">
                        <h3 class="center w-100 text-center">Formulário de Registo</h3>
                        <div class="row mt-1">
                            <div class="form-group col-6">
                                <label for="nome">Nome de Usuário: </label>
                                <input type="text" class="form-control" id="nome" aria-describedby="emailHelp" placeholder="" name="nomeUsuario">
                            </div>

                            <div class="form-group col-6">
                                <label for="senha">Senha: </label>
                                <input type="password" class="form-control" id="senha" aria-describedby="numeroBi" placeholder="" name="senha">
                            </div>
                        </div>
                        <p class="w-100 text-center">Já possui uma conta? <a href="index.php">Fazer Login</a></p>
                        <div class="row">
                            <div class="form-group col-6 float-right" style="
    display: flex;
    margin: 0 auto;
">
                                <input type="submit" name="registar" class=" btn btn-primary" style="
    display: flex;
    margin: 0 auto;
" value="Registar Usuário">
                            </div>
                        </div>

                </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    <script>
        document.getElementById("formularioCadastro").addEventListener("submit", (e) => {
            e.preventDefault();
            const data = {
                nome: document.getElementById("nome").value,
                senha: document.getElementById("senha").value
            }
            console.log(data);
            fetch("/rec/classes/createUser.php", {
                    method: "POST",
                    body: JSON.stringify(data),
                    headers: {
                        "Content-type": "application/json; charset=UTF-8",
                    },
                })
                .then((response) => response.json())
                .then((json) => {
                    console.log(json);
                    if (json.length > 0) {
                        if (json[0].nome) {
                            sessionStorage.setItem(
                                "nome",
                                json[0].nome
                            );
                            sessionStorage.setItem(
                                "fotosTiradas",
                                0
                            );
                            sessionStorage.setItem(
                                "passar",
                                false
                            );
                            window.location.href = "/rec/fotografar.php";
                        }
                    }
                })
                .catch((err) => console.log(err));

        });
    </script>
</body>

</html>