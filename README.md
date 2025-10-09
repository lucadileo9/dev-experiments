# 🌐 Esercitazioni di Algoritmi Distribuiti

Repository contenente esercitazioni pratiche per il corso di **Algoritmi Distribuiti**, focalizzate su programmazione di rete, sistemi distribuiti e comunicazione client-server.

---

## 📚 Struttura del Corso

### 🔌 **Es02-Socket** - Programmazione Socket TCP
Esercitazioni fondamentali su socket programming e comunicazione client-server.

#### **Esercizio 1**: String Reversal
- **Obiettivo**: Sistema client-server per inversione di stringhe
- **File**: `1_exe.py`, `1_ese.md`
- **Concetti**: Socket TCP, encoding UTF-8, gestione connessioni

#### **Esercizio 2**: File Transfer  
- **Obiettivo**: Trasferimento di file via rete con gestione errori robusta
- **File**: `2_exe.py`, `2_ese.md`
- **Concetti**: Buffer dinamici, gestione file, encoding, timeout

---

## 🚀 Come Utilizzare

### **Prerequisiti**
- Python 3.7+
- Nessuna libreria esterna richiesta (solo moduli standard)

### **Esecuzione Rapida**
```bash
# Naviga nella cartella dell'esercizio
cd Es02-Socket

# Avvia il programma
python 1_exe.py  # Per esercizio 1
python 2_exe.py  # Per esercizio 2

# Segui il menu interattivo:
# [s] Server - Avvia il server
# [c] Client - Avvia il client  
# [h] Help   - Guida dettagliata
```

### **Test Completo**
1. **Terminale 1**: `python 2_exe.py` → scegli `[s]` (Server)
2. **Terminale 2**: `python 2_exe.py` → scegli `[c]` (Client)
3. **Client**: inserisci nome file (es. `1_ese.md`)
4. **Risultato**: file salvato come `received_1_ese.md`

---

## 🎓 Obiettivi Didattici

### **Concetti Fondamentali**
- **Socket Programming**: Creazione e gestione socket TCP
- **Architettura Client-Server**: Pattern di comunicazione asincrona
- **Protocollo TCP/IP**: Gestione connessioni affidabili
- **Gestione Errori**: Robustezza in ambienti distribuiti

---

## 📁 Struttura File

```
algoritmi_distribuiti_esercitazioni/
├── README.md                    # Questo file
├── .gitignore                   # Configurazione Git
└── Es02-Socket/                 # Esercitazioni Socket
    ├── 1_exe.py                 # Esercizio 1: String Reversal
    ├── 1_ese.md                 # Documentazione Esercizio 1
    ├── 2_exe.py                 # Esercizio 2: File Transfer
    ├── 2_ese.md                 # Documentazione Esercizio 2
    ├── Es02-Socket.pdf          # Tracce originali esercizi
    ├── prova                    # File di test
    ├── received_*               # File ricevuti (generati)
    └── ...
```
---
## 📖 Documentazione

Ogni esercizio include:
- **Codice commentato** con spiegazioni dettagliate
- **Documentazione tecnica** completa (`.md`)
- **Diagrammi architetturali** e flussi di comunicazione
- **Esempi pratici** e casi d'uso
---

*Materiale didattico per il corso di **Algoritmi Distribuiti***  
*Aggiornato: Ottobre 2025*
