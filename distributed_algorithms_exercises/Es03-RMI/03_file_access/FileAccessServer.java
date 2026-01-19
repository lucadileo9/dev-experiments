import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.rmi.RemoteException;
import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;
import java.rmi.server.UnicastRemoteObject;

/**
 * FileAccessServer - Server RMI per l'accesso ai file
 * =====================================================
 * 
 * Implementa il servizio remoto che permette ai client di leggere byte da file.
 * 
 * Responsabilità principali:
 * 1. Ricevere richieste di lettura da client remoti
 * 2. Accedere al file system locale per aprire i file
 * 3. Leggere il byte alla posizione specificata
 * 4. Restituire il byte al client
 * 5. Gestire errori e eccezioni di rete
 * 
 * Architettura:
 * - Estende UnicastRemoteObject: rende l'oggetto invocabile da remoto via TCP
 * - Implementa FileAccessInterface: fornisce l'implementazione del metodo remoto
 * 
 * Data: Dicembre 2025
 */
public class FileAccessServer extends UnicastRemoteObject implements FileAccessInterface {
    
    // ID di serializzazione per garantire compatibilità tra versioni
    // (obbligatorio quando si estende UnicastRemoteObject)
    private static final long serialVersionUID = 1L;
    
    /**
     * Costruttore del server.
     * 
     * Cosa fa:
     * - Chiama il costruttore della classe padre (UnicastRemoteObject)
     * - Prepara l'oggetto per essere esportato e reso disponibile via RMI
     * 
     * Perché lancia RemoteException:
     * - RemoteException è lanciata perché UnicastRemoteObject.exportObject()
     *   può fallire se non riesce a esportare l'oggetto sulla rete
     */
    public FileAccessServer() throws RemoteException {
        super();
    }

    /**
     * IMPLEMENTAZIONE DEL METODO REMOTO: readByteFromFile()
     * ====================================================
     * 
     * Questo metodo viene invocato dai client remoti per leggere un byte da un file.
     * 
     * FLUSSO LOGICO DETTAGLIATO:
     * 1. Ricevi i parametri: fileName (nome file) e position (posizione byte)
     * 2. Valida i parametri (file esiste? posizione valida?)
     * 3. Apri il file in lettura (FileInputStream)
     * 4. Salta alla posizione richiesta usando skip()
     * 5. Leggi il byte singolo
     * 6. Chiudi il file (nel finally per garantire chiusura anche se errore)
     * 7. Restituisci il byte al client
     * 
     * @param fileName Nome del file da cui leggere
     * @param position Posizione (offset) del byte da leggere (0 = primo byte)
     * @return Il byte letto (0-255), o -1 se errore/EOF
     * @throws RemoteException Se si verifica errore di rete/IO
     */
    @Override
    public byte readByteFromFile(String fileName, long position) throws RemoteException {
        System.out.println("📥 Richiesta ricevuta: file='" + fileName + "', posizione=" + position);
        
        // Dichiara la variabile del file stream FUORI dal try
        // così possiamo chiuderla nel finally anche se si verifica un'eccezione
        FileInputStream fis = null;
        try {
            // ========== STEP 1: CREAZIONE OGGETTO FILE ==========
            // Crea un oggetto File che rappresenta il file sul file system locale
            File file = new File(fileName);
            
            // ========== STEP 2: VALIDAZIONE - FILE ESISTE? ==========
            // Verifica che il file effettivamente esista
            if (!file.exists()) {
                System.err.println("❌ File non trovato: " + fileName);
                return -1;  // Ritorna -1 per indicare errore
            }
            
            // ========== STEP 3: VALIDAZIONE - È UN FILE? ==========
            // Assicurati che il percorso sia un file, non una cartella
            if (!file.isFile()) {
                System.err.println("❌ Il percorso non è un file: " + fileName);
                return -1;
            }
            
            // ========== STEP 4: APERTURA FILE ==========
            // Crea uno stream di input dal file
            // FileInputStream legge dati grezzi (byte per byte)
            fis = new FileInputStream(file);
            
            // ========== STEP 5: VALIDAZIONE - POSIZIONE VALIDA? ==========
            // Controlla che la posizione sia >= 0
            if (position < 0) {
                System.err.println("❌ Posizione negativa non valida: " + position);
                return -1;
            }
            
            // ========== STEP 6: SALTA ALLA POSIZIONE ==========
            // skip(n) salta i primi n byte del file
            // Esempio: skip(5) lascia il file stream posizionato al 6° byte
            long skipped = fis.skip(position);
            
            // Verifica che abbiamo effettivamente saltato n byte
            // Se il file è più corto della posizione richiesta, skip() restituisce < position
            if (skipped < position) {
                System.err.println("❌ Impossibile raggiungere la posizione " + position + 
                                 " (file size: " + file.length() + " bytes)");
                return -1;
            }
            
            // ========== STEP 7: LETTURA DEL BYTE ==========
            // read() legge il byte successivo (dopo aver saltato)
            // Restituisce -1 se siamo al fine del file (EOF)
            // Altrimenti restituisce il byte come intero (0-255)
            int byteRead = fis.read();
            
            // ========== STEP 8: CONTROLLO EOF ==========
            // Se read() restituisce -1, significa che siamo al fine del file
            if (byteRead == -1) {
                System.out.println("⚠️  End of file raggiunto alla posizione " + position);
                return -1;
            }
            
            // ========== STEP 9: CAST E RESTITUZIONE ==========
            // Converti l'int in byte (cast da 32 bit a 8 bit)
            // Stampa il byte per debug (mostra sia il numero che il carattere)
            System.out.println("✓ Byte letto: " + byteRead + " (char: '" + (char)byteRead + "')");
            return (byte) byteRead;
            
        } catch (IOException e) {
            System.err.println("❌ Errore durante la lettura del file: " + e.getMessage());
            // Wrapper dell'eccezione IO in RemoteException per il client
            throw new RemoteException("Errore durante la lettura: " + e.getMessage(), e);
        } finally {
            // È IMPORTANTE chiudere i file per evitare file descriptor leak
            if (fis != null) {
                try {
                    fis.close();
                } catch (IOException e) {
                    System.err.println("❌ Errore durante la chiusura del file: " + e.getMessage());
                }
            }
        }
    }

    /**
     * MAIN DEL SERVER
     */
    public static void main(String[] args) {
        // ========== INTESTAZIONE ==========
        System.out.println("=".repeat(50));
        System.out.println("SERVER RMI - File Access");
        System.out.println("=".repeat(50));

        try {
            // ========== STEP 1: CREAZIONE ISTANZA SERVER ==========
            // Crea un'istanza del server (UnicastRemoteObject)
            // Questo oggetto sarà remoto e invocabile da client
            FileAccessServer server = new FileAccessServer();

            // ========== STEP 2: CONNESSIONE/CREAZIONE REGISTRY ==========
            // Il Registry RMI è un servizio di naming (directory) che associa
            // nomi simbolici (stringhe) a oggetti remoti
            // Porta 1099 è il default per RMI
            Registry registry;
            try {
                // Tenta di CREARE un nuovo Registry sulla porta 1099
                registry = LocateRegistry.createRegistry(1099);
                System.out.println("✓ Registry RMI creato sulla porta 1099");
            } catch (RemoteException e) {
                // Se createRegistry() fallisce (perché già esiste), ottieni il Registry esistente
                registry = LocateRegistry.getRegistry(1099);
                System.out.println("✓ Connesso al Registry RMI esistente sulla porta 1099");
            }

            registry.rebind("FileAccessService", server);

            System.out.println("✓ Servizio 'FileAccessService' registrato nel Registry");
            System.out.println("✓ Server RMI pronto per ricevere richieste di accesso ai file");
            System.out.println("=".repeat(50));
            
            // Il server rimane qui, in ascolto di richieste dai client
            // Per fermare il server, premi Ctrl+C nel terminale

        } catch (Exception e) {
            System.err.println("❌ Errore nel server RMI: " + e.getMessage());
            e.printStackTrace();
        }
    }
}
