# 📚 Documentazione: Client-Server String Reversal

## 🎯 Panoramica del Sistema

Il nostro esercizio implementa un sistema **client-server** basato su **socket TCP** per l'inversione di stringhe. Il sistema dimostra i concetti fondamentali della programmazione di rete e dell'architettura distribuita.

---

## 🏗️ Architettura del Sistema

```
    CLIENT                      RETE                      SERVER
┌─────────────┐             ┌─────────┐              ┌─────────────┐
│             │             │         │              │             │
│ 1. Input    │────────────▶│ Socket  │─────────────▶│ 1. Listen   │
│ 2. Send     │             │ TCP/IP  │              │ 2. Accept   │
│ 3. Receive  │◀────────────│         │◀─────────────│ 3. Process  │
│ 4. Display  │             │         │              │ 4. Send     │
│             │             │         │              │             │
└─────────────┘             └─────────┘              └─────────────┘
```

### 🔄 Flusso di Comunicazione

1. **Server Setup**: Il server si mette in ascolto su porta 12345
2. **Client Connection**: Il client si connette al server
3. **Data Exchange**: 
   - Client invia stringa → Server
   - Server inverte stringa
   - Server invia stringa invertita → Client
4. **Connection Close**: Entrambi chiudono la connessione

---

## 🔧 Meccanismo Dettagliato

### 📡 Lato Server

```python
# 1. CREAZIONE SOCKET
server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# 2. CONFIGURAZIONE RIUSO INDIRIZZO
server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)

# 3. BINDING ALL'INDIRIZZO
server_socket.bind(('localhost', 12345))

# 4. ASCOLTO CONNESSIONI
server_socket.listen(5)

# 5. LOOP PRINCIPALE
while True:
    # 6. ACCETTAZIONE CLIENT
    client_socket, client_address = server_socket.accept()
    
    # 7. RICEZIONE DATI
    data = client_socket.recv(1024).decode('utf-8')
    
    # 8. ELABORAZIONE (INVERSIONE)
    reversed_string = data[::-1]
    
    # 9. INVIO RISPOSTA
    client_socket.send(reversed_string.encode('utf-8'))
    
    # 10. CHIUSURA CONNESSIONE CLIENT
    client_socket.close()
```

### 💻 Lato Client

```python
# 1. CREAZIONE SOCKET
client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# 2. CONNESSIONE AL SERVER
client_socket.connect(('localhost', 12345))

# 3. INPUT UTENTE
message = input("Inserisci stringa: ")

# 4. INVIO DATI
client_socket.send(message.encode('utf-8'))

# 5. RICEZIONE RISPOSTA
response = client_socket.recv(1024).decode('utf-8')

# 6. VISUALIZZAZIONE RISULTATO
print(f"Stringa invertita: {response}")

# 7. CHIUSURA CONNESSIONE
client_socket.close()
```

---

## 📖 Funzioni Socket - Riferimento Completo

### 🏗️ **Creazione e Configurazione**

#### `socket.socket(family, type)`
```python
socket.socket(socket.AF_INET, socket.SOCK_STREAM)
```
- **Scopo**: Crea un nuovo socket
- **Parametri**:
  - `AF_INET`: Famiglia di indirizzi IPv4
  - `SOCK_STREAM`: Tipo TCP (connessione affidabile)
- **Restituisce**: Oggetto socket
- **Alternativa**: `AF_INET6` per IPv6, `SOCK_DGRAM` per UDP

#### `setsockopt(level, optname, value)`
```python
server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
```
- **Scopo**: Configura opzioni del socket
- **Parametri**:
  - `SOL_SOCKET`: Livello socket
  - `SO_REUSEADDR`: Permette riuso dell'indirizzo
  - `1`: Abilita l'opzione
- **Utilità**: Evita errore "Address already in use"

---

### 🔗 **Connessione e Binding**

#### `bind(address)`
```python
server_socket.bind(('localhost', 12345))
```
- **Scopo**: Associa il socket a un indirizzo specifico
- **Parametri**: Tupla (host, porta)
- **Uso**: Solo lato server
- **Note**: Richiede porta > 1024 per utenti non-admin

#### `listen(backlog)`
```python
server_socket.listen(5)
```
- **Scopo**: Mette il socket in modalità ascolto
- **Parametri**: `backlog` = numero max connessioni in coda
- **Comportamento**: Il socket diventa passivo, pronto ad accettare connessioni
- **Raccomandazione**: Valore 5-10 per applicazioni semplici

#### `connect(address)`
```python
client_socket.connect(('localhost', 12345))
```
- **Scopo**: Connette il socket a un indirizzo remoto
- **Parametri**: Tupla (host, porta)
- **Uso**: Solo lato client
- **Eccezioni**: `ConnectionRefusedError` se server non disponibile

#### `accept()`
```python
client_socket, client_address = server_socket.accept()
```
- **Scopo**: Accetta una connessione in entrata
- **Comportamento**: Blocca fino a quando arriva una connessione
- **Restituisce**: 
  - `client_socket`: Nuovo socket per comunicare con il client
  - `client_address`: Indirizzo del client (IP, porta)
- **Uso**: Solo lato server

---

### 📡 **Trasmissione Dati**

#### `send(data)`
```python
client_socket.send(message.encode('utf-8'))
```
- **Scopo**: Invia dati attraverso il socket
- **Parametri**: Dati in formato bytes
- **Restituisce**: Numero di bytes inviati
- **Note**: Potrebbe non inviare tutti i dati in una volta
- **Encoding**: Necessario convertire stringhe in bytes

#### `recv(bufsize)`
```python
data = client_socket.recv(1024)
```
- **Scopo**: Riceve dati dal socket
- **Parametri**: `bufsize` = dimensione massima buffer (in bytes)
- **Comportamento**: Blocca fino a quando arrivano dati
- **Restituisce**: Dati in formato bytes
- **Note**: Potrebbe ricevere meno dati di quelli disponibili

#### `sendall(data)`
```python
socket.sendall(data)
```
- **Scopo**: Invia tutti i dati, riprovando se necessario
- **Vantaggio**: Garantisce l'invio completo dei dati
- **Uso**: Preferibile a `send()` per dati critici

---

### 🔒 **Gestione Connessione**

#### `close()`
```python
client_socket.close()
```
- **Scopo**: Chiude il socket e libera le risorse
- **Comportamento**: Termina la connessione
- **Importanza**: Sempre chiamare per evitare memory leak
- **Best Practice**: Usare nei blocchi `finally`

#### `shutdown(how)`
```python
socket.shutdown(socket.SHUT_RDWR)
```
- **Scopo**: Chiude parzialmente la connessione
- **Parametri**:
  - `SHUT_RD`: Chiude ricezione
  - `SHUT_WR`: Chiude invio
  - `SHUT_RDWR`: Chiude entrambi
- **Differenza**: Più controllato di `close()`

---

### 🔤 **Encoding/Decoding**

#### `encode(encoding)`
```python
message.encode('utf-8')
```
- **Scopo**: Converte stringa in bytes
- **Parametri**: Tipo di encoding (utf-8, ascii, ecc.)
- **Necessità**: I socket trasmettono solo bytes
- **Standard**: UTF-8 per supporto caratteri internazionali

#### `decode(encoding)`
```python
data.decode('utf-8')
```
- **Scopo**: Converte bytes in stringa
- **Parametri**: Tipo di encoding (deve corrispondere all'encoding di invio)
- **Uso**: Dopo `recv()` per ottenere stringhe leggibili

---

## 🎓 **Concetti Didattici Avanzati**

### 🔄 **Stati del Socket TCP**

1. **CLOSED**: Socket creato ma non connesso
2. **LISTEN**: Server in ascolto (dopo `listen()`)
3. **SYN_SENT**: Client ha inviato richiesta connessione
4. **ESTABLISHED**: Connessione stabilita
5. **CLOSE_WAIT**: Una parte ha chiuso, l'altra ancora attiva
6. **CLOSED**: Connessione completamente chiusa

### 📊 **Protocollo TCP vs UDP**

| Caratteristica | TCP (SOCK_STREAM) | UDP (SOCK_DGRAM) |
|----------------|-------------------|------------------|
| **Affidabilità** | Garantita | Non garantita |
| **Ordine** | Preservato | Non preservato |
| **Connessione** | Connection-oriented | Connectionless |
| **Overhead** | Maggiore | Minore |
| **Uso tipico** | Web, email, file transfer | Gaming, streaming, DNS |

## 📝 **Note per lo Studio**

### 💡 **Punti Chiave da Ricordare**

1. **Socket = Endpoint di comunicazione**: Astrazione per comunicazione di rete
2. **TCP = Affidabile**: Garantisce consegna e ordine dei dati
3. **Client-Server = Asimmetrico**: Ruoli diversi, server sempre in ascolto
4. **Encoding = Necessario**: I socket trasmettono bytes, non stringhe
5. **Gestione Errori = Critica**: La rete può fallire in qualsiasi momento

---

*Documentazione creata per il corso di Algoritmi Distribuiti - 9 Ottobre 2025*