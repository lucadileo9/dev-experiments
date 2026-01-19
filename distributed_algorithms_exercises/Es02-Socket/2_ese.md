# 📁 Documentazione: Client-Server File Transfer

## 🎯 Panoramica del Sistema

L'esercizio 2 implementa un sistema **client-server** per il **trasferimento di file** tramite socket TCP. Il sistema dimostra concetti avanzati di networking, gestione degli errori e trasferimento di dati di grandi dimensioni.

---

## 🏗️ Architettura del Sistema

```
    CLIENT                      RETE                      SERVER
┌─────────────┐             ┌─────────┐              ┌─────────────┐
│             │             │         │              │             │
│ 1. Input    │────────────▶│ Socket  │─────────────▶│ 1. Listen   │
│ 2. Send     │             │ TCP/IP  │              │ 2. Accept   │
│    filename │             │         │              │ 3. Read     │
│ 3. Receive  │◀────────────│ Buffer  │◀─────────────│    File     │
│    content  │             │ 4KB     │              │ 4. Send     │
│ 4. Save     │             │ chunks  │              │    Content  │
│    locally  │             │         │              │             │
└─────────────┘             └─────────┘              └─────────────┘
```

### 🔄 Flusso di Comunicazione Dettagliato

1. **Server Startup**: Il server si mette in ascolto su localhost:12345
2. **Client Connection**: Il client si connette al server
3. **Filename Request**: Client chiede all'utente il nome del file
4. **Filename Transmission**: Client invia il nome del file al server
5. **File Processing**: Server tenta di aprire e leggere il file
6. **Content Transmission**: Server invia il contenuto (o messaggio di errore)
7. **Content Reception**: Client riceve i dati in chunks di 4KB
8. **Local Storage**: Client salva il contenuto in `received_<filename>`
9. **Connection Close**: Entrambi chiudono la connessione

---

## 🔧 Meccanismo Dettagliato

### 📡 Lato Server

```python
# 1. SETUP INIZIALE
server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
server_socket.bind(('localhost', 12345))
server_socket.listen(5)

# 2. LOOP PRINCIPALE
while True:
    # 3. ACCETTAZIONE CLIENT
    client_socket, client_address = server_socket.accept()
    
    # 4. RICEZIONE NOME FILE
    filename = client_socket.recv(1024).decode('utf-8')
    
    # 5. GESTIONE ROBUSTA LETTURA FILE
    try:
        with open(filename, 'r', encoding='utf-8') as file:
            content = file.read()
            client_socket.send(content.encode('utf-8'))
    except FileNotFoundError:
        error_msg = f"ERRORE: File '{filename}' non trovato"
        client_socket.send(error_msg.encode('utf-8'))
    except UnicodeDecodeError:
        error_msg = f"ERRORE: Problemi di encoding nel file '{filename}'"
        client_socket.send(error_msg.encode('utf-8'))
    except PermissionError:
        error_msg = f"ERRORE: Permessi insufficienti per '{filename}'"
        client_socket.send(error_msg.encode('utf-8'))
    
    # 6. CHIUSURA CONNESSIONE CLIENT
    client_socket.close()
```

### 💻 Lato Client

```python
# 1. SETUP CON TIMEOUT
client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
client_socket.settimeout(10.0)  # Timeout di 10 secondi

# 2. CONNESSIONE AL SERVER
client_socket.connect(('localhost', 12345))

# 3. INPUT E INVIO FILENAME
filename = input("Nome file: ")
client_socket.send(filename.encode('utf-8'))

# 4. RICEZIONE ROBUSTA CON BUFFER DINAMICO
response_parts = []
while True:
    try:
        chunk = client_socket.recv(4096).decode('utf-8')
        if not chunk:  # Connessione chiusa dal server
            break
        response_parts.append(chunk)
    except socket.timeout:
        break

response = ''.join(response_parts)

# 5. GESTIONE INTELLIGENTE RISPOSTA
if response.startswith("ERRORE:"):
    print(f"❌ {response}")
else:
    with open(f"received_{filename}", 'w', encoding='utf-8') as file:
        file.write(response)
    print(f"✅ File salvato come 'received_{filename}'")

# 6. CHIUSURA
client_socket.close()
```

---

## 📖 Funzioni e Concetti Avanzati

### 🔄 **Gestione Buffer Dinamici**

#### `recv()` con Loop Controllato
```python
response_parts = []
while True:
    chunk = client_socket.recv(4096)  # Buffer di 4KB
    if not chunk:  # Connessione chiusa dal server
        break
    response_parts.append(chunk.decode('utf-8'))
```

**Vantaggi:**
- **Scalabilità**: Gestisce file di qualsiasi dimensione
- **Efficienza**: Buffer ottimale di 4KB
- **Memoria**: Non carica tutto in memoria simultaneamente
- **Robustezza**: Gestisce interruzioni di rete

### 🛡️ **Gestione Errori Stratificata**

#### Lato Server
```python
try:
    with open(filename, 'r', encoding='utf-8') as file:
        content = file.read()
        # Invio riuscito
except FileNotFoundError:
    # File inesistente
except UnicodeDecodeError:
    # Problemi di encoding
except PermissionError:
    # Accesso negato
except Exception as e:
    # Errore generico
```

#### Lato Client
```python
try:
    # Operazioni di rete
except ConnectionRefusedError:
    # Server non disponibile
except socket.timeout:
    # Timeout di rete
except Exception as e:
    # Altri errori
```

### ⏱️ **Timeout Management**

```python
client_socket.settimeout(10.0)  # Timeout globale
```

**Scopi del timeout:**
- **Evita blocchi infiniti** se il server non risponde
- **Gestisce connessioni lente** in modo elegante
- **Migliora l'esperienza utente** con feedback tempestivo

### 🔤 **Encoding UTF-8 Universale**

```python
# Lettura file
with open(filename, 'r', encoding='utf-8') as file:

# Invio dati
data.encode('utf-8')

# Ricezione dati  
chunk.decode('utf-8')

# Salvataggio file
with open(output_file, 'w', encoding='utf-8') as file:
```

**Benefici UTF-8:**
- **Compatibilità universale** con tutti i caratteri
- **Standard web** per trasferimenti internazionali
- **Retrocompatibilità** con ASCII
- **Efficienza** per testi occidentali

---

## 🎓 Concetti Didattici Avanzati

### 📊 **Pattern di Comunicazione File Transfer**

| Fase | Client | Server | Dati Trasferiti |
|------|--------|--------|-----------------|
| **Setup** | `connect()` | `accept()` | Handshake TCP |
| **Request** | `send(filename)` | `recv()` | Nome file (string) |
| **Processing** | `recv() loop` | File I/O + `send()` | Contenuto file (chunks) |
| **Cleanup** | `close()` | `close()` | Terminazione connessione |

### 🔄 **Stati del Trasferimento**

```
CLIENT                 SERVER
  │                     │
  ├──── connect() ────▶ │ accept()
  │                     │
  ├──── filename ────▶  │ recv()
  │                     │ open_file()
  │                     │ read_content()
  │ recv() loop  ◀──────┤ send(content)
  │                     │
  │ save_file()         │
  │                     │
  ├──── close() ──────▶ │ close()
```

### 🧠 **Algoritmi di Buffer Management**

#### Strategia Ottimale
```python
BUFFER_SIZE = 4096  # 4KB - bilanciamento memoria/prestazioni

while True:
    chunk = socket.recv(BUFFER_SIZE)
    if len(chunk) == 0:        # Connessione chiusa dal server
        break
    else:                      # Continua a ricevere
        process_chunk(chunk)
        continue
```

**Considerazioni:**
- **1KB**: Troppo piccolo → molte system call
- **64KB**: Troppo grande → latenza alta
- **4KB**: Ottimale → bilancia prestazioni e memoria

---


## 🔄 Cambiamenti e Miglioramenti Apportati

### 🚨 **Problemi Riscontrati nel cambiamento da 1_exe a 2_exe**

#### **PROBLEMA 1: Errore di Encoding**
```bash
❌ ERRORE ORIGINALE:
'charmap' codec can't decode byte 0x8f in position 326: character maps to <undefined>
```

**🔧 CAUSA:**
- Windows usa di default il codec 'cp1252' (charmap)
- cp1252 non supporta tutti i caratteri Unicode
- File con caratteri speciali causavano crash

**✅ SOLUZIONE IMPLEMENTATA:**
```python
# PRIMA (problematico):
with open(data, 'r') as file:  # ❌ Encoding di sistema

# DOPO (risolto):
with open(data, 'r', encoding='utf-8') as file:  # ✅ UTF-8 forzato
```

**📈 BENEFICI:**
- Supporto universale per tutti i caratteri Unicode
- Compatibilità cross-platform (Windows/Linux/Mac)
- Gestione corretta di emoji, accenti, caratteri speciali

---

#### **PROBLEMA 2: File Non Trovati**
```bash
❌ ERRORE ORIGINALE:
[Errno 2] No such file or directory: '1_ese'
```

**🔧 CAUSA:**
- Nessuna gestione dell'eccezione `FileNotFoundError`
- Server crashava quando il file non esisteva
- Client rimaneva in attesa indefinita

**✅ SOLUZIONE IMPLEMENTATA:**
```python
# PRIMA (crashava):
with open(data, 'r') as file:
    file_content = file.read()

# DOPO (gestione robusta):
try:
    with open(data, 'r', encoding='utf-8') as file:
        file_content = file.read()
        client_socket.send(file_content.encode('utf-8'))
except FileNotFoundError:
    error_message = f"ERRORE: File '{data}' non trovato sul server"
    client_socket.send(error_message.encode('utf-8'))
except UnicodeDecodeError:
    error_message = f"ERRORE: Problemi di encoding nel file '{data}'"
    client_socket.send(error_message.encode('utf-8'))
except PermissionError:
    error_message = f"ERRORE: Permessi insufficienti per '{data}'"
    client_socket.send(error_message.encode('utf-8'))
```

**📈 BENEFICI:**
- Server continua a funzionare anche con errori
- Client riceve feedback chiaro sui problemi
- Gestione di tutti i tipi di errori I/O

---

#### **PROBLEMA 3: Limitazione Buffer**
```bash
❌ PROBLEMA ORIGINALE:
recv(1024) - Limitato a 1KB, file grandi troncati
```

**🔧 CAUSA:**
- Buffer fisso di 1024 bytes
- File più grandi di 1KB venivano troncati
- Nessuna gestione per dati multi-chunk

**✅ SOLUZIONE IMPLEMENTATA:**
```python
# PRIMA (limitato):
response = client_socket.recv(1024).decode('utf-8')  # ❌ Solo 1KB

# DOPO (illimitato):
response_parts = []
while True:
    try:
        chunk = client_socket.recv(4096).decode('utf-8')  # 4KB per volta
        if not chunk:  # Fine trasmissione
            break
        response_parts.append(chunk)
        if len(chunk) < 4096:  # Ultimo pezzo
            break
    except socket.timeout:
        break

response = ''.join(response_parts)  # Ricostruzione completa
```

**📈 BENEFICI:**
- Gestione file di qualsiasi dimensione
- Buffer più efficiente (4KB invece di 1KB)
- Ricezione completa e affidabile

---

#### **PROBLEMA 4: Rischio di Blocco Infinito**
```bash
❌ PROBLEMA ORIGINALE:
Client poteva rimanere bloccato indefinitamente in recv()
```

**🔧 CAUSA:**
- Nessun timeout configurato
- Se il server si bloccava, client aspettava per sempre
- Esperienza utente frustrante

**✅ SOLUZIONE IMPLEMENTATA:**
```python
# PRIMA (blocco infinito):
client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# DOPO (timeout intelligente):
client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
client_socket.settimeout(10.0)  # ✅ Timeout di 10 secondi
```

**📈 BENEFICI:**
- Nessun blocco infinito
- Feedback tempestivo in caso di problemi
- Esperienza utente più fluida

---

#### **PROBLEMA 5: Gestione Messaggi di Errore**
```bash
❌ PROBLEMA ORIGINALE:
Client salvava messaggi di errore come contenuto file
```

**🔧 CAUSA:**
- Client non distingueva tra contenuto valido e messaggi di errore
- Messaggi di errore venivano salvati in file `received_*`
- Confusione per l'utente finale

**✅ SOLUZIONE IMPLEMENTATA:**
```python
# PRIMA (salva tutto):
with open(f"received_{message}", 'w') as file:
    file.write(response)  # ❌ Salva anche errori

# DOPO (intelligente):
if response.startswith("ERRORE:"):
    print(f"❌ {response}")  # ✅ Mostra errore
else:
    with open(f"received_{message}", 'w', encoding='utf-8') as file:
        file.write(response)
    print(f"📥 File salvato: {len(response)} caratteri")
```

**📈 BENEFICI:**
- Distinzione chiara tra successo ed errore
- File salvati solo quando il contenuto è valido
- Feedback informativo per l'utente

---

#### **PROBLEMA 6: Logica di Ricezione Errata per File Lunghi**
```bash
❌ PROBLEMA CRITICO:
File lunghi venivano troncati a causa di logica di ricezione errata
```

**🔧 CAUSA:**
- Assunzione errata: chunk < 4096 bytes = fine trasmissione
- Realtà TCP: i chunk possono essere di qualsiasi dimensione per motivi di rete
- File lunghi venivano troncati quando arrivava casualmente un chunk piccolo

**✅ SOLUZIONE IMPLEMENTATA:**
```python
# PRIMA (logica errata):
while True:
    chunk = client_socket.recv(4096).decode('utf-8')
    if not chunk:
        break
    response_parts.append(chunk)
    if len(chunk) < 4096:  # ❌ ERRATO: interrompeva prematuramente
        break

# DOPO (logica corretta):
while True:
    chunk = client_socket.recv(4096).decode('utf-8')
    if not chunk:  # ✅ CORRETTO: solo quando server chiude connessione
        break
    response_parts.append(chunk)
    # ✅ RIMOSSA la logica errata del chunk < 4096
```

**🔧 MIGLIORAMENTO SERVER:**
```python
# Aggiunto shutdown esplicito per segnalare fine trasmissione
client_socket.send(file_content.encode('utf-8'))
client_socket.shutdown(socket.SHUT_WR)  # ✅ Segnala EOF al client
```

**📈 BENEFICI:**
- File di qualsiasi dimensione trasferiti correttamente
- Gestione robusta di frammentazione TCP
- Segnalazione esplicita di fine trasmissione
- Trasferimento affidabile anche con connessioni lente

---

*Documentazione creata per il corso di Algoritmi Distribuiti - 9 Ottobre 2025*

*Versione: 2.0 - File Transfer con gestione errori avanzata*