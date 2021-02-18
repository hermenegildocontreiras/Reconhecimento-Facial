document.getElementById("terminarSessao").addEventListener("click", () => {
    sessionStorage.removeItem("nome");
    sessionStorage.removeItem("fotosTiradas");
    sessionStorage.removeItem("passar");
    window.location.href = "/rec/";
});

const container = document.getElementById("container");

if (sessionStorage.getItem("passar") === "false") {
    window.location.href = "/rec";
}

fetch("/rec/classes/listUsers.php", {
        method: "GET",
        headers: {
            "Content-type": "application/json; charset=UTF-8",
        },
    })
    .then((response) => response.json())
    .then((json) => {
        console.log(json);
        console.log(json.length);
        if (json.length > 0) {
            for (dataItem in json) {
                console.log(dataItem);
                let li = document.createElement("li");
                let node = document.createTextNode(json[dataItem]);
                li.appendChild(node);
                container.appendChild(li);
            }

            const cam = document.getElementById("cam");

            const startVideo = () => {
                if (navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices
                        .getUserMedia({
                            audio: false,
                            video: { facingMode: "user" },
                        })
                        .then(function(stream) {
                            //Definir o elemento víde a carregar o capturado pela webcam
                            cam.srcObject = stream;
                        })
                        .catch(function(error) {
                            alert("Oooopps... Falhou :'(");
                        });
                }
            };

            const loadLabels = () => {
                const labels = [...json];
                return Promise.all(
                    labels.map(async(label) => {
                        const descriptions = [];
                        for (let i = 1; i <= 5; i++) {
                            const img = await faceapi.fetchImage(
                                `/rec/reconhecimento/assets/lib/face-api/labels/${label}/${i}.jpg`
                            );
                            const detections = await faceapi
                                .detectSingleFace(img)
                                .withFaceLandmarks()
                                .withFaceDescriptor();
                            if (detections) {
                                descriptions.push(detections.descriptor);
                            }
                        }
                        return new faceapi.LabeledFaceDescriptors(
                            label,
                            descriptions
                        );
                    })
                );
            };

            Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri(
                    "/rec/reconhecimento/assets/lib/face-api/models"
                ),
                faceapi.nets.faceLandmark68Net.loadFromUri(
                    "/rec/reconhecimento/assets/lib/face-api/models"
                ),
                faceapi.nets.faceRecognitionNet.loadFromUri(
                    "/rec/reconhecimento/assets/lib/face-api/models"
                ),
                faceapi.nets.faceExpressionNet.loadFromUri(
                    "/rec/reconhecimento/assets/lib/face-api/models"
                ),
                faceapi.nets.ageGenderNet.loadFromUri(
                    "/rec/reconhecimento/assets/lib/face-api/models"
                ),
                faceapi.nets.ssdMobilenetv1.loadFromUri(
                    "/rec/reconhecimento/assets/lib/face-api/models"
                ),
            ]).then(startVideo);

            cam.addEventListener("play", async() => {
                const canvas = faceapi.createCanvasFromMedia(cam);
                const canvasSize = {
                    width: cam.width,
                    height: cam.height,
                };
                const labels = await loadLabels();
                faceapi.matchDimensions(canvas, canvasSize);
                document.body.appendChild(canvas);
                setInterval(async() => {
                    const detections = await faceapi
                        .detectAllFaces(
                            cam,
                            new faceapi.TinyFaceDetectorOptions()
                        )
                        .withFaceLandmarks()
                        .withFaceExpressions()
                        .withAgeAndGender()
                        .withFaceDescriptors();
                    const resizedDetections = faceapi.resizeResults(
                        detections,
                        canvasSize
                    );
                    const faceMatcher = new faceapi.FaceMatcher(labels, 0.6);
                    const results = resizedDetections.map((d) =>
                        faceMatcher.findBestMatch(d.descriptor)
                    );
                    canvas
                        .getContext("2d")
                        .clearRect(0, 0, canvas.width, canvas.height);
                    faceapi.draw.drawDetections(canvas, resizedDetections);
                    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);
                    //
                    resizedDetections.forEach((detection) => {
                        const { age, gender, genderProbability } = detection;
                        //
                    });
                    results.forEach((result, index) => {
                        const box = resizedDetections[index].detection.box;
                        const { label, distance } = result;
                        new faceapi.draw.DrawTextField(
                            [`${label}`],
                            box.bottomRight
                        ).draw(canvas);
                    });
                }, 100);
            });
        }
    })
    .catch((err) => console.log(err));