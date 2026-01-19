/**
 * GreetLocalTimeClient.java
 * ====================================
 * 
 * Client RMI che:
 * 1. Si connette al Registry RMI   
 * 2. Ottiene il riferimento all'oggetto remoto
 * 3. Invoca i metodi remoti greetUser() e getLocalTime() sull'oggetto remoto
 * 4. Stampa i risultati ricevuti
 * 
 * Data: Dicembre 2025
 */
import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;
import java.util.Scanner;

public class GreetLocalTimeClient {
    
    public static final int PORT = 1099;
    public static final String HOST = "localhost";
    public static final String SERVICE_NAME = "GreetLocalTimeService";

    public static void main(String[] args) {
        // Intestazione
        System.out.println("=".repeat(50));
        System.out.println("CLIENT RMI - Greet and Local Time");
        System.out.println("=".repeat(50));

        Scanner scanner = new Scanner(System.in); // Scanner per l'input utente


        try {
            // 1. Si connette al Registry RMI sulla porta 1099 (default)
            Registry registry = LocateRegistry.getRegistry(HOST, PORT);
            System.out.println("✓ Connesso al Registry RMI sulla porta " + PORT);
            // 2. Ottiene il riferimento all'oggetto remoto
            GreetLocalTimeInterface stub = (GreetLocalTimeInterface) registry.lookup(SERVICE_NAME);
            System.out.println("✓ Riferimento a '" + SERVICE_NAME + "' ottenuto");
            System.out.println("─".repeat(50));

            // 3. Devo permettere all'utente di scegliere se inviare un saluto o ottenere l'ora locale
            outer:
            while (true) {
                System.out.println("\nScegli: 1) Saluto  2) Ora locale  q) Esci");
                String scelta = scanner.nextLine().trim();

                switch (scelta.toLowerCase()) {
                    case "q":
                        break outer;
                    case "1": {
                        // Chiedo il nome all'utente
                        System.out.print("Nome: ");
                        String nome = scanner.nextLine().trim();
                        if (!nome.isEmpty()) System.out.println("Greeting: " + stub.greetUser(nome));
                        break;
                    }
                    case "2":
                        System.out.println("Local Time: " + stub.getLocalTime());
                        break;
                    default:
                        System.out.println("Scelta non valida.");
                }
            }
           
            // 4. Stampa i risultati ricevuti
            System.out.println("=".repeat(50));
            System.out.println("✓ Client RMI terminato");
            System.out.println("=".repeat(50));

        } catch (java.rmi.NotBoundException e) {
            System.err.println("❌ Servizio 'GreetLocalTimeService' non trovato nel Registry");
            System.err.println("   Assicurati che il server RMI sia in esecuzione");
        } catch (java.rmi.ConnectException e) {
            System.err.println("❌ Impossibile connettersi al Registry RMI");
            System.err.println("   Assicurati che il server RMI sia in esecuzione su localhost:1099");
        } catch (Exception e) {
            System.err.println("❌ Errore nel client RMI: " + e.getMessage());
            e.printStackTrace();
        } finally {
            System.out.println("✓ Client RMI terminato");
            scanner.close(); // Chiudo lo scanner per evitare perdite di risorse
        }
    }
}