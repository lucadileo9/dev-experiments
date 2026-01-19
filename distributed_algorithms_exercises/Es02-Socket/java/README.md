# 📚 Esercizio Java - String Reverse con Socket

## 🎯 Obiettivo
Implementare un sistema client-server in Java che inverte stringhe usando socket TCP.

---

## 📁 File Forniti

- **`StringReverseServer.java`** - Server che riceve stringhe e le inverte
- **`StringReverseClient.java`** - Client che invia stringhe e riceve il risultato
- **`README.md`** - Questa guida

---

## 🚀 Come Compilare ed Eseguire

### **1️⃣ Compilazione**

```bash
# Naviga nella cartella java
cd Es03-RMI/socket_version
# Compila entrambi i file
javac StringReverseServer.java
javac StringReverseClient.java
```

### **2️⃣ Esecuzione**

**Terminale 1 - Server:**
```bash
java StringReverseServer
```

**Terminale 2 - Client:**
```bash
java StringReverseClient
```

### **3️⃣ Test**
1. Avvia prima il **server** (Terminale 1)
2. Poi avvia il **client** (Terminale 2)
3. Inserisci una stringa quando richiesto
4. Osserva il risultato invertito!

---

## 🔧 Architettura

```
    CLIENT                      RETE                      SERVER
┌─────────────┐             ┌─────────┐              ┌─────────────┐
│             │             │         │              │             │
│ 1. Input    │────────────▶│ Socket  │─────────────▶│ 1. Accept   │
│ 2. Send     │             │ TCP/IP  │              │ 2. Receive  │
│    string   │             │         │              │ 3. Reverse  │
│ 3. Receive  │◀────────────│         │◀─────────────│ 4. Send     │
│ 4. Print    │             │         │              │    back     │
│             │             │         │              │             │
└─────────────┘             └─────────┘              └─────────────┘
```

---

## 📖 Concetti Java Utilizzati

### **Socket Programming**
```java
// SERVER - Accetta connessioni
ServerSocket serverSocket = new ServerSocket(PORT);
Socket clientSocket = serverSocket.accept();

// CLIENT - Si connette al server
Socket socket = new Socket(HOST, PORT);
```

### **Stream I/O**
```java
// OUTPUT - Invia dati
PrintWriter out = new PrintWriter(socket.getOutputStream(), true);
out.println("messaggio");

// INPUT - Riceve dati
BufferedReader in = new BufferedReader(
    new InputStreamReader(socket.getInputStream())
);
String data = in.readLine();
```

### **String Reverse**
```java
// Metodo efficiente con StringBuilder
String reversed = new StringBuilder(original).reverse().toString();
```

### **Try-with-Resources**
```java
try (Socket socket = new Socket(HOST, PORT)) {
    // Il socket viene chiuso automaticamente
}
```

---

## 🎓 Differenze Python vs Java

| Aspetto | Python | Java |
|---------|--------|------|
| **Socket Creation** | `socket.socket()` | `new Socket()` |
| **Server Listen** | `socket.listen()` | `new ServerSocket()` |
| **Data I/O** | `send()`, `recv()` | `PrintWriter`, `BufferedReader` |
| **String Reverse** | `s[::-1]` | `StringBuilder.reverse()` |
| **Resource Mgmt** | `with` statement | `try-with-resources` |
| **Type Safety** | Dynamic | Static (compile-time) |


---

## 💡 Esempio di Esecuzione

### **Output Server:**
```
==================================================
SERVER - String Reverse
==================================================
✓ Server avviato sulla porta 12345
✓ In attesa di connessioni...

──────────────────────────────────────────────────
📡 Nuova connessione da: 127.0.0.1:54321
📥 Ricevuto: "Ciao Mondo"
🔄 Invertito: "odnuM oaiC"
📤 Risposta inviata al client
✓ Connessione chiusa
```

### **Output Client:**
```
==================================================
CLIENT - String Reverse
==================================================
✓ Connesso al server localhost:12345
──────────────────────────────────────────────────

📝 Inserisci una stringa da invertire: Ciao Mondo
📤 Invio al server: "Ciao Mondo"
📥 Ricevuto dal server: "odnuM oaiC"

==================================================
✅ RISULTATO FINALE
==================================================
Originale: Ciao Mondo
Invertita: odnuM oaiC
==================================================
```

---


## 📝 Note Tecniche

### **Porta Utilizzata**: `12345`
- Porta custom > 1024 (non richiede privilegi admin)
- Modificabile nelle costanti `PORT`

### **Host**: `localhost` (127.0.0.1)
- Comunicazione locale
- Per rete: sostituire con IP del server

### **Encoding**: UTF-8 (default)
- Supporto caratteri internazionali
- Compatibile con tutti i sistemi

### **Protocollo**: TCP
- Connessione affidabile
- Garanzia di ordine e consegna

---

*Esercitazione per il corso di Algoritmi Distribuiti - Dicembre 2025*
