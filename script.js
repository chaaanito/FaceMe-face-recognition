// Load models and start the webcam
const video = document.getElementById("video");

Promise.all([
  faceapi.nets.ssdMobilenetv1.loadFromUri("/models"),
  faceapi.nets.faceRecognitionNet.loadFromUri("/models"),
  faceapi.nets.faceLandmark68Net.loadFromUri("/models"),
]).then(startWebcam);

async function startWebcam() {
  try {
    const stream = await navigator.mediaDevices.getUserMedia({
      video: true,
      audio: false,
    });
    video.srcObject = stream;
  } catch (error) {
    console.error(error);
  }
}

async function getLabeledFaceDescriptions() {
  const labels = labelNames;
  const labeledFaceDescriptors = [];

  for (const label of labels) {
    const descriptions = [];
    for (let i = 1; i <= 2; i++) {
      const img = await faceapi.fetchImage(`./imgDatabase/${label}/${i}.png`);
      const detections = await faceapi
        .detectSingleFace(img)
        .withFaceLandmarks()
        .withFaceDescriptor();
      descriptions.push(detections.descriptor);
    }
    labeledFaceDescriptors.push(
      new faceapi.LabeledFaceDescriptors(label, descriptions)
    );
  }

  return labeledFaceDescriptors;
}

video.addEventListener("play", async () => {
  const labeledFaceDescriptors = await getLabeledFaceDescriptions();
  const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);

  const canvas = faceapi.createCanvasFromMedia(video);
  document.body.append(canvas);

  const displaySize = { width: video.width, height: video.height };
  faceapi.matchDimensions(canvas, displaySize);

  setInterval(async () => {
    const detections = await faceapi
      .detectAllFaces(video)
      .withFaceLandmarks()
      .withFaceDescriptors();

    const resizedDetections = faceapi.resizeResults(detections, displaySize);

    canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);

    const faceDescriptors = resizedDetections.map(
      (detection) => detection.descriptor
    );
    const results = faceDescriptors.map((descriptor) =>
      faceMatcher.findBestMatch(descriptor)
    );

    results.forEach((result, i) => {
      const box = resizedDetections[i].detection.box;
      const drawBox = new faceapi.draw.DrawBox(box, {
        label: result.toString(),
        boxColor: result.label === "unknown" ? "red" : "green",
      });
      drawBox.draw(canvas);
    });
  }, 100);
});
