# 📚 Es03-RMI - File Access (RMI)

## 🎯 Panoramica del Sistema

Questo esercizio implementa un sistema **client-server** basato su **RMI** per l'accesso remoto ai file. 

**Caso d'uso reale:**
Immagina di avere un file importante su un server remoto. Invece di scaricarlo tutto (che potrebbe essere gigantesco), vuoi leggere solo i byte che ti servono, uno alla volta. Questo sistema RMI permette al client di leggere specifici byte da un file remoto, come se fosse locale.

### Flusso operativo:
```
CLIENT                          NETWORK                        SERVER
  |                                                              |
  +---- (1) Connetti al Registry RMI --->                       |
  |                                                              |
  +---- (2) Lookup("FileAccessService") --->                   |
  |                                          <---- Stub remoto--|
  |                                                              |
  +---- (3) readByteFromFile("file.txt", 0) -->                |
  |                                           (apri file)       |
  |                                           (salta a pos 0)   |
  |                                           (leggi byte)      |
  |                                          <----- byte_0 ---- |
  |                                                              |
  +--- [scrivi byte_0 nel file locale]                         |
  |                                                              |
  +---- (4) readByteFromFile("file.txt", 1) -->                |
  |                                          <----- byte_1 ---- |
  |                                                              |
  | ... continua fino a N byte ...                             |
```

---

## 🚀 Come Usare il Sistema

### **1️⃣ Preparazione**

Prima di eseguire, crea un file di input sul server:
```bash
cd Es03-RMI/03_file_access

# Windows PowerShell: Crea il file test.txt
"Hello RMI File Access System!" | Out-File -Encoding UTF8 input.txt

# Linux/Mac: Usa echo
echo "Hello RMI File Access System!" > input.txt
```

### **2️⃣ Compilazione**
```bash
# Compila tutti i file
javac FileAccessInterface.java
javac FileAccessServer.java
javac FileAccessClient.java
```

### **3️⃣ Esecuzione**

**Terminale 1 - Server RMI:**
```bash
java FileAccessServer
```

**Terminale 2 - Client RMI:**
```bash
java FileAccessClient
```

### **4️⃣ Verifica dei risultati**

Dopo l'esecuzione, il client avrà creato `output.txt` con i dati letti dal server.

```bash
# Visualizza il file generato
cat output.txt
type output.txt  # Windows
```

---

## 📖 Analisi Dettagliata dei Componenti

### **1. Interface Remota** (`FileAccessInterface.java`)

```java
public interface FileAccessInterface extends Remote {
    byte readByteFromFile(String fileName, long position) throws RemoteException;
}
```

**Cosa fa:**
- Definisce il "contratto" tra client e server
- Dichiara UN metodo remoto: `readByteFromFile()`

**Parametri:**
- `fileName`: Percorso del file sul server (es. `"input.txt"`, `"/data/file.bin"`)
- `position`: Posizione (offset) del byte da leggere
  - Esempio: position=0 legge il primo byte, position=5 legge il sesto byte
  - È un numero a partire da 0 (0-based indexing)

**Valore di ritorno:**
- Restituisce il byte letto come tipo `byte` (valore 0-255)
- Restituisce `-1` per indicare errore o fine file (EOF)

**Eccezioni:**
- `RemoteException`: Lanciata se si verifica errore di rete o I/O

**Perché è importante:**
- Il client sa esattamente come invocare il metodo
- Il server sa esattamente cosa deve implementare
- È il "telefono" che permette client e server di comunicare

---

### **2. Server** (`FileAccessServer.java`)

```
┌─ extends UnicastRemoteObject ──┬─ implements FileAccessInterface ─┐
│  "Rendi l'oggetto remoto"       │  "Implementa il contratto"       │
└────────────────────────────────┴──────────────────────────────────┘
                                  |
                            FileAccessServer
```

#### Costruttore
```java
public FileAccessServer() throws RemoteException {
    super();
}
```
- Chiama il costruttore del padre (`UnicastRemoteObject`)
- Questo "esporta" l'oggetto, rendendolo disponibile per le invocazioni remote
- Lancia `RemoteException` se l'esportazione fallisce

#### Metodo remoto: `readByteFromFile()`

**STEP-BY-STEP della lettura:**

1. **Creazione oggetto File**
   ```java
   File file = new File(fileName);
   ```
   - Crea un riferimento al file (non apre il file ancora)

2. **Validazione - File esiste?**
   ```java
   if (!file.exists()) return -1;
   ```
   - Verifica che il file esista effettivamente

3. **Validazione - È veramente un file?**
   ```java
   if (!file.isFile()) return -1;
   ```
   - Assicura che il percorso sia un file, non una cartella

4. **Apertura del file**
   ```java
   FileInputStream fis = new FileInputStream(file);
   ```
   - Crea uno stream per leggere byte dal file
   - Posiziona il puntatore all'inizio del file (posizione 0)

5. **Validazione - Posizione valida?**
   ```java
   if (position < 0) return -1;
   ```
   - Assicura che la posizione non sia negativa

6. **Salto alla posizione richiesta**
   ```java
   long skipped = fis.skip(position);
   if (skipped < position) return -1;
   ```
   - `skip(n)` salta i primi n byte
   - Verifica che il file sia abbastanza lungo per raggiungere la posizione

   **Esempio:**
   - File: `"Hello"` (5 byte)
   - `skip(2)` lascia il puntatore sul 3° byte: `l`
   - `skip(10)` ritorna 5 (non 10) → errore!

7. **Lettura del byte**
   ```java
   int byteRead = fis.read();
   ```
   - `read()` legge il byte successivo e lo restituisce come intero (0-255)
   - Restituisce -1 se siamo al fine del file

8. **Chiusura del file**
   ```java
   finally {
       if (fis != null) fis.close();
   }
   ```
   - `finally` garantisce che il file sia chiuso SEMPRE
   - Anche se si verifica un'eccezione, il file viene chiuso
   - Questo evita "file descriptor leak" (perdita di risorse)

#### Main del server

```java
public static void main(String[] args) {
    // 1. Crea istanza del server
    FileAccessServer server = new FileAccessServer();
    
    // 2. Crea/ottiene Registry RMI
    Registry registry = LocateRegistry.createRegistry(1099);
    
    // 3. Registra il servizio
    registry.rebind("FileAccessService", server);
}
```

**Cosa succede:**
1. Crea un'istanza del server che diventa "esportabile"
2. Crea il Registry RMI (directory dei servizi) sulla porta 1099
3. Registra il server con il nome `"FileAccessService"`
4. Il server rimane in ascolto di richieste dai client

---

### **3. Client** (`FileAccessClient.java`)

#### Configurazione iniziale
```java
String remoteFileName = "input.txt";   // File da leggere sul server
String localFileName = "output.txt";   // File dove salvare localmente
long positionsToRead = 10;             // Leggi i primi 10 byte
```

#### Step 1: Connessione al Registry
```java
Registry registry = LocateRegistry.getRegistry(1099);
```
- Si connette al Registry RMI sulla porta 1099
- Questo è come "chiamare il centralino" che sa dove trovare i servizi

#### Step 2: Lookup del servizio
```java
FileAccessInterface stub = (FileAccessInterface) registry.lookup("FileAccessService");
```
- Chiede al Registry: "Dove posso trovare FileAccessService?"
- Il Registry risponde: "Ecco uno stub (proxy) che ti permette di chiamare i metodi remoti"
- Lo **stub** è come un "telefonista" che sa come contattare il server

#### Step 3: Apertura file locale
```java
FileOutputStream fos = new FileOutputStream(localFileName);
```
- Crea/apre il file locale dove salverai i dati ricevuti dal server

#### Step 4: Ciclo di lettura
```java
for (long i = 0; i < positionsToRead; i++) {
    byte receivedByte = stub.readByteFromFile(remoteFileName, i);
    
    if (receivedByte == -1) break;  // Fine file
    
    fos.write(receivedByte);        // Scrivi nel file locale
}
```

**Cosa succede in ogni iterazione:**
1. Chiama il metodo remoto `readByteFromFile(remoteFileName, i)`
2. Lo stub invia richiesta al server tramite rete
3. Server legge il byte dalla posizione i
4. Server invia il byte al client
5. Client riceve il byte e lo scrive nel file locale

**Gestione degli errori specifici:**
```java
catch (NotBoundException e) {
    // Servizio non trovato nel Registry
    // Probabilmente il server non è in esecuzione
}

catch (ConnectException e) {
    // Impossibile connettersi al Registry
    // Probabilmente il server RMI non è avviato
}

catch (IOException e) {
    // Errore I/O (file locale)
    // Potrebbero essere permessi o spazio disco insufficiente
}
```

---

## 🎓 Concetti RMI Chiave

### **UnicastRemoteObject**
- Rende un oggetto Java disponibile per invocazioni remote
- Gestisce automaticamente la comunicazione TCP
- Esporta l'oggetto sulla rete

### **Registry RMI (porta 1099)**
- È un "elenco telefonico" distribuito
- Associa nomi simbolici a oggetti remoti
- Client usa `lookup()` per trovare i servizi
- Server usa `bind()` o `rebind()` per registrarsi

### **Stub (Proxy)**
- Rappresentazione locale di un oggetto remoto
- Quando chiami un metodo sullo stub, la richiesta viene inoltrata al server
- Trasparente: sembra una chiamata locale

### **Marshalling/Unmarshalling**
- Conversione dei parametri in byte per la trasmissione di rete
- Java RMI lo fa automaticamente
- Tutti i parametri e i valori di ritorno vengono automaticamente serializzati

### **skip() in FileInputStream**
```java
fis.skip(position);
```
- Salta i primi `position` byte del file
- Restituisce il numero di byte effettivamente saltati
- Se il file è troppo corto, restituisce un numero < position

**Esempio:**
```
File: "ABCDE" (5 byte)
skip(0) → puntatore su 'A'
skip(2) → puntatore su 'C'  (salta A, B)
skip(4) → puntatore su 'E'  (salta A, B, C, D)
skip(5) → EOF (end of file)
skip(10) → ritorna 5, poi read() restituisce -1
```

---

## 💡 Esempi di Esecuzione

### **Scenario: Leggere i primi 5 byte di "Hello"**

**Output Server:**
```
==================================================
SERVER RMI - File Access
==================================================
✓ Registry RMI creato sulla porta 1099
✓ Servizio 'FileAccessService' registrato nel Registry
✓ Server RMI pronto per ricevere richieste di accesso ai file
==================================================
📥 Richiesta ricevuta: file='input.txt', posizione=0
✓ Byte letto: 72 (char: 'H')
📥 Richiesta ricevuta: file='input.txt', posizione=1
✓ Byte letto: 101 (char: 'e')
📥 Richiesta ricevuta: file='input.txt', posizione=2
✓ Byte letto: 108 (char: 'l')
📥 Richiesta ricevuta: file='input.txt', posizione=3
✓ Byte letto: 108 (char: 'l')
📥 Richiesta ricevuta: file='input.txt', posizione=4
✓ Byte letto: 111 (char: 'o')
```

**Output Client:**
```
==================================================
CLIENT RMI - File Access
==================================================
✓ Connesso al Registry RMI sulla porta 1099
✓ Riferimento a 'FileAccessService' ottenuto
──────────────────────────────────────────────────
📝 File di output aperto: output.txt
📝 Byte 0 scritto: 72 (char: 'H')
📝 Byte 1 scritto: 101 (char: 'e')
📝 Byte 2 scritto: 108 (char: 'l')
📝 Byte 3 scritto: 108 (char: 'l')
📝 Byte 4 scritto: 111 (char: 'o')
──────────────────────────────────────────────────
✓ Operazione completata!
✓ Dati scritti in: output.txt
```

**File output.txt creato:**
```
Hello
```

---

## 📝 Note Tecniche

### **Codec dei byte**
- Byte ASCII 72 = Carattere 'H'
- Byte ASCII 101 = Carattere 'e'
- Il cast `(char)byteRead` converte il numero nel carattere corrispondente

### **Gestione risorse**
- **Finally block:** Garantisce chiusura file anche se errore
- **Try-with-resources:** Alternativa moderna (Java 7+)
  ```java
  try (FileInputStream fis = new FileInputStream(file)) {
      // ... codice ...
  } // fis si chiude automaticamente
  ```

### **Porte e Firewall**
- Porta 1099: Registry RMI
- Porta dinamica: Comunicazione effettiva tra client e server (negoziata automaticamente)
- Firewall potrebbe bloccare: Configurare regole per RMI

### **Performance**
- Lettura byte per byte è **lenta**
- Per file grandi, meglio leggere blocchi di byte
- Versione ottimizzata: `byte[] readBytesFromFile(String fileName, long position, int count)`

---

## 📚 Vantaggi di questo sistema RMI

✅ **Accesso remoto trasparente**: Come se il file fosse locale  
✅ **Selettivo**: Leggi solo i byte che ti servono  
✅ **Type-safe**: Compilazione controlla i tipi  
✅ **Sicuro**: Finally garantisce chiusura file  
✅ **Scalabile**: Il registry permette di aggiungere server  

---

## 🔧 Troubleshooting

| Errore | Causa | Soluzione |
|--------|-------|----------|
| `ConnectException` | Server non avviato | Avviare `java FileAccessServer` |
| `NotBoundException` | Servizio non trovato | Verificare nome servizio in lookup() |
| `FileNotFoundException` | File remoto non esiste | Creare il file o verificare percorso |
| `IOException` | Errore I/O nel file locale | Verificare permessi/spazio disco |
| `java.lang.ClassNotFoundException` | Esecuzione con `.class` | Usare `java FileAccessServer` senza estensione |

---

*Esercitazione per il corso di Algoritmi Distribuiti - Dicembre 2025*
