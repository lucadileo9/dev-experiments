import java.rmi.Remote;
import java.rmi.RemoteException;
/**
 * Greet and Local Time Interface (RMI)
 * =====================================
 * 
 * Interfaccia remota che definisce i metodi disponibili
 * per salutare un utente e ottenere l'ora locale tramite RMI.
 * L'obiettivo di questa classe è solo quella di definire
 * il contratto per i metodi di saluto e ora locale.
 * Deve solo estendere java.rmi.Remote e dichiarare
 * i metodi remoti.
 * 
 * Data: Dicembre 2025
 */
public interface GreetLocalTimeInterface extends Remote {

    /**
     * Saluta un utente con il suo nome
     * 
     * @param name Il nome dell'utente da salutare
     * @return Un messaggio di saluto personalizzato
     * @throws RemoteException In caso di errori nella chiamata remota
     */
    String greetUser(String name) throws RemoteException;

    /**
     * Ottiene l'ora locale del server
     * 
     * @return L'ora locale del server come stringa
     * @throws RemoteException In caso di errori nella chiamata remota
     */
    String getLocalTime() throws RemoteException;
    
}
