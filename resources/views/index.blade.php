<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scraper</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function startScraping() {
            const url = document.getElementById('urlInput').value;
            const progress = document.getElementById('progress');
            const startButton = document.getElementById('startButton');

            if (!url) {
                alert("Podaj adres!");
                return;
            }

            startButton.disabled = true;
            progress.value = 0;

            axios.get('/api/start', { params: { url } })
                .then(response => {
                    console.log(response.data);
                    let interval = setInterval(() => {
                        axios.get('/api/status')
                            .then(statusResponse => {
                                // progress.value = statusResponse.data.progress;
                                console.log(statusResponse.data)
                                if (!statusResponse.data.running) {
                                    clearInterval(interval);
                                    startButton.disabled = false;
                                }
                            });
                    }, 2000);
                })
                .catch(error => {
                    console.error(error);
                    startButton.disabled = false;
                });
        }
    </script>
</head>
<body>
<h1>Scraper</h1>
<input type="text" id="urlInput" placeholder="Podaj adres" />
<button id="startButton" onclick="startScraping()">Start</button>
<progress id="progress" value="0" max="100"></progress>
</body>
</html>
