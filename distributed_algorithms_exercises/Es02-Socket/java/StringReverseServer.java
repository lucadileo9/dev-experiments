/**
 * String Reverse Server
 * =====================
 * 
 * Server che:
 * 1. Accetta connessioni su porta 12345
 * 2. Riceve una stringa dal client
 * 3. Inverte la stringa (reverse)
 * 4. Restituisce la stringa invertita al client
 * 
 * Data: Dicembre 2025
 */

import java.io.*;
import java.net.*;

public class StringReverseServer {
    
    private static final int PORT = 12345;
    
    public static void main(String[] args) {
        // Stampa intestazione
        System.out.println("=".repeat(50));
        System.out.println("SERVER - String Reverse");
        System.out.println("=".repeat(50));
        
        try (ServerSocket serverSocket = new ServerSocket(PORT)) {
            System.out.println("✓ Server avviato sulla porta " + PORT);
            System.out.println("✓ In attesa di connessioni...\n");
            
            // Loop infinito per gestire multiple connessioni
            while (true) {
                try {
                    // Accetta connessione client
                    Socket clientSocket = serverSocket.accept();
                    System.out.println("─".repeat(50));
                    System.out.println("📡 Nuova connessione da: " + 
                                     clientSocket.getInetAddress().getHostAddress() + 
                                     ":" + clientSocket.getPort());
                    
                    // Gestione della comunicazione
                    handleClient(clientSocket);
                    
                } catch (IOException e) {
                    System.err.println("❌ Errore nella gestione del client: " + e.getMessage());
                }
            }
            
        } catch (IOException e) {
            System.err.println("❌ Errore nell'avvio del server: " + e.getMessage());
            e.printStackTrace();
        }
    }
    
    /**
     * Gestisce la comunicazione con un singolo client
     */
    private static void handleClient(Socket clientSocket) {
        try (
            // Stream di input per ricevere dati dal client
            BufferedReader in = new BufferedReader(
                new InputStreamReader(clientSocket.getInputStream())
            );
            
            // Stream di output per inviare dati al client
            PrintWriter out = new PrintWriter(
                clientSocket.getOutputStream(), 
                true  // autoflush attivo
            );
        ) {
            // Ricezione stringa dal client
            String receivedString = in.readLine();
            
            if (receivedString != null && !receivedString.isEmpty()) {
                System.out.println("📥 Ricevuto: \"" + receivedString + "\"");
                
                // ELABORAZIONE: inversione della stringa
                String reversedString = new StringBuilder(receivedString).reverse().toString();
                
                System.out.println("🔄 Invertito: \"" + reversedString + "\"");
                
                // Invio della stringa invertita al client
                out.println(reversedString);
                System.out.println("📤 Risposta inviata al client");
                
            } else {
                System.out.println("⚠️  Stringa vuota ricevuta");
            }
            
            System.out.println("✓ Connessione chiusa\n");
            
        } catch (IOException e) {
            System.err.println("❌ Errore I/O: " + e.getMessage());
        } finally {
            try {
                clientSocket.close();
            } catch (IOException e) {
                System.err.println("❌ Errore nella chiusura del socket: " + e.getMessage());
            }
        }
    }
}
