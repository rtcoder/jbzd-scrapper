from flask import Flask, request, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app)  # Zezwalamy na requesty z frontendu

@app.route('/')
def home():
    return "Serwer działa na localhost:9000!"

@app.route('/scrape', methods=['POST'])
def scrape():
    data = request.get_json()
    url = data.get('url')

    if not url:
        return jsonify({"error": "Brak adresu URL"}), 400

    # Tutaj będzie logika scrapera (na razie zwracamy testową odpowiedź)
    return jsonify({"message": f"Scrapowanie {url} zakończone!"})

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=9000)
