<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Reconhecimento Facial</title>

    <link rel="stylesheet" type="text/css" href="./css/estilo.css" />
    <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css" />
</head>

<body class="bodyHv">
    <div class="title"></div>

    <div class="container">
        <div class="left"></div>
        <div class="right">
            <div class="formBox">
                <form class="form formCenter" method="post" accept="#" id="formularioLogin" enctype="multipar/form-data">
                    <p>Nome de Usuário</p>
                    <input type="text" name="nome" class="form-control" placeholder="Nome de Utilizador" id="nome" />
                    <p>Senha</p>
                    <input type="Password" name="password" class="form-control" placeholder="Senha" id="senha" />
                    <input type="submit" name="button" value="Iniciar Sessão" class="buttonLogin align-content-center" style="background: #007bff" />
                    <p class="w-100 text-center">
                        Clique <a href="./registo.php">aqui</a> para registar-se.
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script>
        if (
            sessionStorage.getItem("nome") !== "" &&
            sessionStorage.getItem("fotosTiradas") === "5" &&
            sessionStorage.getItem("passar") === "true"
        ) {
            window.location.href = "/rec/reconhecimento";
        }
        document
            .getElementById("formularioLogin")
            .addEventListener("submit", (e) => {
                e.preventDefault();
                const data = {
                    nome: document.getElementById("nome").value,
                    senha: document.getElementById("senha").value,
                };
                console.log(data);
                fetch("/rec/classes/readUser.php", {
                        method: "POST",
                        body: JSON.stringify(data),
                        headers: {
                            "Content-type": "application/json; charset=UTF-8",
                        },
                    })
                    .then((response) => response.json())
                    .then((json) => {
                        console.log(json);
                        if (json.nome !== "") {
                            if (json.nome) {
                                sessionStorage.setItem("nome", json.nome);
                                sessionStorage.setItem("fotosTiradas", 5);
                                sessionStorage.setItem("passar", true);
                                window.location.href =
                                    "/rec/reconhecimento/";
                            }
                        }
                        if (json.message) {
                            if (json.message === "Incorrecto") {
                                alert("Usuário ou Senha Incorrectos!");
                            }
                        }
                    })
                    .catch((err) => console.log(err));
            });
    </script>
</body>

</html>