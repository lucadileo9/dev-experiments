/**
 * String Reverse Client
 * =====================
 * 
 * Client che:
 * 1. Si connette al server su localhost:12345
 * 2. Invia una stringa al server
 * 3. Riceve la stringa invertita
 * 4. Stampa la stringa ricevuta
 * 
 * Data: Dicembre 2025
 */

import java.io.*;
import java.net.*;
import java.util.Scanner;

public class StringReverseClient {
    
    private static final String HOST = "localhost";
    private static final int PORT = 12345;
    
    public static void main(String[] args) {
        System.out.println("=".repeat(50));
        System.out.println("CLIENT - String Reverse");
        System.out.println("=".repeat(50));
        
        Scanner scanner = new Scanner(System.in);
        
        try (
            // Creazione socket e connessione al server
            Socket socket = new Socket(HOST, PORT);
            
            // Stream di output per inviare dati al server
            PrintWriter out = new PrintWriter(
                socket.getOutputStream(), 
                true  // autoflush attivo
            );
            
            // Stream di input per ricevere dati dal server
            BufferedReader in = new BufferedReader(
                new InputStreamReader(socket.getInputStream())
            );
        ) {
            System.out.println("✓ Connesso al server " + HOST + ":" + PORT);
            System.out.println("─".repeat(50));
            
            // Input dall'utente
            System.out.print("\n📝 Inserisci una stringa da invertire: ");
            String inputString = scanner.nextLine();
            
            if (inputString.isEmpty()) {
                System.out.println("⚠️  Stringa vuota, uscita...");
                return;
            }
            
            // Invio stringa al server
            System.out.println("📤 Invio al server: \"" + inputString + "\"");
            out.println(inputString);
            
            // Ricezione risposta dal server
            String response = in.readLine();
            
            if (response != null) {
                System.out.println("📥 Ricevuto dal server: \"" + response + "\"");
                System.out.println("\n" + "=".repeat(50));
                System.out.println("✅ RISULTATO FINALE");
                System.out.println("=".repeat(50));
                System.out.println("Originale: " + inputString);
                System.out.println("Invertita: " + response);
                System.out.println("=".repeat(50));
            } else {
                System.out.println("⚠️  Nessuna risposta dal server");
            }
            
        } catch (UnknownHostException e) {
            System.err.println("❌ Host sconosciuto: " + HOST);
            e.printStackTrace();
        } catch (ConnectException e) {
            System.err.println("❌ Impossibile connettersi al server.");
            System.err.println("   Assicurati che il server sia in esecuzione su " + HOST + ":" + PORT);
        } catch (IOException e) {
            System.err.println("❌ Errore I/O: " + e.getMessage());
            e.printStackTrace();
        } finally {
            scanner.close();
        }
    }
}
