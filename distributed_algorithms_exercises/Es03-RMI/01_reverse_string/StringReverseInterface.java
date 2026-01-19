/**
 * String Reverse Interface (RMI)
 * ===============================
 * 
 * Interfaccia remota che definisce i metodi disponibili
 * per l'inversione di stringhe tramite RMI.
 * L'obiettivo di questa classe è solo quella di definire
 * il contratto per l'inversione di stringhe.
 * Deve solo estendere java.rmi.Remote e dichiarare
 * i metodi remoti.
 * 
 * Data: Dicembre 2025
 */

import java.rmi.Remote;
import java.rmi.RemoteException;

public interface StringReverseInterface extends Remote {
    
    /**
     * Inverte una stringa
     * 
     * @param input La stringa da invertire
     * @return La stringa invertita
     * @throws RemoteException In caso di errori nella chiamata remota
     */
    String reverseString(String input) throws RemoteException;
}

