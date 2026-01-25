# Progetto Cloud and Edge Computing - Django Newspaper

**Autore**: Luca Di Leo  
**Data inizio**: 24 Gennaio 2026  
**Repository**: Fork da `gitlab.com/frfaenza/cloudedgecomputing`

---

## 📋 Indice

1. [Fondamenti Teorici](#parte-1-fondamenti-teorici)
   - [1.1 Concetti Docker](#11-concetti-docker)
   - [1.2 Concetti CI/CD](#12-concetti-cicd)
   - [1.3 Pre-commit: Automazione Locale](#13-pre-commit-automazione-locale)
   - [1.4 Glossario](#14-glossario)
2. [Contesto Progetto](#parte-2-contesto-progetto)
3. [Fase 2: Containerizzazione Docker](#parte-3-fase-2---containerizzazione-docker)
4. [Fase 3: CI/CD Pipeline](#parte-4-fase-3---cicd-pipeline)
5. [Architettura Finale e Workflow](#parte-5-architettura-finale-e-workflow)
6. [Comandi Utili](#parte-6-comandi-utili)

---

# PARTE 1: Fondamenti Teorici

Prima di entrare nei dettagli pratici del progetto, è essenziale comprendere i concetti teorici che stanno alla base delle tecnologie utilizzate.

---

## 1.1 Concetti Docker

Docker è una piattaforma di containerizzazione che permette di "impacchettare" applicazioni con tutte le loro dipendenze in unità isolate chiamate **container**.

---

### 1.1.1 Dal Dockerfile al Container: Il Workflow Fondamentale

Il cuore di Docker ruota attorno a tre elementi principali: **Dockerfile**, **Immagine** e **Container**.

Il **Dockerfile** è un semplice file di testo che contiene una serie di istruzioni che descrivono come costruire l'ambiente per la nostra applicazione. È come una "ricetta" che elenca tutti gli ingredienti (sistema operativo base, librerie, dipendenze) e i passaggi (copia file, installa pacchetti, configura) necessari per preparare il "piatto" finale.

Quando eseguiamo il comando `docker build`, Docker legge il Dockerfile e crea un'**Immagine**. L'immagine è un artefatto statico, immutabile, che contiene tutto il necessario per eseguire l'applicazione. Puoi pensarla come un file `.exe` o un'istantanea (snapshot) del sistema in un momento preciso. L'immagine viene salvata localmente e può essere condivisa tramite registry come Docker Hub.

Infine, quando eseguiamo `docker run`, Docker prende l'immagine e crea un **Container**. Il container è un processo in esecuzione, un'istanza "viva" dell'immagine. La differenza fondamentale è che l'immagine è statica (non cambia), mentre il container è dinamico (gira, consuma CPU, memoria, può essere fermato e riavviato).

Un concetto cruciale: **da una singola immagine possono nascere multipli container indipendenti**. È come avere un unico stampo (l'immagine) da cui puoi creare quante copie vuoi (i container), ognuna che gira in modo isolato dalle altre.

```mermaid
flowchart TD
    A[📄 Dockerfile<br/>File di testo con istruzioni] --> B[⚙️ docker build -t newspaper-app .]
    B --> C[📦 Immagine: newspaper-app<br/>Artefatto statico salvato]
    
    D[🐳 FROM python:3.10-slim<br/>Immagine base] -.-> A
    
    C --> E[▶️ docker run newspaper-app]
    C --> F[▶️ docker run newspaper-app]
    C --> G[▶️ docker run newspaper-app]
    
    E --> H[🟢 Container 1<br/>Processo in esecuzione]
    F --> I[🟢 Container 2<br/>Processo in esecuzione]
    G --> J[🟢 Container 3<br/>Processo in esecuzione]
    
    class B buildPhase
    class E,F,G runPhase
```

---

### 1.1.2 La Struttura a Layer del Dockerfile

Un aspetto fondamentale per capire l'efficienza di Docker è il sistema a **layer** (strati). Ogni istruzione nel Dockerfile crea un nuovo layer che viene impilato sopra il precedente, formando l'immagine finale come una "torta" a più strati.

Il vantaggio di questa architettura è il **caching**: quando ricostruisci un'immagine, Docker controlla se ogni layer è cambiato rispetto alla build precedente. Se un layer non è stato modificato, Docker lo riutilizza dalla cache invece di ricostruirlo da zero. Questo accelera enormemente i tempi di build.

Tuttavia, c'è una regola importante: **quando un layer cambia, tutti i layer successivi vengono invalidati e ricostruiti**. Ecco perché l'ordine delle istruzioni nel Dockerfile è cruciale per l'ottimizzazione.

La best practice è organizzare le istruzioni dalla più stabile alla più volatile:
1. **Prima**: istruzioni che cambiano raramente (immagine base, installazione tool di sistema)
2. **Poi**: dipendenze del progetto (requirements.txt)
3. **Infine**: il codice sorgente (che cambia spesso durante lo sviluppo)

```mermaid
flowchart TD
    A[🔹 Layer 1: FROM python:3.10-slim<br/>Immagine base - RARAMENTE cambia] --> B
    B[🔹 Layer 2: RUN apt-get install gcc...<br/>Tool compilazione - RARAMENTE cambia] --> C
    C[🔹 Layer 3: COPY requirements.txt<br/>Lista dipendenze - CAMBIA occasionalmente] --> D
    D[🔹 Layer 4: RUN pip install -r requirements.txt<br/>Installa librerie - CAMBIA occasionalmente] --> E
    E[🔸 Layer 5: COPY . .<br/>Codice applicazione - CAMBIA SPESSO] --> F
    F[🔸 Layer 6: CMD uwsgi --ini uwsgi.ini<br/>Comando avvio - CAMBIA raramente]
    
    G[💾 Cache Docker] -.->|Riusa se invariato| A
    G -.->|Riusa se invariato| B
    G -.->|Riusa se invariato| C
    G -.->|Riusa se invariato| D
    
    H[⚡ Modifica codice] -.->|Invalida cache da qui| E
    
    I[📝 BEST PRACTICE:<br/>COPY requirements PRIMA del codice<br/>→ Rebuild veloce quando cambi solo codice]
```

---

### 1.1.3 Docker Compose: Orchestrazione Multi-Container

Nella realtà, le applicazioni moderne raramente girano in isolamento. Un'applicazione web tipica ha bisogno di un database, magari una cache Redis, un server di code, ecc. Gestire manualmente ogni container (crearli, collegarli, avviarli nell'ordine giusto) sarebbe un incubo.

**Docker Compose** risolve questo problema. È uno strumento che permette di definire e gestire applicazioni multi-container attraverso un singolo file YAML (`docker-compose.yml`). In questo file descrivi tutti i servizi che compongono la tua applicazione, le loro configurazioni, come comunicano tra loro, e i volumi per i dati.

Con un solo comando (`docker-compose up`), Docker Compose:
1. Crea automaticamente una **rete privata** dove i container possono comunicare
2. Crea i **volumi** necessari per la persistenza dei dati
3. Costruisce le immagini se necessario (esegue `docker build`)
4. Avvia i container nell'**ordine corretto** rispettando le dipendenze

```mermaid
flowchart TD
    A[📄 docker-compose.yml] --> B{docker-compose up}
    
    B --> C[🌐 Crea Network<br/>cloudedgecomputing_default]
    B --> D[💾 Crea Volume<br/>mysql_data]
    
    C --> E[🔵 Servizio: db<br/>MySQL 8.0<br/>Container: newspaper_db]
    C --> F[🟢 Servizio: web<br/>Django + uWSGI<br/>Container: newspaper_web]
    
    D --> E
    
    E -->|healthcheck: mysqladmin ping| G{MySQL<br/>ready?}
    G -->|❌ Retry| G
    G -->|✅ Healthy| H[Sblocca avvio web]
    
    H --> F
    
    I[depends_on:<br/>web dipende da db] -.->|Definisce ordine| H
    
    F -.->|Connessione TCP/IP| E
    
    J[Browser: localhost:8000] --> F
```

---

### 1.1.4 Networking: Come Comunicano i Container

Quando Docker Compose avvia i container, li collega tutti a una **rete virtuale privata**. Questa rete è isolata dal mondo esterno e permette ai container di comunicare tra loro in modo sicuro.

La magia sta nel **Docker DNS**: all'interno della rete Docker, ogni container può riferirsi agli altri usando il **nome del servizio** invece dell'indirizzo IP. Nel nostro caso, il container Django può connettersi a MySQL semplicemente usando `db:3306` come indirizzo. Docker intercetta questa richiesta e la traduce automaticamente nell'IP interno del container MySQL.

Perché è importante? Gli IP dei container sono **dinamici**: cambiano ogni volta che ricrei i container. Se hardcodassimo l'IP nel codice, smetterebbe di funzionare al prossimo restart. Usando i nomi di servizio, il codice rimane stabile e Docker si occupa della risoluzione.

Per il mondo esterno (il tuo browser), i container non sono direttamente accessibili. Il **port mapping** (`-p 8000:8000`) crea un "ponte" che collega una porta del tuo computer (localhost:8000) a una porta del container.

```mermaid
graph LR
    subgraph Host["💻 Windows Host"]
        Browser[🌐 Browser<br/>localhost:8000]
    end
    
    subgraph DockerNet["🌐 Docker Network: cloudedgecomputing_default"]
        Web["🟢 Container: web<br/>IP: 172.18.0.3<br/>Porta: 8000"]
        DB["🔵 Container: db<br/>IP: 172.18.0.2<br/>Porta: 3306"]
        DNS["🔍 Docker DNS<br/>db → 172.18.0.2<br/>web → 172.18.0.3"]
    end
    
    Browser -->|Port mapping<br/>:8000 → :8000| Web
    
    Web -->|❌ NON usa IP diretto<br/>✅ USA nome: db:3306| DNS
    DNS -->|Risolve in IP| DB
    
    Web -.->|Connessione TCP/IP| DB
    
    Note1["📝 Container NON usano socket Unix<br/>Solo comunicazione TCP/IP via rete"]
```

---

### 1.1.5 Volumi: Persistenza dei Dati

I container sono **effimeri** per natura: quando un container viene distrutto, tutto ciò che contiene (inclusi i dati) viene perso. Per un database questo sarebbe disastroso! I **volumi** risolvono questo problema permettendo ai dati di sopravvivere alla distruzione del container.

Esistono due tipi principali di volumi:

**Bind Mount**: collega una directory del tuo computer host direttamente dentro il container. Qualsiasi modifica fatta da una parte è immediatamente visibile dall'altra. Perfetto per lo sviluppo!

**Named Volume**: è uno spazio di storage gestito interamente da Docker, "nascosto" nel filesystem dell'host. I dati sono conservati in modo persistente da Docker anche se il container viene distrutto.

```mermaid
flowchart TD
    subgraph BindMount["A️⃣ BIND MOUNT - Development"]
        A1[💻 Host Windows<br/>C:\Users\...\cloudedgecomputing]
        A2[🔄 Sincronizzazione<br/>BIDIREZIONALE<br/>Tempo reale]
        A3[🐳 Container: web<br/>/app]
        
        A1 <-->|volumes:<br/>- .:/app| A2
        A2 <--> A3
        
        A4[✏️ Modifichi file su Windows<br/>→ Cambio immediato in container<br/>→ NO rebuild necessario]
    end
    
    subgraph NamedVol["B️⃣ NAMED VOLUME - Persistenza"]
        B1[🔒 Docker Storage<br/>Nascosto nel filesystem<br/>/var/lib/docker/volumes/]
        B2[💾 Volume: mysql_data<br/>Gestito da Docker]
        B3[🐳 Container: db<br/>/var/lib/mysql]
        
        B1 --> B2
        B2 -->|Montato in| B3
        
        B4[🔁 Container distrutto?<br/>Volume PERSISTE<br/>Dati database SICURI]
        
        B5[❌ docker-compose down -v<br/>→ Volume cancellato<br/>→ DATI PERSI]
    end
```

---

### 1.1.6 Variabili d'Ambiente: Configurazione Esterna

Una delle best practice fondamentali nello sviluppo software è la **separazione tra codice e configurazione**. Non vuoi hardcodare password, hostname o altre impostazioni nel codice sorgente.

Docker risolve questo problema attraverso le **variabili d'ambiente**. Nel `docker-compose.yml`, sotto la sezione `environment`, definiamo coppie chiave-valore che vengono "iniettate" nel container al momento dell'avvio.

Il punto cruciale è che **docker-compose non modifica mai il codice Python**. Il codice rimane generico (`os.environ.get('MYSQL_HOST')`), ed è l'ambiente di esecuzione che fornisce i valori concreti.

```mermaid
sequenceDiagram
    participant DC as docker-compose.yml
    participant Container as Container Web
    participant OS as Sistema Operativo
    participant Python as Processo Python
    participant Django as production_settings.py
    participant DNS as Docker DNS
    participant MySQL as Container DB
    
    DC->>Container: Crea container con ENV:<br/>MYSQL_HOST=db<br/>MYSQL_PASSWORD=django_password
    Container->>OS: Registra variabili d'ambiente
    Container->>Python: Avvia processo Python
    Python->>Django: Esegue production_settings.py
    
    Django->>OS: os.environ.get('MYSQL_HOST')
    OS-->>Django: Ritorna: "db"
    
    Django->>OS: os.environ.get('MYSQL_PASSWORD')
    OS-->>Django: Ritorna: "django_password"
    
    Note over Django: Configurazione DATABASES:<br/>HOST='db', PASSWORD='django_password'
    
    Django->>DNS: Risolvi nome: db
    DNS-->>Django: Ritorna IP: 172.18.0.2
    
    Django->>MySQL: Connessione TCP/IP a 172.18.0.2:3306
    MySQL-->>Django: ✅ Connessione stabilita
    
    Note over DC,MySQL: 🔑 docker-compose NON modifica codice Python<br/>SOLO passa variabili all'ambiente
```

---

### 1.1.7 I Tre Comandi Fondamentali: build, run, compose up

Per lavorare con Docker, devi padroneggiare tre comandi principali, ognuno con uno scopo diverso:

**`docker build`** serve esclusivamente a creare immagini. Non avvia nessun container: è pura "compilazione".

**`docker run`** prende un'immagine esistente e crea un singolo container da essa. Utile per test rapidi ma richiede gestione manuale di network e volumi.

**`docker-compose up`** è il comando più potente per applicazioni reali. Automatizza tutto: costruisce le immagini, crea network e volumi, avvia tutti i container nell'ordine corretto.

```mermaid
flowchart TD
    subgraph Build["🔨 PERCORSO A: docker build"]
        A1[📄 Input: Dockerfile]
        A2[⚙️ docker build -t newspaper-app .]
        A3[📦 Output: Immagine]
        A4[❌ Nessun container creato<br/>Solo preparazione]
        
        A1 --> A2 --> A3 --> A4
    end
    
    subgraph Run["▶️ PERCORSO B: docker run"]
        B1[📦 Input: Immagine esistente]
        B2[⚙️ docker run -p 8000:8000 newspaper-app]
        B3[🟢 Output: 1 Container attivo]
        B4[⚠️ Manuale:<br/>- Devi creare network<br/>- Devi creare volumi<br/>- Devi avviare MySQL separatamente]
        
        B1 --> B2 --> B3 --> B4
    end
    
    subgraph Compose["🎼 PERCORSO C: docker-compose up"]
        C1[📄 Input: docker-compose.yml]
        C2[🔨 Build immagini se necessario]
        C3[🌐 Crea network automaticamente]
        C4[💾 Crea volumi automaticamente]
        C5[🔵 Avvia container db]
        C6[⏳ Aspetta healthcheck]
        C7[🟢 Avvia container web]
        C8[✅ Sistema completo funzionante]
        
        C1 --> C2 --> C3 --> C4 --> C5 --> C6 --> C7 --> C8
    end
    
    X[💡 QUANDO USARE:<br/>Build: Creare immagini<br/>Run: Test singolo container<br/>Compose: Ambiente completo]
```

---

## 1.2 Concetti CI/CD

**CI/CD** (Continuous Integration / Continuous Delivery) è una pratica fondamentale nello sviluppo software moderno che automatizza il processo di verifica, test e deployment del codice.

---

### 1.2.1 Continuous Integration (CI)

**Continuous Integration** significa che ogni volta che un sviluppatore fa push del codice, viene automaticamente eseguita una serie di controlli: il codice viene compilato, i test vengono eseguiti, la qualità viene verificata. Se qualcosa fallisce, lo sviluppatore viene notificato immediatamente, permettendo di correggere gli errori quando sono ancora "freschi" e facili da risolvere.

---

### 1.2.2 Continuous Delivery (CD)

**Continuous Delivery** estende questo concetto: dopo che il codice passa tutti i controlli CI, viene automaticamente preparato (e opzionalmente deployato) in un ambiente di staging o production. L'obiettivo è avere sempre codice "pronto per il rilascio".

---

### 1.2.3 GitLab CI/CD

Nel nostro progetto utilizziamo **GitLab CI/CD**, che offre:
- Runner gratuiti nel cloud per eseguire le pipeline
- Integrazione nativa con il repository Git
- Configurazione tramite un semplice file YAML (`.gitlab-ci.yml`)
- Badge, report e artifacts integrati nell'interfaccia

```mermaid
flowchart LR
    subgraph CI["🔄 Continuous Integration"]
        A[👨‍💻 git push] --> B[🔨 Build Check]
        B --> C[🧪 Test Automatici]
        C --> D[📏 Code Quality]
        D --> E[🔒 Security Scan]
    end
    
    E --> F{✅ Tutti<br/>i check<br/>passano?}
    
    F -->|❌ No| G[📧 Notifica Errore<br/>Pipeline Rossa]
    F -->|✅ Sì| H[🎉 Pipeline Verde<br/>Codice Verificato]
    
    subgraph CD["🚀 Continuous Delivery"]
        H --> I[📦 Build Artifact]
        I --> J[🌍 Deploy Staging]
        J --> K[🏭 Deploy Production]
    end
    
```

---

### 1.2.4 Keywords del File `.gitlab-ci.yml`

Il file `.gitlab-ci.yml` utilizza una serie di **parole chiave** (keywords) che definiscono il comportamento della pipeline. Comprendere queste keywords è fondamentale per configurare correttamente la CI/CD.

#### Keywords Globali

| Keyword | Descrizione | Esempio |
|---------|-------------|----------|
| `stages` | Definisce l'ordine di esecuzione degli stage. I job dello stesso stage vengono eseguiti in parallelo, gli stage in sequenza. | `stages: [build, test, deploy]` |
| `image` | Immagine Docker da usare per tutti i job (può essere sovrascritta per singolo job). | `image: python:3.10` |
| `variables` | Variabili d'ambiente globali disponibili in tutti i job. | `variables: DEBUG: "false"` |
| `default` | Configurazioni di default per tutti i job (image, before_script, ecc.). | `default: image: python:3.10` |

#### Keywords dei Job

| Keyword | Descrizione | Esempio |
|---------|-------------|----------|
| `stage` | A quale stage appartiene il job. Determina quando viene eseguito. | `stage: test` |
| `script` | **OBBLIGATORIO**. Lista di comandi shell da eseguire. È il cuore del job. | `script: - pip install -r requirements.txt` |
| `before_script` | Comandi eseguiti PRIMA di `script`. Utile per setup comune. | `before_script: - pip install --upgrade pip` |
| `after_script` | Comandi eseguiti DOPO `script`, anche se fallisce. Utile per cleanup. | `after_script: - rm -rf temp/` |
| `allow_failure` | Se `true`, il job può fallire senza far fallire la pipeline. Utile per check non bloccanti. | `allow_failure: true` |
| `artifacts` | File/cartelle da salvare e rendere disponibili per job successivi o download. | `artifacts: paths: - coverage.xml` |
| `coverage` | Regex per estrarre la percentuale di coverage dai log e mostrarla in GitLab. | `coverage: '/TOTAL.*\s+(\d+%)$/'` |
| `only` / `except` | Condizioni per eseguire o saltare il job (branch, tag, ecc.). Deprecato in favore di `rules`. | `only: - main` |
| `rules` | Condizioni avanzate per eseguire il job (più flessibile di only/except). | `rules: - if: $CI_COMMIT_BRANCH == "main"` |
| `needs` | Definisce dipendenze tra job, permettendo esecuzione parallela ottimizzata (DAG). | `needs: ["build_check"]` |
| `dependencies` | Specifica da quali job scaricare gli artifacts. | `dependencies: - build` |
| `cache` | File da cacheare tra esecuzioni per velocizzare (es. dipendenze pip). | `cache: paths: - .pip-cache/` |
| `timeout` | Tempo massimo di esecuzione del job prima del kill automatico. | `timeout: 10 minutes` |
| `retry` | Numero di tentativi in caso di fallimento (utile per test flaky). | `retry: 2` |

#### Esempio Commentato Completo

```yaml
# Keywords globali
stages:          # Ordine degli stage
  - build
  - test  
  - security

image: python:3.10-slim   # Immagine di default per tutti i job

variables:                # Variabili globali
  PIP_CACHE_DIR: "$CI_PROJECT_DIR/.pip-cache"

default:                  # Configurazioni di default
  before_script:          # Eseguito prima di ogni job
    - pip install --upgrade pip

# Definizione di un job
build_check:              # Nome del job (arbitrario)
  stage: build            # Appartiene allo stage "build"
  script:                 # Comandi da eseguire
    - python -m py_compile manage.py
    - python -m compileall .
  cache:                  # Cache delle dipendenze
    paths:
      - .pip-cache/

test_django:
  stage: test
  script:
    - pip install coverage
    - coverage run manage.py test
    - coverage report
    - coverage xml
  coverage: '/TOTAL.*\s+(\d+%)$/'  # Estrae coverage dai log
  artifacts:                        # Salva file per dopo
    reports:
      coverage_report:
        coverage_format: cobertura
        path: coverage.xml
    expire_in: 1 week               # Artifacts scadono dopo 1 settimana

lint_flake8:
  stage: test
  script:
    - pip install flake8
    - flake8 --max-line-length=120 .
  allow_failure: true     # Non blocca la pipeline se fallisce
  rules:                  # Condizioni di esecuzione
    - if: $CI_PIPELINE_SOURCE == "merge_request_event"
    - if: $CI_COMMIT_BRANCH == "main"
```

---

## 1.3 Pre-commit: Automazione Locale

**Pre-commit** è un framework per gestire **git hooks** in modo semplice e condivisibile. I git hooks sono script che Git esegue automaticamente in determinati momenti del workflow (prima di un commit, prima di un push, ecc.).

---

### 1.3.1 Cos'è e Perché Usarlo

Il problema che pre-commit risolve è semplice: **come garantire che il codice rispetti determinati standard PRIMA che venga committato?**

Senza pre-commit, lo sviluppatore potrebbe:
1. Scrivere codice mal formattato
2. Fare commit e push
3. La CI fallisce per problemi di formatting
4. Deve fixare e ri-pushare → Tempo perso!

Con pre-commit:
1. Lo sviluppatore prova a committare
2. Pre-commit intercetta e formatta automaticamente
3. Il commit contiene già codice corretto
4. La CI passa al primo colpo → Efficienza!

---

### 1.3.2 Come Funziona

Pre-commit si basa su un file di configurazione `.pre-commit-config.yaml` che definisce quali **hooks** eseguire. Ogni hook è un controllo o una trasformazione applicata ai file staged.

```mermaid
sequenceDiagram
    participant Dev as 👨‍💻 Sviluppatore
    participant Git as 🗂️ Git
    participant PC as 🪝 Pre-commit
    participant Hooks as 🔧 Hooks Configurati
    
    Dev->>Git: git add file.py
    Dev->>Git: git commit -m "feature"
    Git->>PC: Trigger hook pre-commit
    
    PC->>Hooks: Esegui Black (formatting)
    Hooks-->>PC: File modificato ✏️
    
    PC->>Hooks: Esegui trailing-whitespace
    Hooks-->>PC: Spazi rimossi ✏️
    
    PC->>Hooks: Esegui check-yaml
    Hooks-->>PC: YAML valido ✅
    
    alt Alcuni file sono stati modificati
        PC-->>Git: ❌ Commit BLOCCATO
        Git-->>Dev: "Files were modified by hooks"<br/>"Please stage and commit again"
        Note over Dev: Esegue: git add . && git commit -m "feature"
    else Nessuna modifica necessaria
        PC-->>Git: ✅ Tutti gli hook passati
        Git-->>Dev: Commit completato con successo
    end
```

---

### 1.3.3 Configurazione nel Progetto

Il nostro file `.pre-commit-config.yaml`:

```yaml
repos:
  # Hook per Black - Formattatore Python
  - repo: https://github.com/psf/black
    rev: 23.3.0
    hooks:
      - id: black
        args: ['--line-length=120']  # Stessa config della CI
  
  # Hook generici di pre-commit
  - repo: https://github.com/pre-commit/pre-commit-hooks
    rev: v4.4.0
    hooks:
      - id: trailing-whitespace      # Rimuove spazi a fine riga
      - id: end-of-file-fixer        # Aggiunge newline finale
      - id: check-yaml               # Valida sintassi YAML
      - id: check-merge-conflict     # Blocca se ci sono marker di merge
```

**Spiegazione degli hooks**:

| Hook | Cosa Fa | Perché È Utile |
|------|---------|----------------|
| `black` | Riformatta codice Python secondo standard PEP8+ | Codice consistente, niente discussioni su stile |
| `trailing-whitespace` | Rimuove spazi bianchi a fine riga | Evita diff "sporchi" con solo whitespace |
| `end-of-file-fixer` | Assicura che i file terminino con newline | Standard POSIX, evita warning in alcuni tool |
| `check-yaml` | Valida sintassi dei file YAML | Previene errori in docker-compose.yml, CI config |
| `check-merge-conflict` | Blocca commit con marker `<<<<<<<` | Previene commit accidentali di conflitti |

N.B.: per comodità nel progetto ho incluso solo black.

---

### 1.3.4 Setup e Comandi

```bash
# Installazione (una volta)
pip install pre-commit

# Attivazione nel repository (una volta per repo)
pre-commit install

# Esecuzione manuale su tutti i file
pre-commit run --all-files

# Esecuzione su file specifici
pre-commit run --files accounts/views.py

# Aggiornamento hooks alle ultime versioni
pre-commit autoupdate

# Bypass temporaneo (emergenze!)
git commit --no-verify -m "hotfix urgente"
```

---

## 1.4 Glossario

Riferimento rapido dei termini tecnici utilizzati in questa documentazione.

### Docker

| Termine | Definizione |
|---------|-------------|
| **Container** | Unità isolata di esecuzione che contiene applicazione + dipendenze. Leggero, portabile, effimero. |
| **Immagine** | Template immutabile (snapshot) da cui si creano i container. Costruita da un Dockerfile. |
| **Dockerfile** | File di testo con istruzioni per costruire un'immagine Docker. |
| **Layer** | Singolo strato di un'immagine Docker. Ogni istruzione crea un layer. I layer sono cachati. |
| **Registry** | Repository remoto per immagini Docker (es. Docker Hub, GitLab Container Registry). |
| **Volume** | Meccanismo per persistere dati oltre la vita del container. |
| **Bind Mount** | Tipo di volume che mappa una cartella host dentro il container. |
| **Named Volume** | Tipo di volume gestito da Docker, indipendente dal filesystem host. |
| **Network** | Rete virtuale che permette comunicazione tra container. |
| **Port Mapping** | Collegamento tra porta host e porta container (`-p 8000:8000`). |
| **Healthcheck** | Controllo periodico per verificare che un servizio sia funzionante. |
| **Docker Compose** | Tool per definire e gestire applicazioni multi-container via YAML. |

### CI/CD

| Termine | Definizione |
|---------|-------------|
| **CI (Continuous Integration)** | Pratica di integrare frequentemente il codice ed eseguire test automatici ad ogni push. |
| **CD (Continuous Delivery)** | Estensione della CI: il codice è sempre pronto per il deploy in produzione. |
| **Pipeline** | Sequenza automatizzata di stage e job che processano il codice. |
| **Stage** | Fase della pipeline (es. build, test, deploy). Gli stage sono sequenziali. |
| **Job** | Singola unità di lavoro nella pipeline. Job nello stesso stage girano in parallelo. |
| **Runner** | Macchina (fisica o virtuale) che esegue i job della pipeline. |
| **Artifact** | File prodotto da un job e salvato per job successivi o download. |
| **Coverage** | Percentuale di codice coperta dai test automatici. |
| **Linting** | Analisi statica del codice per trovare errori e problemi di stile. |
| **Hook** | Script eseguito automaticamente in risposta a eventi (es. pre-commit). |

### Python/Django

| Termine | Definizione |
|---------|-------------|
| **Django** | Framework web Python ad alto livello per sviluppo rapido. |
| **uWSGI** | Application server che serve applicazioni Python in produzione. |
| **WSGI** | Standard Python per comunicazione tra web server e applicazione. |
| **Migration** | File che descrive modifiche allo schema del database. |
| **Virtual Environment (venv)** | Ambiente Python isolato con proprie dipendenze. |
| **requirements.txt** | File che elenca le dipendenze Python del progetto. |

### Tool di Qualità

| Termine | Definizione |
|---------|-------------|
| **Black** | Formattatore Python "opinionated" - formatta il codice in modo deterministico. |
| **Flake8** | Linter Python che controlla errori, stile (PEP8), complessità. |
| **Safety** | Tool che controlla le dipendenze Python per vulnerabilità note (CVE). |
| **Coverage** | Tool che misura quale percentuale del codice viene eseguita dai test. |
| **Pre-commit** | Framework per gestire git hooks e automazione pre-commit. |

---

# PARTE 2: Contesto Progetto

## Obiettivo Generale

Creare un ambiente containerizzato riproducibile per un'applicazione Django che simula un ambiente production con MySQL, implementando pipeline CI/CD per garantire qualità del codice.

---

## Stack Tecnologico

| Componente | Tecnologia | Versione |
|------------|------------|----------|
| Framework Web | Django | 4.0 |
| Database Production | MySQL | 8.0 |
| Database Development | SQLite | Built-in |
| Application Server | uWSGI | 2.0.21 |
| Containerizzazione | Docker + Compose | Latest |
| CI/CD | GitLab CI | Cloud Runner |

---

## Panoramica Fasi

```mermaid
flowchart LR
    F2[📦 Fase 2<br/>Containerizzazione<br/>Docker + MySQL] --> F3[🔄 Fase 3<br/>CI/CD Pipeline<br/>Test + Quality]
    F3 --> F4[🚀 Fase 4<br/>CD Deployment<br/>Coming Soon]
```

| Fase | Obiettivo | Stato |
|------|-----------|-------|
| Fase 2 | Containerizzazione Django + MySQL | ✅ Completata |
| Fase 3 | Pipeline CI/CD con GitLab | ✅ Completata |
| Fase 4 | Deployment automatico | 🔜 Prossima |

---

# PARTE 3: Fase 2 - Containerizzazione Docker

## Obiettivo

Containerizzare l'applicazione Django Newspaper con MySQL, creando un ambiente di sviluppo riproducibile che simula la production.

---

## Cosa Abbiamo Fatto

### File Creati

#### 1. Dockerfile

Ricetta per costruire l'immagine Django:

```dockerfile
FROM python:3.10-slim

ENV PYTHONUNBUFFERED=1 \
    PYTHONDONTWRITEBYTECODE=1

WORKDIR /app

# Dipendenze per compilare mysqlclient e uWSGI
RUN apt-get update && apt-get install -y \
    gcc \
    g++ \
    default-libmysqlclient-dev \
    pkg-config \
    python3-dev \
    && rm -rf /var/lib/apt/lists/*

COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

COPY . .

RUN mkdir -p /app/logs

EXPOSE 8000

CMD ["uwsgi", "--ini", "uwsgi.ini"]
```

**Punti chiave**:
- Immagine base leggera: `python:3.10-slim`
- Layer caching: `requirements.txt` copiato prima del codice
- `EXPOSE 8000`: Documentazione della porta

---

#### 2. docker-compose.yml

Orchestrazione Django + MySQL:

```yaml
version: '3.8'

services:
  db:
    image: mysql:8.0
    container_name: newspaper_db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: blog
      MYSQL_USER: django
      MYSQL_PASSWORD: django_password
      MYSQL_ROOT_PASSWORD: root_password
    volumes:
      - mysql_data:/var/lib/mysql
    ports:
      - "3306:3306"
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
      timeout: 5s
      retries: 10

  web:
    build: .
    container_name: newspaper_web
    command: >
      sh -c "python manage.py migrate &&
             uwsgi --ini uwsgi.ini"
    volumes:
      - .:/app
    ports:
      - "8000:8000"
    environment:
      - DJANGO_SETTINGS_MODULE=django_project.production_settings
      - MYSQL_DATABASE=blog
      - MYSQL_USER=django
      - MYSQL_PASSWORD=django_password
      - MYSQL_HOST=db
      - MYSQL_PORT=3306
      - DJANGO_SECRET_KEY=dev-secret-key
    depends_on:
      db:
        condition: service_healthy

volumes:
  mysql_data:
```

**Elementi critici**:
- `healthcheck` su MySQL: Assicura che db sia pronto prima di avviare web
- `depends_on` con `condition: service_healthy`: Web aspetta db
- `volumes: - .:/app`: Bind mount per development
- `mysql_data`: Named volume per persistenza dati

---

#### 3. uwsgi.ini

Configurazione application server:

```ini
[uwsgi]
chdir = /app
module = django_project.wsgi:application
master = true
processes = 4
threads = 2
http = 0.0.0.0:8000
logto = /app/logs/uwsgi.log
log-maxsize = 50000000
py-autoreload = 1
pidfile = /app/uwsgi.pid
vacuum = true
die-on-term = true
```

---

### File Modificati

#### 1. requirements.txt

Aggiunte dipendenze mancanti:

```txt
asgiref==3.4.1
crispy-bootstrap5==0.6
dj-database-url==0.5.0
dj-email-url==1.0.2
Django==4.0
django-cache-url==3.2.3
django-crispy-forms==1.13.0
environs==9.3.5
marshmallow==3.14.1
mysqlclient==2.1.1    # ← Per Docker/MySQL
python-dotenv==0.19.2
sqlparse==0.4.2
whitenoise==5.3.0
uWSGI==2.0.21         # ← Aggiunto (mancava!)
```

---

#### 2. django_project/production_settings.py

Configurazione per leggere da variabili d'ambiente:

```python
import os

DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.mysql',
        'NAME': os.environ.get('MYSQL_DATABASE', 'blog'),
        'USER': os.environ.get('MYSQL_USER', 'django'),
        'PASSWORD': os.environ.get('MYSQL_PASSWORD'),
        'HOST': os.environ.get('MYSQL_HOST', 'db'),  # ← CRITICO
        'PORT': os.environ.get('MYSQL_PORT', '3306'),
        'OPTIONS': {
            'charset': 'utf8mb4',
        },
    }
}

SECRET_KEY = os.environ.get('DJANGO_SECRET_KEY', 'temp-secret')
DEBUG = False
ALLOWED_HOSTS = ['localhost', '127.0.0.1', 'web', '*']
```

---

## Problemi Riscontrati e Soluzioni

### 🔴 Problema 1: mysqlclient Non Compila su Windows

**Sintomo**:
```
fatal error C1083: Non è possibile aprire il file inclusione: 'mysql.h'
```

**Causa**: `mysqlclient` è una libreria Python con componenti C che richiedono compilazione. Su Windows serve Visual Studio Build Tools + MySQL header files.

**Soluzione**: Strategia duale basata su ambiente:

| Ambiente | Database | mysqlclient | Come Lavori |
|----------|----------|-------------|-------------|
| **Locale Windows** | SQLite | Commentato | `python manage.py runserver` |
| **Docker** | MySQL | Compila in Linux | `docker-compose up` |

---

### 🔴 Problema 2: Configurazione uWSGI Mancante

**Sintomo**: README menziona `uwsgi.ini.example` ma file non presente nel repository.

**Soluzione**: Creato `uwsgi.ini` manualmente con configurazione production-ready (vedi sopra).

---

### 🔴 Problema 3: Django Usa Socket invece di TCP/IP

**Sintomo**:
```
django.db.utils.OperationalError: (2002, "Can't connect to local server through socket '/run/mysqld/mysqld.sock' (2)")
```

**Causa**: Django cercava connessione via socket Unix invece che rete TCP/IP. In Docker, container comunicano **solo** via rete.

**Soluzione**: Specificare `HOST` esplicito in `production_settings.py`:
```python
'HOST': os.environ.get('MYSQL_HOST', 'db'),  # Forza TCP/IP
```

---

### 🔴 Problema 4: uWSGI Mancante in requirements.txt

**Sintomo**:
```
sh: 2: uwsgi: not found
newspaper_web exited with code 127
```

**Causa**: `uWSGI` non era elencato in `requirements.txt`.

**Soluzione**: Aggiunto `uWSGI==2.0.21` e rebuild:
```bash
docker-compose build --no-cache
docker-compose up
```

---

## Risultato Fase 2

✅ **Ambiente Docker funzionante** con:
- Container Django + uWSGI
- Container MySQL 8.0 con healthcheck
- Rete Docker per comunicazione
- Volumi per persistenza dati e sync codice

✅ **Workflow duale**:
- Development veloce su Windows con SQLite
- Test production-like con Docker + MySQL

---

# PARTE 4: Fase 3 - CI/CD Pipeline

## Obiettivo

Implementare pipeline CI automatizzata con GitLab CI per garantire qualità codice, test automatici e security scanning.

---

## Cosa Abbiamo Fatto

### Struttura Pipeline (`.gitlab-ci.yml`)

```yaml
stages:
  - build      # Verifica che il codice sia valido
  - test       # Esegue test e controlli qualità
  - security   # Scansione vulnerabilità
```

```mermaid
flowchart TD
    subgraph Stage1["📦 STAGE: Build"]
        B1[build_check<br/>~20s]
    end
    
    subgraph Stage2["🧪 STAGE: Test"]
        T1[test_django<br/>~30s]
        T2[format_check<br/>~10s]
        T3[lint_flake8<br/>~5s]
    end
    
    subgraph Stage3["🔒 STAGE: Security"]
        S1[security_dependencies<br/>~15s]
    end
    
    Stage1 --> Stage2
    Stage2 --> Stage3
    
    T1 -.->|Coverage 93%| R1[📊 Report]
    S1 -.->|CVE Check| R2[📋 Safety Report]
```

---

### Job Implementati

Ogni job della pipeline ha uno scopo specifico. Analizziamoli nel dettaglio, sia a livello concettuale che di singoli comandi.

---

#### 🔨 Build Check

**Scopo**: Verificare che il codice Python sia sintatticamente corretto PRIMA di eseguire test. Se il codice non compila, non ha senso perdere tempo con i test.

```yaml
build_check:
  stage: build
  script:
    - python -m py_compile manage.py
    - python -m compileall .
```

**Analisi script**:

| Comando | Cosa Fa |
|---------|----------|
| `python -m py_compile manage.py` | Compila `manage.py` in bytecode. Se ci sono errori di sintassi (parentesi mancanti, indentazione errata), fallisce immediatamente. È un controllo rapido sul file principale. |
| `python -m compileall .` | Compila TUTTI i file `.py` nella directory corrente e sottodirectory. Trova errori di sintassi in qualsiasi file del progetto. |

**Perché questo job è importante**: Fallisce velocemente (~20 secondi) se qualcuno ha pushato codice con errori di sintassi evidenti, evitando di sprecare tempo nei job successivi.

---

#### 🧪 Test Django + Coverage

**Scopo**: Eseguire la suite di test automatici e misurare quanta parte del codice viene effettivamente testata (coverage). Questo è il job più importante per garantire che il codice funzioni.

```yaml
test_django:
  stage: test
  script:
    - pip install coverage
    - coverage run --source='.' manage.py test
    - coverage report
    - coverage xml
  coverage: '/TOTAL.*\s+(\d+%)$/'
  artifacts:
    reports:
      coverage_report:
        coverage_format: cobertura
        path: coverage.xml
```

**Analisi script**:

| Comando | Cosa Fa |
|---------|----------|
| `pip install coverage` | Installa il tool `coverage` che traccia quali linee di codice vengono eseguite durante i test. |
| `coverage run --source='.' manage.py test` | Esegue `manage.py test` (che lancia tutti i test Django) mentre `coverage` traccia ogni linea eseguita. `--source='.'` limita il tracciamento ai file del progetto (non librerie esterne). |
| `coverage report` | Stampa a terminale un report tabellare con percentuali di copertura per ogni file. Utile per debug. |
| `coverage xml` | Genera `coverage.xml` in formato Cobertura, leggibile da GitLab per mostrare coverage nella UI. |

**Analisi keywords**:

| Keyword | Cosa Fa |
|---------|----------|
| `coverage: '/TOTAL.*\s+(\d+%)$/'` | Regex che GitLab usa per estrarre la percentuale totale dal log. Cerca una riga tipo `TOTAL ... 93%` e cattura "93%". Questo valore appare nei badge e nella UI. |
| `artifacts.reports.coverage_report` | Dice a GitLab che `coverage.xml` è un report di coverage in formato Cobertura. GitLab lo processa per mostrare coverage inline nelle Merge Request. |

---

#### ⬛ Format Check (Black)

**Scopo**: Verificare che TUTTO il codice Python sia formattato secondo lo standard Black. Garantisce consistenza stilistica nel progetto.

```yaml
format_check:
  stage: test
  script:
    - pip install black
    - black --check --line-length=120 .
```

**Analisi script**:

| Comando | Cosa Fa |
|---------|----------|
| `pip install black` | Installa Black, il formattatore Python "opinionated" che impone uno stile univoco. |
| `black --check --line-length=120 .` | Controlla tutti i file Python. `--check` significa "non modificare, solo verificare". Se un file non è formattato correttamente, il comando fallisce con exit code 1. `--line-length=120` imposta la lunghezza massima delle righe. |

**Perché `--check`?**: In CI non vogliamo modificare file, solo verificare. Le modifiche vengono fatte localmente da pre-commit.

**Perché questo job blocca la pipeline?**: Se il codice non è formattato, significa che lo sviluppatore non ha usato pre-commit. Bloccando, forziamo l'adozione di standard consistenti.

---

#### 📏 Linting (Flake8)

**Scopo**: Analisi statica del codice per trovare problemi come import inutilizzati, variabili non usate, errori logici comuni, violazioni PEP8.

```yaml
lint_flake8:
  stage: test
  script:
    - pip install flake8
    - flake8 --max-line-length=120 --exclude=migrations,venv
  allow_failure: true  # Warning only
```

**Analisi script**:

| Comando | Cosa Fa |
|---------|----------|
| `pip install flake8` | Installa Flake8, un linter che combina pyflakes (errori logici), pycodestyle (stile PEP8), mccabe (complessità). |
| `flake8 --max-line-length=120 --exclude=migrations,venv` | Analizza tutti i file Python. `--max-line-length=120` per consistenza con Black. `--exclude=migrations,venv` esclude file generati automaticamente (migrazioni Django) e virtual environment. |

**Analisi keywords**:

| Keyword | Cosa Fa |
|---------|----------|
| `allow_failure: true` | Se Flake8 trova errori, il job risulta "warning" (arancione) ma la pipeline continua. Utile perché il codebase legacy ha molti warning che richiederebbero troppo tempo per fixare. |

**Tipici errori trovati da Flake8**:
- `F401`: Import non utilizzato
- `F841`: Variabile assegnata ma mai usata
- `E501`: Riga troppo lunga
- `E302`: Due righe vuote richieste tra funzioni

---

#### 🔒 Security Scan (Safety)

**Scopo**: Controllare se le dipendenze Python hanno vulnerabilità di sicurezza note (CVE). Importante per non deployare codice con falle conosciute.

```yaml
security_dependencies:
  stage: security
  script:
    - pip install safety
    - safety check --file requirements.txt --full-report
  allow_failure: true  # Warning only
```

**Analisi script**:

| Comando | Cosa Fa |
|---------|----------|
| `pip install safety` | Installa Safety, tool che confronta le versioni delle dipendenze con un database di vulnerabilità note. |
| `safety check --file requirements.txt --full-report` | Legge `requirements.txt`, estrae nome e versione di ogni pacchetto, e cerca nel database CVE. `--full-report` mostra dettagli completi di ogni vulnerabilità trovata (descrizione, severity, fix suggerito). |

**Analisi keywords**:

| Keyword | Cosa Fa |
|---------|----------|
| `allow_failure: true` | Le vulnerabilità potrebbero non avere fix disponibili, o potremmo non poter aggiornare subito. Il job avvisa ma non blocca. |

**Output tipico di Safety**:
```
+==============================================================================+
| REPORT                                                                        |
+==============================================================================+
| package: django                                                               |
| installed: 4.0                                                                |
| affected: <4.0.6                                                              |
| CVE: CVE-2022-34265                                                           |
| severity: high                                                                |
| description: SQL injection in Trunc and Extract database functions            |
+==============================================================================+
```

---

## Problemi Riscontrati e Soluzioni

### 🔴 Problema 1: MySQL in CI Troppo Complesso

**Causa**: Usare MySQL richiederebbe un container separato, aumentando complessità e tempo.

**Soluzione**: SQLite in-memory per test CI:
```python
# settings.py
import sys
if 'test' in sys.argv:
    DATABASES['default'] = {
        'ENGINE': 'django.db.backends.sqlite3',
        'NAME': ':memory:',
    }
```

---

### 🔴 Problema 2: Black Fallisce su File Non Formattati

**Causa**: ~30 file nel codebase non erano formattati secondo Black.

**Soluzione**: Pre-commit hooks che formattano automaticamente prima del commit. La CI verifica ma trova sempre codice già formattato.

---

### 🔴 Problema 3: Flake8 Troppi Warning

**Causa**: ~20-30 warning per import inutilizzati, variabili non usate, ecc.

**Decisione**: `allow_failure: true` - Pipeline verde per progredire, warning visibili per future ottimizzazioni.

---

### 🔴 Problema 4: Type Checking (Mypy) Non Praticabile

**Causa**: Codebase senza type hints, richiederebbe tipizzare ~50+ funzioni.

**Decisione**: SCARTATO - Effort/ROI non giustificato per progetto didattico. Type hints aggiunti gradualmente in codice nuovo.

---

## Risultato Fase 3

✅ **Pipeline CI funzionante** con:
- Build verification
- Test automatici + coverage 93%
- Format check (Black)
- Linting (Flake8) - warning only
- Security scanning (Safety) - warning only

✅ **Developer Experience migliorata**:
- Pre-commit formatta codice automaticamente
- Badge README mostrano stato real-time
- Report scaricabili dagli artifacts

| Stage | Job | Durata | Comportamento |
|-------|-----|--------|---------------|
| Build | `build_check` | ~20s | ❌ Blocca |
| Test | `test_django` | ~30s | ❌ Blocca |
| Test | `format_check` | ~10s | ❌ Blocca |
| Test | `lint_flake8` | ~5s | ⚠️ Warning |
| Security | `security_dependencies` | ~15s | ⚠️ Warning |

**Tempo totale pipeline**: ~1m 20s

---

# PARTE 5: Architettura Finale e Workflow

## Architettura Sistema

```mermaid
flowchart TB
    subgraph Host["💻 WINDOWS HOST - Docker Desktop"]
        Browser["🌐 Browser<br/>localhost:8000"]
        Code["📁 Codice Sorgente<br/>C:\\Users\\...\\cloudedgecomputing"]
        
        subgraph DockerEnv["🐳 Docker Environment"]
            subgraph Network["🌐 Network: cloudedgecomputing_default"]
                subgraph WebContainer["🟢 Container: newspaper_web"]
                    Django["🐍 Django 4.0"]
                    uWSGI["⚙️ uWSGI"]
                    AppPort["📡 Port 8000"]
                end
                
                subgraph DBContainer["🔵 Container: newspaper_db"]
                    MySQL["🗄️ MySQL 8.0"]
                    DBPort["📡 Port 3306"]
                end
            end
            
            subgraph Storage["💾 Persistent Storage"]
                Volume[("📦 Volume<br/>mysql_data")]
                BindMount["🔗 Bind Mount<br/>.:/app"]
            end
        end
    end
    
    Browser -->|"HTTP Request<br/>:8000 → :8000"| AppPort
    AppPort --> uWSGI
    uWSGI --> Django
    Django -->|"TCP/IP<br/>db:3306"| DBPort
    DBPort --> MySQL
    
    MySQL ---|"Dati persistenti"| Volume
    Code ---|"Sync bidirezionale"| BindMount
    BindMount ---|"Montato in /app"| Django

```

**Legenda**:
- 🟢 **Container web**: Applicazione Django servita da uWSGI
- 🔵 **Container db**: Database MySQL per persistenza dati
- 🌐 **Network**: Rete virtuale Docker per comunicazione inter-container
- 💾 **Volume**: Storage persistente per dati MySQL (sopravvive a restart)
- 🔗 **Bind Mount**: Sincronizzazione codice host ↔ container (sviluppo live)

---

## Workflow Development

### Opzione A: Development Locale (Windows + SQLite)

```bash
# Setup iniziale
python -m venv venv
venv\Scripts\activate
pip install -r requirements.txt  # Con mysqlclient commentato

# Workflow quotidiano
python manage.py runserver
# Browser: http://localhost:8000
```

**Quando usare**: Sviluppo veloce, modifiche piccole, test immediati.

---

### Opzione B: Docker Production-like (Linux + MySQL)

```bash
# Prima volta: build immagini
docker-compose build

# Avvio ambiente completo
docker-compose up

# Browser: http://localhost:8000
# Django connesso a MySQL in container

# Fermare
docker-compose down

# Fermare E cancellare dati database
docker-compose down -v
```

**Quando usare**: Test con MySQL, verifica migrazioni, simulare production.

---

## Workflow CI/CD

```mermaid
flowchart TD
    A[👨‍💻 Sviluppatore] -->|git commit| B[🪝 Pre-commit Hook]
    B -->|Black formatta| C[📤 git push]
    C -->|Trigger| D[🚀 GitLab Pipeline]
    
    D --> E[📦 Build Check]
    E --> F[🧪 Test + Coverage]
    F --> G[⬛ Format Check]
    G --> H[📏 Lint]
    H --> I[🔒 Security Scan]
    
    I -->|✅ Pass| J[🎉 Pipeline Verde]
    I -->|❌ Fail| K[📧 Notifica Errore]
    
    J --> L[📊 Artifacts<br/>Coverage Report<br/>Safety Report]
```

---

## Prossimi Passi (Fase 4: CD)

- [ ] Setup GitLab Container Registry
- [ ] Automatizzare build immagine Docker
- [ ] Deploy automatico su ambiente staging
- [ ] (Opzionale) Deploy production con approval manuale

---

# PARTE 6: Comandi Utili

## Docker & Docker Compose

```bash
# Build immagini
docker-compose build

# Build forzando no cache
docker-compose build --no-cache

# Avvio (foreground, vedi log)
docker-compose up

# Avvio (background, detached)
docker-compose up -d

# Stop container (dati persistono)
docker-compose down

# Stop + cancella volumi (dati persi!)
docker-compose down -v

# Restart singolo servizio
docker-compose restart web

# Vedere log
docker-compose logs web
docker-compose logs -f web  # Follow mode
```

---

## Debug e Ispezione

```bash
# Lista container attivi
docker ps

# Entrare in container con shell
docker exec -it newspaper_web bash
docker exec -it newspaper_db bash

# Vedere variabili d'ambiente
docker exec newspaper_web env | grep MYSQL

# Verificare volumi
docker volume ls
docker volume inspect cloudedgecomputing_mysql_data

# Vedere network
docker network ls
docker network inspect cloudedgecomputing_default
```

---

## Django in Container

```bash
# Migrazioni
docker-compose exec web python manage.py makemigrations
docker-compose exec web python manage.py migrate

# Creare superuser
docker-compose exec web python manage.py createsuperuser

# Shell Django
docker-compose exec web python manage.py shell

# Test
docker-compose exec web python manage.py test accounts articles pages
```

---

## Git & Pre-commit

```bash
# Setup pre-commit
pip install pre-commit
pre-commit install

# Eseguire manualmente su tutti i file
pre-commit run --all-files

# Skip pre-commit per commit urgente
git commit --no-verify -m "hotfix"
```

---

## Pulizia Sistema

```bash
# Rimuovi container fermi
docker container prune

# Rimuovi immagini inutilizzate
docker image prune

# Rimuovi volumi non usati
docker volume prune

# Pulizia completa (ATTENZIONE!)
docker system prune -a --volumes
```

---

**Fine documentazione** - Ultimo aggiornamento: 25 Gennaio 2026
