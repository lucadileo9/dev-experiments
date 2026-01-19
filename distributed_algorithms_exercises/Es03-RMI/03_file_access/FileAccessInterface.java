import java.rmi.Remote;
import java.rmi.RemoteException;

/**
 * FileAccessInterface - Interfaccia remota per l'accesso ai file
 * 
 * Definisce i metodi remoti disponibili per leggere byte da file
 * presenti nel server.
 * 
 * Data: Dicembre 2025
 */
public interface FileAccessInterface extends Remote {
    
    /**
     * Legge un byte da un file specificato ad una determinata posizione
     * 
     * @param fileName Il nome del file da cui leggere
     * @param position La posizione del byte da leggere (0-based)
     * @return Il byte letto dal file (-1 se EOF o errore)
     * @throws RemoteException In caso di errori nella chiamata remota
     */
    byte readByteFromFile(String fileName, long position) throws RemoteException;
}
