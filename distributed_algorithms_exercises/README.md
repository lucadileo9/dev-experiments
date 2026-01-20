# Distributed Algorithms Exercises

Repository containing practical exercises for the **Distributed Algorithms** course, focused on network programming, distributed systems, and client-server communication.

## 🎯 Objective

Learn the fundamentals of distributed algorithms and systems through practical implementations:
- Socket programming and TCP communication
- Remote Method Invocation (RMI)
- Client-server architectures
- Data serialization and transmission
- Connection management and network protocols

## 🛠️ Tech Stack

- **Python 3.7+** - Socket programming exercises
- **Java 8+** - RMI exercises
- **TCP Protocol** - Network communication
- **Object Serialization** - Data transmission

## 💡 What I Learned

- TCP socket creation and management
- Client-server communication patterns
- File transfer protocols
- Remote Method Invocation in Java
- Distributed object systems
- Network error handling
- Multi-client server architectures

---

## Exercises Overview

| # | Name | Language | Topic | 
|---|------|----------|-------|
| **Es02** | Socket Programming | Python 3.7+ | TCP, Client-Server | 
| **Es03** | Remote Method Invocation | Java 8+ | RMI, Distributed Objects | 

---

## Es02-Socket - TCP Socket Programming

Fundamental exercises on socket programming and client-server communication in Python.

### Exercise 1: String Reversal

```
Assignment:

Server side
- Receives a string of variable length
- Returns the overturned string

Client side
- Sends a string
- Receives an elaborated string
- Prints the received string

Objective: Client-server system for string reversal
Files: `Es02-Socket/1_exe.py`, `1_ese.md`

Concepts: TCP sockets, UTF-8 encoding, connection management
```

### Exercise 2: File Transfer

```
Assignment:

Server side
- Receives the name of a file
- Opens the file and sends the content to the client

Client side
- Sends a string representing the name of a file
- Receives the content of the requested file
- Writes the content to a new local file

Objective: File transfer over the network with robust error handling  
File: `Es02-Socket/2_exe.py`, `2_ese.md`  

Concepts: Dynamic buffers, file management, encoding, timeout  
```
---

## Es03-RMI - Remote Method Invocation (Java)

Client-server communication system based on RMI for remote method invocation.

### Exercise 1: String Reversal
```
Assignment:
The server accepts a string as argument and returns the overturned string. The client sends a string, receives an elaborated string and prints the received string.

Objective: RMI system for string reversal  
Path: `Es03-RMI/01_reverse_string/`  
Main files:
- `StringReverseInterface.java` - Remote interface
- `StringReverseServerRMI.java` - RMI server
- `StringReverseClientRMI.java` - RMI client
- `README.md` - Complete documentation
Concepts: RMI, Remote Objects, Registry, Stub/Skeleton  
```
### Exercise 2: Greet and Local Time
```
Assignment:
The server provides 2 services:
- Greeting
- Local time

The client receives from command line an argument specifying the service to ask to the server.

Objective: RMI service for personalized greetings and local time  
Path: `Es03-RMI/02_greet_and_local_time/`  
Main files:
- `GreetLocalTimeInterface.java` - Remote interface
- `GreetLocalTimeServer.java` - RMI server
- `GreetLocalTimeClient.java` - RMI client
- `README.md` - Complete documentation

Concepts: Multiple remote methods, java.time API, RMI Registry  
```
### Exercise 3: File Access

```
Assignment:

The server receives:
- The name of a file
- The position of the byte to be read

The server opens the file, reads the byte at the specified position and returns the read byte.

The client:
- Sends a string representing the name of a file and the position of a byte to be read
- Receives the read byte
- Writes the byte to a local file

Objective: Remote file access with selective byte reading  
Path: `Es03-RMI/03_file_access/`  
Main files:
- `FileAccessInterface.java` - Remote interface
- `FileAccessServer.java` - RMI server with file management
- `FileAccessClient.java` - RMI client with interactive input
- `README.md` - Complete documentation

Concepts: Remote file I/O, user input, RMI exception handling, Scanner  
```
---

## Quick Start Guide for Execution

### Python (Es02-Socket)

**Prerequisites**:
- Python 3.7+
- No external libraries required (standard modules only)

**Execution**:
```bash
# Navigate to the folder
cd Es02-Socket

# Run the program
python 1_exe.py  # Exercise 1
python 2_exe.py  # Exercise 2

# Follow the interactive menu:
# [s] Server - Start the server
# [c] Client - Start the client  
# [h] Help   - Detailed guide
```

### Java (Es03-RMI)

**Prerequisites**:
- Java 8+ (JDK)
- `javac` compiler
- No external libraries

**Execution**:
```bash
# Navigate to the exercise folder
cd Es03-RMI/01_reverse_string  # (or 02_greet_and_local_time, or 03_file_access)

# 1. Compilation
javac *Interface.java *Server.java *Client.java

# 2. Start the server (Terminal 1)
java *Server

# 3. Start the client (Terminal 2)
java *Client
```

---

## Educational Objectives

### Fundamental Concepts Covered

#### Socket Programming (Python)
- Creation and management of TCP sockets
- Client-Server Architecture
- TCP/IP Protocol
- Robust error handling
- Data serialization (UTF-8, Binary)

#### Remote Method Invocation (Java)
- Distributed Objects
- Remote Interfaces
- RMI Registry (naming service)
- Stub and Skeleton
- Marshalling/Unmarshalling
- Network exception handling
- Remote File I/O
- Interactive Input/Output
---

## Struttura Directory

```
distributed_algorithms_exercises/
│
├── README.md                                  # This file
├── .gitignore                                 # Git configuration
│
├── Es02-Socket/                               # TCP Socket Exercises (Python)
│   ├── 1_exe.py                               # Exercise 1: String Reversal
│   ├── 1_ese.md                               # Documentation Es02-01
│   ├── 2_exe.py                               # Exercise 2: File Transfer
│   ├── 2_ese.md                               # Documentation Es02-02
│   ├── java/                                  # Optional Java version
│   │   ├── StringReverseClient.java
│   │   └── StringReverseServer.java
│   ├── prova                                  # Test files
│   ├── received_*                             # Received files (generated by client)
│   └── ...
│
└── Es03-RMI/                                  # RMI Exercises (Java)
    │
    ├── 01_reverse_string/                     # Es03-01: String Reversal with RMI
    │   ├── StringReverseInterface.java        # Remote interface
    │   ├── StringReverseServerRMI.java        # RMI server
    │   ├── StringReverseClientRMI.java        # RMI client
    │   ├── README.md                          # etailed documentation
    │   └── *.class                            # Compiled files
    │
    ├── 02_greet_and_local_time/               # Es03-02: Greet & Time with RMI
    │   ├── GreetLocalTimeInterface.java       # Remote interface
    │   ├── GreetLocalTimeServer.java          # RMI server
    │   ├── GreetLocalTimeClient.java          # RMI client
    │   ├── README.md                          # Detailed documentation
    │   └── *.class                            # Compiled files
    │
    └── 03_file_access/                        # Es03-03: File Access with RMI
        ├── FileAccessInterface.java           # Remote interface
        ├── FileAccessServer.java              # RMI server + File I/O
        ├── FileAccessClient.java              # RMI client + Interactive input
        ├── input.txt                          # Remote test file
        ├── output.txt                         # File generated by client
        ├── README.md                          # etailed documentation
        └── *.class                            # Compiled files
```

---

## Documentazione

Each exercise includes:
- Fully commented code with detailed explanations
- Dedicated README.md with:
  - System overview
  - Mermaid diagrams (architecture, sequences, flows)
  - Detailed component analysis
  - Examples of execution with output
  - Explained theoretical concepts
  - Troubleshooting and technical notes
- Practical examples and real use cases
- Robust error handling

---

## Initial Setup
### 1. Clone the Repository
```bash
git clone https://github.com/lucadileo9/distributed_algorithms_exercises.git
cd distributed_algorithms_exercises
```

### 2. Verify Prerequisites
**For Es02 (Python)**:
```bash
python --version  # Must be 3.7+
```

**For Es03 (Java)**:
```bash
java -version     # Must be 8+
javac -version    # Must be available
```

### 3. Run an Exercise

```bash
# Example: Es03-03 File Access
cd Es03-RMI/03_file_access
javac *.java
java FileAccessServer    # In one terminal
java FileAccessClient    # In another terminal
```

---

*Educational material for the Distributed Algorithms course*  
*Instructor: Prof. Cabri - University of Modena and Reggio Emilia*  
*Updated: December 2025*