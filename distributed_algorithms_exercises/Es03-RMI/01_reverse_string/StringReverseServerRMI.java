/**
 * String Reverse Server (RMI)
 * ============================
 * 
 * Server RMI che:
 * 1. Importa l'interfaccia remota
 * 2. Estende UnicastRemoteObject 
 * 3. Implementa l'interfaccia remota
 * 
 * Data: Dicembre 2025
 */

import java.rmi.RemoteException;
import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;
import java.rmi.server.UnicastRemoteObject;

public class StringReverseServerRMI extends UnicastRemoteObject implements StringReverseInterface {
    
    // Costruttore
    public StringReverseServerRMI() throws RemoteException {
        super();
    }
    // Siccome estendiamo UnicastRemoteObject, il costruttore deve dichiarare
    // RemoteException.
    

    /**
     * Implementazione del metodo remoto per invertire stringhe
     */
    @Override
    public String reverseString(String input) throws RemoteException {
        System.out.println("📥 Ricevuta richiesta: \"" + input + "\"");
        
        // Inversione della stringa
        String reversed = new StringBuilder(input).reverse().toString();
        
        System.out.println("🔄 Stringa invertita: \"" + reversed + "\"");
        System.out.println("📤 Risposta inviata al client\n");
        
        return reversed;
    }
    
    /**
     * Main del server: crea e registra l'oggetto remoto
     */
    public static void main(String[] args) {
        // Intestazione
        System.out.println("=".repeat(50));
        System.out.println("SERVER RMI - String Reverse");
        System.out.println("=".repeat(50));
        

        // if (System.getSecurityManager() == null) {
        //     System.setSecurityManager(new SecurityManager());
        // }  Tutto ciò non è più necessario dalle versioni recenti di Java, perché le policy di sicurezza sono state semplificate.
        // aka.: tutto questo è stato deprecato.
 
        try {
            // 1. Crea l'istanza dell'oggetto remoto
            // (Automaticamente esportato perché estende UnicastRemoteObject)
            StringReverseServerRMI server = new StringReverseServerRMI();

            // Questa riga prima mi dava errore, perché estendendo UnicastRemoteObject non serve esportare manualmente l'oggetto
            // quindi risultava già esportato.
            // StringReverseInterface stub = (StringReverseInterface) UnicastRemoteObject.exportObject(server, 0);

            
            // 2. Crea o ottiene il Registry RMI sulla porta 1099 (default)
            Registry registry;
            try {
                registry = LocateRegistry.createRegistry(1099);
                System.out.println("✓ Registry RMI creato sulla porta 1099");
            } catch (RemoteException e) {
                // Registry già esistente
                registry = LocateRegistry.getRegistry("localhost", 1099);
                System.out.println("✓ Connesso al Registry RMI esistente sulla porta 1099");
            }
            
            // 3. Registra l'oggetto remoto nel Registry con un nome
            // Usa rebind per sovrascrivere eventuali registrazioni precedenti
            registry.rebind("StringReverseService", server);
            
            System.out.println("✓ Servizio 'StringReverseService' registrato nel Registry");
            System.out.println("✓ Server RMI pronto per ricevere chiamate remote");
            System.out.println("─".repeat(50));
            System.out.println("In attesa di richieste...\n");
            
            // Mantiene il server attivo
            Thread.currentThread().join();
            
        } catch (Exception e) {
            System.err.println("❌ Errore nel server RMI: " + e.getMessage());
            e.printStackTrace();
        }
    }
}
