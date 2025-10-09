"""
Esercizio 2 - Socket Programming: Client-Server File Transfer
============================================================

Questo programma implementa un sistema client-server che:
- Server: riceve il nome di un file, lo apre e invia il contenuto al client
- Client: richiede un file, riceve il contenuto e lo salva localmente

Data: 9 Ottobre 2025
"""

import socket
import threading
import sys

def server():
    """
    FUNZIONE SERVER
    ===============
    
    Implementa il lato server dell'applicazione:
    1. Crea un socket TCP
    2. Si mette in ascolto su localhost:12345
    3. Per ogni connessione client:
       - Riceve una stringa di lunghezza variabile
       - Inverte la stringa (usando slicing [::-1])
       - Restituisce la stringa invertita al client
    4. Gestisce multiple connessioni sequenzialmente
    """
    print("=" * 50)
    print("AVVIO SERVER")
    print("=" * 50)
    
    # Creazione socket del server
    # AF_INET = IPv4, SOCK_STREAM = TCP
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    
    # Permette di riutilizzare l'indirizzo (evita "Address already in use")
    server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
    
    # Configurazione indirizzo server
    host = 'localhost'  # 127.0.0.1
    port = 12345       # Porta personalizzata (>1024 per evitare privilegi admin)
    
    try:
        # Bind: associa il socket all'indirizzo
        server_socket.bind((host, port))
        print(f"✓ Socket associato a {host}:{port}")
        
        # Listen: mette il socket in modalità ascolto
        # Parametro: numero massimo di connessioni in coda
        server_socket.listen(5)
        print(f"✓ Server in ascolto (max 5 connessioni in coda)")
        print(f"✓ In attesa di connessioni client...")
        print("-" * 50)
        
        # Loop principale del server
        connection_count = 0
        while True:
            # Accept: blocca fino a quando un client si connette
            # Restituisce un nuovo socket per la comunicazione e l'indirizzo del client
            client_socket, client_address = server_socket.accept()
            connection_count += 1
            
            print(f"\n[Connessione #{connection_count}]")
            print(f"✓ Nuovo client connesso da {client_address}")
            
            try:
                # Ricezione dati dal client
                # recv(buffer_size): riceve fino a 1024 bytes
                data = client_socket.recv(1024).decode('utf-8')
                
                if data:  # Se ci sono dati ricevuti
                    print(f"📥 Ricevuto: '{data}' (lunghezza: {len(data)} caratteri)")
                    
                    # ELABORAZIONE: apertura del file con quel nome,
                    # in seguito invio il contenuto al client
                    try:
                        # Apriamo il file specificando encoding UTF-8 per evitare problemi di codec
                        with open(data, 'r', encoding='utf-8') as file:
                            file_content = file.read()
                            client_socket.send(file_content.encode('utf-8'))
                            # Chiudiamo la connessione di scrittura per segnalare fine trasmissione
                            client_socket.shutdown(socket.SHUT_WR)
                            print(f"📤 Contenuto del file '{data}' inviato al client")
                    
                    except FileNotFoundError:
                        # Gestione file non trovato
                        error_message = f"ERRORE: File '{data}' non trovato sul server"
                        client_socket.send(error_message.encode('utf-8'))
                        client_socket.shutdown(socket.SHUT_WR)
                        print(f"⚠️  File '{data}' non trovato - messaggio di errore inviato al client")
                    
                    except UnicodeDecodeError as e:
                        # Gestione errori di encoding
                        error_message = f"ERRORE: Impossibile leggere il file '{data}' - problemi di encoding"
                        client_socket.send(error_message.encode('utf-8'))
                        client_socket.shutdown(socket.SHUT_WR)
                        print(f"⚠️  Errore di encoding nel file '{data}': {e}")
                    
                    except PermissionError:
                        # Gestione errori di permessi
                        error_message = f"ERRORE: Permessi insufficienti per leggere il file '{data}'"
                        client_socket.send(error_message.encode('utf-8'))
                        client_socket.shutdown(socket.SHUT_WR)
                        print(f"⚠️  Permessi insufficienti per il file '{data}'")
                    
                else:
                    print("⚠️  Nessun dato ricevuto dal client")
                    
            except Exception as e:
                print(f"❌ Errore durante la comunicazione con il client: {e}")
                
            finally:
                # Chiusura della connessione con il client specifico
                client_socket.close()
                print(f"🔒 Connessione con {client_address} chiusa")
                print("-" * 30)
                
    except KeyboardInterrupt:
        print(f"\n\n🛑 Server arrestato dall'utente (Ctrl+C)")
        
    except Exception as e:
        print(f"❌ Errore del server: {e}")
        
    finally:
        # Chiusura socket del server
        server_socket.close()
        print("🔒 Socket server chiuso")
        print("👋 Arrivederci!")


def client():
    """
    FUNZIONE CLIENT
    ===============
    
    Implementa il lato client dell'applicazione:
    1. Crea un socket TCP
    2. Si connette al server su localhost:12345
    3. Chiede all'utente di inserire una stringa
    4. Invia la stringa al server
    5. Riceve la stringa elaborata (invertita)
    6. Stampa la stringa ricevuta
    """
    print("=" * 50)
    print("AVVIO CLIENT")
    print("=" * 50)
    
    # Creazione socket del client
    client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    
    # Impostiamo un timeout per evitare blocchi infiniti
    client_socket.settimeout(10.0)  # 10 secondi timeout
    
    # Configurazione indirizzo server (deve corrispondere al server)
    host = 'localhost'
    port = 12345
    
    try:
        # Connessione al server
        print(f"🔗 Tentativo di connessione a {host}:{port}...")
        client_socket.connect((host, port))
        print(f"✓ Connessione stabilita con successo!")
        print("-" * 50)
        
        # Input dall'utente
        while True:
            message = input("\n📝 Inserisci il nome di un file da aprire (o 'quit' per uscire): ")
            
            if message.lower() == 'quit':
                print("👋 Disconnessione...")
                break
                
            if message.strip() == "":
                print("⚠️  Nome vuoto, riprova!")
                continue
                
            print(f"📤 Invio al server: '{message}'")
            
            # Invio della stringa al server
            client_socket.send(message.encode('utf-8'))
            
            # Ricezione della risposta dal server
            # Usiamo un buffer più grande e loop per ricevere tutto il contenuto
            response_parts = []
            while True:
                try:
                    # Ricevi dati in chunks
                    chunk = client_socket.recv(4096).decode('utf-8')
                    if not chunk:  # Connessione chiusa dal server
                        break
                    response_parts.append(chunk)
                    
                except socket.timeout:
                    break
            
            response = ''.join(response_parts)
            
            # Verifica se è un messaggio di errore
            if response.startswith("ERRORE:"):
                print(f"❌ {response}")
            else:
                # Scrittura del contenuto ricevuto su un file locale, con nome "received_<original_filename>"
                try:
                    with open(f"received_{message}", 'w', encoding='utf-8') as file:
                        file.write(response)
                    print(f"📥 Contenuto del file '{message}' ricevuto e salvato come 'received_{message}'")
                    print(f"📊 Dimensione file ricevuto: {len(response)} caratteri")
                except Exception as e:
                    print(f"❌ Errore nel salvare il file: {e}")
            print(f"✓ Operazione completata con successo!")
            
            # Per questo esercizio, facciamo una sola operazione e chiudiamo
            break
            
    except ConnectionRefusedError:
        print("❌ Errore: Impossibile connettersi al server")
        print("💡 Suggerimento: Assicurati che il server sia in esecuzione")
        
    except Exception as e:
        print(f"❌ Errore del client: {e}")
        
    finally:
        # Chiusura socket del client
        client_socket.close()
        print("🔒 Connessione client chiusa")


def print_menu():
    """
    Stampa il menu principale dell'applicazione
    """
    print("\n" + "=" * 60)
    print("  ESERCIZIO 2 - CLIENT-SERVER FILE TRANSFER")
    print("=" * 60)
    print("📋 Scegli una modalità:")
    print("   [s] Server  - Avvia il server (invia contenuto file)")
    print("   [c] Client  - Avvia il client (richiede file al server)")
    print("   [h] Help    - Mostra informazioni sull'esercizio")
    print("   [q] Quit    - Esci dal programma")
    print("-" * 60)


def print_help():
    """
    Stampa informazioni dettagliate sull'esercizio
    """
    print("\n" + "=" * 60)
    print("  INFORMAZIONI SULL'ESERCIZIO")
    print("=" * 60)
    print("""
📚 OBIETTIVO:
   Implementare un sistema client-server per il trasferimento di file

🖥️  SERVER:
   • Riceve nome di un file da aprire
   • Apre il file e legge il contenuto (con encoding UTF-8)
   • Invia il contenuto al client
   • Gestisce errori (file non trovato, encoding, permessi)
   • Gestisce connessioni multiple in modo sequenziale

💻 CLIENT:
   • Si connette al server
   • Chiede all'utente di inserire il nome di un file
   • Invia il nome del file al server
   • Riceve il contenuto del file (gestendo file di grandi dimensioni)
   • Scrive il contenuto in un nuovo file locale "received_<nome_originale>"

🔧 TECNOLOGIE:
   • Socket TCP (SOCK_STREAM)
   • Protocollo IPv4 (AF_INET)
   • Encoding UTF-8 per i messaggi e file
   • Gestione robusta degli errori
   • Buffer dinamico per file di grandi dimensioni
   • Timeout per evitare blocchi

📖 ISTRUZIONI D'USO:
   1. Avvia prima il server (opzione 's')
   2. In un altro terminale/istanza, avvia il client (opzione 'c')
   3. Inserisci il nome di un file esistente nel client
   4. Osserva il file "received_<nome>" creato localmente!

💡 CONCETTI DIDATTICI:
   • Socket programming
   • Trasferimento file via rete
   • Gestione encoding UTF-8
   • Gestione errori di I/O
   • Buffer dinamici per grandi quantità di dati
   • Timeout di rete
""")


def main():
    """
    FUNZIONE PRINCIPALE
    ===================
    
    Gestisce il menu principale e coordina l'esecuzione del programma.
    Permette all'utente di scegliere se avviare il server o il client.
    """
    print("🚀 Avvio applicazione Client-Server...")
    
    while True:
        print_menu()
        
        try:
            choice = input("👉 La tua scelta: ").lower().strip()
            
            if choice == 's' or choice == 'server':
                server()
                
            elif choice == 'c' or choice == 'client':
                client()
                
            elif choice == 'h' or choice == 'help':
                print_help()
                
            elif choice == 'q' or choice == 'quit':
                print("\n👋 Grazie per aver utilizzato l'applicazione!")
                print("🎓 Esercizio completato - Algoritmi Distribuiti")
                break
                
            else:
                print(f"❌ Scelta non valida: '{choice}'")
                print("💡 Usa 's' per server, 'c' per client, 'h' per help, 'q' per quit")
                
        except KeyboardInterrupt:
            print(f"\n\n🛑 Programma interrotto dall'utente")
            break
            
        except Exception as e:
            print(f"❌ Errore inaspettato: {e}")


# Entry point del programma
if __name__ == "__main__":
    """
    Punto di ingresso del programma.
    Viene eseguito solo quando il file è lanciato direttamente,
    non quando è importato come modulo.
    """
    main()