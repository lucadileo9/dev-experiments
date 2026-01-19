"""
Esercizio 1 - Socket Programming: Client-Server String Reversal
==============================================================

Questo programma implementa un sistema client-server che:
- Server: riceve una stringa di lunghezza variabile e restituisce la stringa invertita
- Client: invia una stringa, riceve quella elaborata e la stampa

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
                    
                    # ELABORAZIONE: inversione della stringa
                    # Utilizziamo lo slicing con step negativo [::-1]
                    reversed_string = data[::-1]
                    print(f"🔄 Stringa invertita: '{reversed_string}'")
                    
                    # Invio della risposta al client
                    client_socket.send(reversed_string.encode('utf-8'))
                    print(f"📤 Risposta inviata al client")
                    
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
            message = input("\n📝 Inserisci una stringa da invertire (o 'quit' per uscire): ")
            
            if message.lower() == 'quit':
                print("👋 Disconnessione...")
                break
                
            if message.strip() == "":
                print("⚠️  Stringa vuota, riprova!")
                continue
                
            print(f"📤 Invio al server: '{message}'")
            
            # Invio della stringa al server
            client_socket.send(message.encode('utf-8'))
            
            # Ricezione della risposta dal server
            response = client_socket.recv(1024).decode('utf-8')
            
            # Stampa del risultato
            print(f"📥 Stringa invertita ricevuta: '{response}'")
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
    print("  ESERCIZIO 1 - CLIENT-SERVER STRING REVERSAL")
    print("=" * 60)
    print("📋 Scegli una modalità:")
    print("   [s] Server  - Avvia il server (riceve e inverte stringhe)")
    print("   [c] Client  - Avvia il client (invia stringhe al server)")
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
   Implementare un sistema client-server per l'inversione di stringhe

🖥️  SERVER:
   • Riceve stringhe di lunghezza variabile dai client
   • Inverte ogni stringa usando l'algoritmo di slicing Python [::-1]
   • Restituisce la stringa invertita al client mittente
   • Gestisce connessioni multiple in modo sequenziale

💻 CLIENT:
   • Si connette al server
   • Chiede all'utente di inserire una stringa
   • Invia la stringa al server
   • Riceve e stampa la stringa invertita

🔧 TECNOLOGIE:
   • Socket TCP (SOCK_STREAM)
   • Protocollo IPv4 (AF_INET)
   • Encoding UTF-8 per i messaggi
   • Gestione errori e chiusura sicura delle connessioni

📖 ISTRUZIONI D'USO:
   1. Avvia prima il server (opzione 's')
   2. In un altro terminale/istanza, avvia il client (opzione 'c')
   3. Inserisci una stringa nel client
   4. Osserva il risultato!

💡 CONCETTI DIDATTICI:
   • Socket programming
   • Architettura client-server
   • Comunicazione TCP/IP
   • Gestione errori di rete
   • Encoding/Decoding dei dati
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