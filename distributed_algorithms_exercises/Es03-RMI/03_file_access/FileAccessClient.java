import java.io.FileOutputStream;
import java.io.IOException;
import java.rmi.ConnectException;
import java.rmi.NotBoundException;
import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;
import java.util.Scanner;

/**
 * FileAccessClient - Client RMI per l'accesso ai file
 * ===================================================
 * 
 * Questo client dimostra come:
 * 1. Connettersi a un servizio RMI remoto
 * 2. Invocare metodi remoti passando parametri
 * 3. Ricevere dati e scriverli su file locale
 * 
 * FLUSSO OPERATIVO:
 * - Si connette al Registry RMI del server
 * - Cerca il servizio "FileAccessService" nel Registry
 * 
 * - Per ogni posizione (0, 1, 2, ...):
 *   1. Invoca remotamente readByteFromFile(fileName, position)
 *   2. Riceve il byte dal server
 *   3. Scrive il byte in un file locale
 * 
 * - Termina quando:
 *   a) Ha letto tutti i byte richiesti, oppure
 *   b) Ha raggiunto la fine del file (riceve -1)
 * 
 * Data: Dicembre 2025
 */
public class FileAccessClient {
    
    public static void main(String[] args) {
        // ========== INTESTAZIONE ==========
        System.out.println("=".repeat(50));
        System.out.println("CLIENT RMI - File Access");
        System.out.println("=".repeat(50));

        // ========== INPUT DELL'UTENTE ==========
        // Leggi i parametri da input invece di usarli hardcodati
        Scanner scanner = new Scanner(System.in);
        
        System.out.println("\n📝 Configurazione del client RMI\n");
        
        System.out.print("Inserisci il nome del file remoto (sul server): ");
        String remoteFileName = scanner.nextLine().trim();
        if (remoteFileName.isEmpty()) {
            remoteFileName = "input.txt";
            System.out.println("   (usando default: input.txt)");
        }
        
        System.out.print("Inserisci il nome del file di output (locale): ");
        String localFileName = scanner.nextLine().trim();
        if (localFileName.isEmpty()) {
            localFileName = "output.txt";
            System.out.println("   (usando default: output.txt)");
        }
        
        System.out.print("Quanti byte desideri leggere: ");
        long positionsToRead;
        try {
            positionsToRead = Long.parseLong(scanner.nextLine().trim());
            if (positionsToRead <= 0) {
                System.out.println("❌ Numero di byte deve essere positivo!");
                System.out.println("   (usando default: 10)");
                positionsToRead = 10;
            }
        } catch (NumberFormatException e) {
            System.out.println("❌ Input non valido!");
            System.out.println("   (usando default: 10)");
            positionsToRead = 10;
        }
        
        System.out.println("\n" + "─".repeat(50));
        System.out.println("Parametri configurati:");
        System.out.println("  • File remoto: " + remoteFileName);
        System.out.println("  • File locale: " + localFileName);
        System.out.println("  • Byte da leggere: " + positionsToRead);
        System.out.println("─".repeat(50) + "\n");        try {
            // ========== STEP 1: CONNESSIONE AL REGISTRY RMI ==========
            // LocateRegistry.getRegistry(1099) si connette al Registry RMI
            // Il Registry è come un "telefono" che sa dove trovare i servizi
            // Porta 1099 è il default per RMI
            Registry registry = LocateRegistry.getRegistry(1099);
            System.out.println("✓ Connesso al Registry RMI sulla porta 1099");
            
            // ========== STEP 2: LOOKUP DEL SERVIZIO REMOTO ==========
            // registry.lookup("FileAccessService") cerca il servizio nel Registry
            // Se il servizio viene trovato, otteniamo uno STUB (proxy remoto)
            // Lo stub è come un "rappresentante locale" del server remoto
            // Quando chiamiamo metodi sullo stub, vengono invocati sul server
            FileAccessInterface stub = (FileAccessInterface) registry.lookup("FileAccessService");
            System.out.println("✓ Riferimento a 'FileAccessService' ottenuto");
            System.out.println("─".repeat(50));

            // ========== STEP 3: APERTURA FILE LOCALE ==========
            // Crea un FileOutputStream per scrivere i byte ricevuti dal server
            // Questo file conterrà i dati letti dal file remoto
            FileOutputStream fos = new FileOutputStream(localFileName);
            System.out.println("📝 File di output aperto: " + localFileName);

            // ========== STEP 4: CICLO DI LETTURA E SCRITTURA ==========
            // Per ogni posizione da 0 a (positionsToRead - 1):
            // 1. Chiama il metodo remoto readByteFromFile()
            // 2. Se il byte è valido, scrivilo nel file locale
            // 3. Se arriva a fine file (-1), interrompi il ciclo
            for (long i = 0; i < positionsToRead; i++) {
                try {
                    // ========== INVOCAZIONE METODO REMOTO ==========
                    // Questa è una CHIAMATA REMOTA:
                    // - Il client invia i parametri al server tramite rete
                    // - Il server esegue il metodo sul file remoto
                    // - Il server restituisce il byte al client
                    // - Tutto questo avviene trasparentemente (come una chiamata locale!)
                    byte receivedByte = stub.readByteFromFile(remoteFileName, i);
                    
                    // ========== CONTROLLO FINE FILE ==========
                    // Se ricevi -1, significa che hai raggiunto la fine del file
                    if (receivedByte == -1) {
                        System.out.println("⚠️  Fine del file raggiunta alla posizione " + i);
                        break;  // Esci dal ciclo
                    }
                    
                    // ========== SCRITTURA NEL FILE LOCALE ==========
                    // Scrivi il byte ricevuto nel file locale
                    // fos.write(byte) aggiunge un byte al file
                    fos.write(receivedByte);
                    System.out.println("📝 Byte " + i + " scritto: " + receivedByte + 
                                     " (char: '" + (char)receivedByte + "')");
                    
                } catch (Exception e) {
                    // Se si verifica un errore per una posizione specifica,
                    // stampa l'errore ma continua con le altre posizioni
                    System.err.println("❌ Errore durante la lettura del byte alla posizione " + i);
                    System.err.println("   Messaggio: " + e.getMessage());
                }
            }

            // ========== STEP 5: CHIUSURA DEL FILE ==========
            // Importante: chiudi il file per salvare i dati e liberare risorse
            fos.close();
            System.out.println("─".repeat(50));
            System.out.println("✓ Operazione completata!");
            System.out.println("✓ Dati scritti in: " + localFileName);

        } catch (NotBoundException e) {
            // ========== ERRORE: SERVIZIO NON TROVATO ==========
            // Questo errore si verifica quando il Registry non trova il servizio
            // Cause possibili:
            // - Il server non è in esecuzione
            // - Il nome del servizio nel lookup() non corrisponde al nome nel server
            // - Il Registry si è fermato
            System.err.println("❌ Servizio 'FileAccessService' non trovato nel Registry");
            System.err.println("   Assicurati che il server RMI sia in esecuzione");
        } catch (ConnectException e) {
            // ========== ERRORE: IMPOSSIBILE CONNETTERSI ==========
            // Questo errore si verifica quando non riesci a connetterti al Registry
            // Cause possibili:
            // - Il Registry RMI non è in esecuzione (server non avviato)
            // - Firewall bloccato
            // - Port 1099 già in uso
            System.err.println("❌ Impossibile connettersi al Registry RMI");
            System.err.println("   Assicurati che il server RMI sia in esecuzione su localhost:1099");
        } catch (IOException e) {
            // ========== ERRORE: PROBLEMA CON I FILE ==========
            // Questo errore si verifica quando:
            // - Il file locale non può essere creato/scritto
            // - Problemi di permessi
            // - Spazio disco insufficiente
            System.err.println("❌ Errore durante la gestione dei file: " + e.getMessage());
            e.printStackTrace();
        } catch (Exception e) {
            // ========== ERRORE GENERICO ==========
            // Catch-all per eventuali altre eccezioni non previste
            System.err.println("❌ Errore nel client RMI: " + e.getMessage());
            e.printStackTrace();
        } finally {
            // ========== CHIUSURA DELLO SCANNER ==========
            // Importante: chiudi lo scanner per liberare risorse (stdin)
            scanner.close();
        }
    }
}
