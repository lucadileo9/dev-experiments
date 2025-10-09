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

#### `listen(ba