/**
 * String Reverse Client (RMI)
 * ============================
 * 
 * Client RMI che:
 * 1. Si connette al Registry RMI
 * 2. Ottiene il riferimento all'oggetto remoto
 * 3. Invoca il metodo reverseString() sull'oggetto remoto
 * 4. Stampa la stringa ricevuta
 * 
 * Data: Dicembre 2025
 */

import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;
import java.util.Scanner;

public class StringReverseClientRMI {

    public static final int PORT = 1099;
    public static final String HOST = "localhost";
    
    public static void main(String[] args) {
        // Intestazione
        System.out.println("=".repeat(50));
        System.out.println("CLIENT RMI - String Reverse");
        System.out.println("=".repeat(50));
        
        Scanner scanner = new Scanner(System.in); // Scanner per l'input utente
        
        try {
            // 1. Ottiene il riferimento al Registry RMI
            Registry registry = LocateRegistry.getRegistry(HOST, PORT); // --------- Codice importante ---------
            System.out.println("✓ Connesso al Registry RMI su " + HOST + ":" + PORT);
            
            // 2. Cerca l'oggetto remoto nel Registry
            StringReverseInterface stub = (StringReverseInterface) registry.lookup("StringReverseService");// --------- Codice importante ---------
            System.out.println("✓ Riferimento a 'StringReverseService' ottenuto");
            System.out.println("─".repeat(50));
            
            // 3. Input dall'utente
            System.out.print("\n📝 Inserisci una stringa da invertire: ");
            String inputString = scanner.nextLine();
            
            if (inputString.isEmpty()) {
                System.out.println("⚠️  Stringa vuota, uscita...");
                return;
            }
            
            // 4. Invoca il metodo remoto
            System.out.println("📤 Invio richiesta al server RMI...");
            String reversedString = stub.reverseString(inputString);// --------- Codice importante ---------
            
            // 5. Stampa il risultato
            System.out.println("📥 Risposta ricevuta dal server!");
            System.out.println("\n" + "=".repeat(50));
            System.out.println("✅ RISULTATO FINALE");
            System.out.println("=".repeat(50));
            System.out.println("Originale: " + inputString);
            System.out.println("Invertita: " + reversedString);
            System.out.println("=".repeat(50));
            
        } catch (java.rmi.NotBoundException e) {
            System.err.println("❌ Servizio 'StringReverseService' non trovato nel Registry");
            System.err.println("   Assicurati che il server RMI sia in esecuzione");
        } catch (java.rmi.ConnectException e) {
            System.err.println("❌ Impossibile connettersi al Registry RMI");
            System.err.println("   Assicurati che il server RMI sia in esecuzione su localhost:1099");
        } catch (Exception e) {
            System.err.println("❌ Errore nel client RMI: " + e.getMessage());
            e.printStackTrace();
        } finally {
            scanner.close();
        }
    }
}
