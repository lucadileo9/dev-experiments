# Qui installiamo un'immagine base di Python 3.10, slim cioè leggera e ottimizzata 
# per l'uso in ambienti di produzione
FROM python:3.10-slim

# Impostiamo alcune variabili d'ambiente per migliorare il comportamento di Python
ENV PYTHONUNBUFFERED=1 \  
# Non bufferizza l'output di Python, utile per i log in tempo reale
    PYTHONDONTWRITEBYTECODE=1
# Non crea file .pyc, risparmiando spazio

# Crea e imposta la directory di lavoro
WORKDIR /app

# Installa dipendenze sistema per uWSGI
# Usando una versione slim di Python, dobbiamo installare manualmente alcune librerie di sistema, quali:
# - gcc: il compilatore C necessario per costruire alcune dipendenze Python
# - default-libmysqlclient-dev: librerie di sviluppo per MySQL, necessarie per il pacchetto mysqlclient
# - pkg-config: strumento per gestire le librerie di sistema
# Dopo l'installazione, puliamo la cache di apt per ridurre la dimensione dell'immagine
RUN apt-get update && apt-get install -y \
    gcc \
    default-libmysqlclient-dev \
    pkg-config \
    && rm -rf /var/lib/apt/lists/*

# Copia il file requirements.txt e installa le dipendenze Python 
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copia il resto del codice dell'applicazione
COPY . .

# Tenere i due copy separati per sfruttare la cache di Docker e velocizzare le build successive
# cioè se cambiamo un file del codice, non dobbiamo reinstallare tutte le dipendenze

# Crea directory per log
RUN mkdir -p /app/logs

# Espone la porta 8000 per l'applicazione
EXPOSE 8000

# Comando per avviare l'applicazione usando uWSGI con il file di configurazione uwsgi.ini
CMD ["uwsgi", "--ini", "uwsgi.ini"]
