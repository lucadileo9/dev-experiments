# Esercitazioni di Algoritmi Distribuiti

Repository contenente esercitazioni pratiche per il corso di **Algoritmi Distribuiti**, focalizzate su programmazione di rete, sistemi distribuiti e comunicazione client-server.

---

## Panoramica Esercitazioni

| # | Nome | Linguaggio | Argomento | 
|---|------|-----------|-----------|
| **Es02** | Socket Programming | Python 3.7+ | TCP, Client-Server | 
| **Es03** | Remote Method Invocation | Java 8+ | RMI, Distributed Objects | 

---

## Es02-Socket - Programmazione Socket TCP

Esercitazioni fondamentali su socket programming e comunicazione client-server in Python.

### Esercizio 1: String Reversal

```
Consegna:

Server side
- Receives a string of variable length
- Returns the overturned string

Client side
- Sends a string
- Receives an elaborated string
- Prints the received string

Obiettivo: Sistema client-server per inversione di stringhe  
File: `Es02-Socket/1_exe.py`, `1_ese.md`  

Concetti: Socket TCP, encoding UTF-8, gestione connessioni  
```

### Esercizio 2: File Transfer

```
Consegna:

Server side
- Receives the name of a file
- Opens the file and sends the content to the client

Client side
- Sends a string representing the name of a file
- Receives the content of the requested file
- Writes the content to a new local file

Obiettivo: Trasferimento di file via rete con gestione errori robusta  
File: `Es02-Socket/2_exe.py`, `2_ese.md`  

Concetti: Buffer dinamici, gestione file, encoding, timeout  
```
---

## Es03-RMI - Remote Method Invocation (Java)

Sistema di comunicazione client-server basato su RMI per l'invocazione di metodi remoti.

### Esercizio 1: String Reversal
```
Consegna:

The server accepts a string as argument and returns the overturned string. The client sends a string, receives an elaborated string and prints the received string.

Obiettivo: Sistema RMI per inversione di stringhe  
Percorso: `Es03-RMI/01_reverse_string/`  
File principali:
- `StringReverseInterface.java` - Interfaccia remota
- `StringReverseServerRMI.java` - Server RMI
- `StringReverseClientRMI.java` - Client RMI
- `README.md` - Documentazione completa

Concetti: RMI, Remote Objects, Registry, Stub/Skeleton  
```
### Esercizio 2: Greet and Local Time
```
Consegna:

The server provides 2 services:
- Greeting
- Local time

The client receives from command line an argument specifying the service to ask to the server.

Obiettivo: Servizio RMI per saluti personalizzati e ora locale  
Percorso: `Es03-RMI/02_greet_and_local_time/`  
File principali:
- `GreetLocalTimeInterface.java` - Interfaccia remota
- `GreetLocalTimeServer.java` - Server RMI
- `GreetLocalTimeClient.java` - Client RMI
- `README.md` - Documentazione completa

Concetti: Metodi multipli remoti, java.time API, Registry RMI  
```
### Esercizio 3: File Access

```
Consegna:

The server receives:
- The name of a file
- The position of the byte to be read

The server opens the file, reads the byte at the specified position and returns the read byte.

The client:
- Sends a string representing the name of a file and the position of a byte to be read
- Receives the read byte
- Writes the byte to a local file

Obiettivo: Accesso remoto ai file con lettura selettiva di byte  
Percorso: `Es03-RMI/03_file_access/`  
File principali:
- `FileAccessInterface.java` - Interfaccia remota
- `FileAccessServer.java` - Server RMI con gestione file
- `FileAccessClient.java` - Client RMI con input interattivo
- `README.md` - Documentazione completa

Concetti: File I/O remoto, input utente, gestione eccezioni RMI, Scanner  
```
---

## Guida Rapida per l'Esecuzione

### Python (Es02-Socket)

**Prerequisiti**:
- Python 3.7+
- Nessuna libreria esterna richiesta (solo moduli standard)

**Esecuzione**:
```bash
# Naviga nella cartella
cd Es02-Socket

# Avvia il programma
python 1_exe.py  # Esercizio 1
python 2_exe.py  # Esercizio 2

# Segui il menu interattivo:
# [s] Server - Avvia il server
# [c] Client - Avvia il client  
# [h] Help   - Guida dettagliata
```

### Java (Es03-RMI)

**Prerequisiti**:
- Java 8+ (JDK)
- `javac` compiler
- Nessuna libreria esterna

**Esecuzione**:
```bash
# Naviga nella cartella dell'esercizio
cd Es03-RMI/01_reverse_string  # (o 02_greet_and_local_time, o 03_file_access)

# 1. Compilazione
javac *Interface.java *Server.java *Client.java

# 2. Avvia il server (Terminale 1)
java *Server

# 3. Avvia il client (Terminale 2)
java *Client
```

---

## Obiettivi Didattici

### Concetti Fondamentali Coperti

#### Socket Programming (Python)
- Creazione e gestione socket TCP
- Architettura Client-Server
- Protocollo TCP/IP
- Gestione errori robusti
- Serializzazione dati (UTF-8, Binary)

#### Remote Method Invocation (Java)
- Distributed Objects
- Remote Interfaces
- RMI Registry (naming service)
- Stub e Skeleton
- Marshalling/Unmarshalling
- Gestione eccezioni di rete
- File I/O remoto
- Input/Output interattivo

---

## Struttura Directory

```
algoritmi_distribuiti_esercitazioni/
│
├── README.md                                  # Questo file
├── .gitignore                                 # Configurazione Git
│
├── Es02-Socket/                               # Esercitazioni Socket TCP (Python)
│   ├── 1_exe.py                               # Esercizio 1: String Reversal
│   ├── 1_ese.md                               # Documentazione Es02-01
│   ├── 2_exe.py                               # Esercizio 2: File Transfer
│   ├── 2_ese.md                               # Documentazione Es02-02
│   ├── java/                                  # Versione Java opzionale
│   │   ├── StringReverseClient.java
│   │   └── StringReverseServer.java
│   ├── prova                                  # File di test
│   ├── received_*                             # File ricevuti (generati)
│   └── ...
│
└── Es03-RMI/                                  # Esercitazioni RMI (Java)
    │
    ├── 01_reverse_string/                     # Es03-01: String Reversal con RMI
    │   ├── StringReverseInterface.java        # Interfaccia remota
    │   ├── StringReverseServerRMI.java        # Server RMI
    │   ├── StringReverseClientRMI.java        # Client RMI
    │   ├── README.md                          # Documentazione dettagliata
    │   └── *.class                            # File compilati
    │
    ├── 02_greet_and_local_time/               # Es03-02: Greet & Time con RMI
    │   ├── GreetLocalTimeInterface.java       # Interfaccia remota
    │   ├── GreetLocalTimeServer.java          # Server RMI
    │   ├── GreetLocalTimeClient.java          # Client RMI
    │   ├── README.md                          # Documentazione dettagliata
    │   └── *.class                            # File compilati
    │
    └── 03_file_access/                        # Es03-03: File Access con RMI
        ├── FileAccessInterface.java           # Interfaccia remota
        ├── FileAccessServer.java              # Server RMI + File I/O
        ├── FileAccessClient.java              # Client RMI + Input interattivo
        ├── input.txt                          # File di test remoto
        ├── output.txt                         # File generato dal client
        ├── README.md                          # Documentazione dettagliata
        └── *.class                            # File compilati
```

---

## Documentazione

Ogni esercizio include:
- Codice completamente commentato con spiegazioni dettagliate
- README.md dedicato con:
  - Panoramica del sistema
  - Diagrammi mermaid (architettura, sequenze, flussi)
  - Analisi dettagliata dei componenti
  - Esempi di esecuzione con output
  - Concetti teorici spiegati
  - Troubleshooting e note tecniche
- Esempi pratici e casi d'uso reali
- Gestione errori robusta

---

## Setup Iniziale

### 1. Clona il Repository
```bash
git clone https://github.com/lucadileo9/algoritmi_distribuiti_esercitazioni.git
cd algoritmi_distribuiti_esercitazioni
```

### 2. Verifica Prerequisiti

**Per Es02 (Python)**:
```bash
python --version  # Deve essere 3.7+
```

**Per Es03 (Java)**:
```bash
java -version     # Deve essere 8+
javac -version    # Deve essere disponibile
```

### 3. Esegui un Esercizio

```bash
# Esempio: Es03-03 File Access
cd Es03-RMI/03_file_access
javac *.java
java FileAccessServer    # In un terminale
java FileAccessClient    # In un altro terminale
```

---

*Materiale didattico per il corso di Algoritmi Distribuiti*  
*Docente: Prof. Cabri - Università di Modena e Reggio Emilia*  
*Aggiornato: Dicembre 2025*
