"""
Ex4

Classical lupo, capra, cavoli problem (see: https://it.wikipedia.org/wiki/Problema_del_lupo,_della_capra_e_dei_cavoli)

Use SMT-based Model checking to find a successfull strategy.

"""


from z3 import *

def printModel(m):
    m_sorted = sorted ([(d, m[d]) for d in m], key = lambda x: str(x[0]))
    print(*m_sorted,sep='\n')

def printSolution(model, max_step):
    print("\n" + "="*60)
    print("SOLUZIONE TROVATA!")
    print("="*60)
    
    # Trova l'ultimo step con tutti sull'altra riva
    last_step = 0
    for i in range(max_step):
        try:
            if (is_true(model[lupo[i]]) and is_true(model[capra[i]]) and 
                is_true(model[cavolo[i]]) and is_true(model[contadino[i]])):
                last_step = i
                break
        except:
            break
    
    print(f"\nSoluzione in {last_step} passi:\n")
    
    for i in range(last_step + 1):
        # Ottieni lo stato corrente
        l = is_true(model[lupo[i]])
        g = is_true(model[capra[i]])
        c = is_true(model[cavolo[i]])
        f = is_true(model[contadino[i]])
        
        # Stampa lo stato
        left = []
        right = []
        
        if not l: left.append("🐺Lupo")
        else: right.append("🐺Lupo")
        
        if not g: left.append("🐐Capra")
        else: right.append("🐐Capra")
        
        if not c: left.append("🥬Cavolo")
        else: right.append("🥬Cavolo")
        
        if not f: left.append("👨Contadino")
        else: right.append("👨Contadino")
        
        left_str = ", ".join(left) if left else "---"
        right_str = ", ".join(right) if right else "---"
        
        print(f"Step {i}:")
        print(f"  Riva sinistra:  {left_str}")
        print(f"  Riva destra:    {right_str}")
        
        # Stampa l'azione eseguita
        if i < last_step:
            try:
                azione = model[action[i+1]]
                print(f"  → Azione: {azione}")
            except:
                pass
        print()

Max_Step = 30

# True iff lupo is on the other side of the river
lupo = [Bool("lupo_%s" % (i)) for i in range(Max_Step)]
capra = [Bool("capra_%s" % (i)) for i in range(Max_Step)]
cavolo = [Bool("cavolo_%s" % (i)) for i in range(Max_Step)]
contadino = [Bool("contadino_%s" % (i)) for i in range(Max_Step)]

s = Solver()

Action = Datatype('Method')
Action.declare('move_lupo')
Action.declare('move_capra')
Action.declare('move_cavolo')
Action.declare('move_contadino')
Action = Action.create()

action = [Const("f_%s" % (i), Action) for i in range(Max_Step+1)]

initial_state = And(
    Not(lupo[0]),   # Lupo is not on the other side
    Not(capra[0]),   # capra is not on the other side
    Not(cavolo[0]),   # cavolo is not on the other side
    Not(contadino[0])  # contadino is not on the other side

)

s.add(initial_state)

def no_changes(lupo_now, lupo_next, 
               capra_now, capra_next,
               cavolo_now, cavolo_next,
               contadino_now, contadino_next):
    return And(     lupo_next == lupo_now, 
                    capra_next == capra_now,
                    cavolo_next == cavolo_now,
                    contadino_next == contadino_now
                    )

def move_lupo(lupo_now, lupo_next, 
               capra_now, capra_next,
               cavolo_now, cavolo_next,
               contadino_now, contadino_next):
    return If(
        # Condizione: il contadino è dalla stessa parte del lupo?
        contadino_now == lupo_now,
        
        # SE SÌ: l'azione ha successo
        And(
            lupo_next == Not(lupo_now),           # il lupo cambia riva
            contadino_next == Not(contadino_now), # il contadino cambia riva
            capra_next == capra_now,              # la capra non si muove
            cavolo_next == cavolo_now             # il cavolo non si muove
        ),
        
        # SE NO: l'azione fallisce, nessuno si muove
        no_changes(lupo_now, lupo_next, capra_now, capra_next,
                   cavolo_now, cavolo_next, contadino_now, contadino_next)
    )

def move_contadino(lupo_now, lupo_next, 
               capra_now, capra_next,
               cavolo_now, cavolo_next,
               contadino_now, contadino_next):
    return If(
        # Condizione: il contadino può sempre muoversi da solo
        True,        
        # SE SÌ: l'azione ha successo
        And(
            lupo_next == lupo_now,           # il lupo cambia riva
            contadino_next == Not(contadino_now), # il contadino cambia riva
            capra_next == capra_now,              # la capra non si muove
            cavolo_next == cavolo_now             # il cavolo non si muove
        ),
        
        # SE NO: l'azione fallisce, nessuno si muove
        no_changes(lupo_now, lupo_next, capra_now, capra_next,
                   cavolo_now, cavolo_next, contadino_now, contadino_next)
    )

def move_capra(lupo_now, lupo_next, 
               capra_now, capra_next,
               cavolo_now, cavolo_next,
               contadino_now, contadino_next):
    return If(
        # Condizione: il contadino è dalla stessa parte del lupo?
        contadino_now == capra_now,
        
        # SE SÌ: l'azione ha successo
        And(
            capra_next == Not(capra_now),           #  la capra cambia riva
            contadino_next == Not(contadino_now), # il contadino cambia riva
            lupo_next == lupo_now,              # il lupo non si muove
            cavolo_next == cavolo_now             # il cavolo non si muove
        ),
        
        # SE NO: l'azione fallisce, nessuno si muove
        no_changes(lupo_now, lupo_next, capra_now, capra_next,
                   cavolo_now, cavolo_next, contadino_now, contadino_next)
    )

def move_cavoli(lupo_now, lupo_next, 
               capra_now, capra_next,
               cavolo_now, cavolo_next,
               contadino_now, contadino_next):
    return If(
        # Condizione: il contadino è dalla stessa parte del lupo?
        contadino_now == cavolo_now,
        
        # SE SÌ: l'azione ha successo
        And(
            lupo_next == lupo_now,           # il lupo non si muove
            contadino_next == Not(contadino_now), # il contadino cambia riva
            capra_next == capra_now,              # la capra non si muove
            cavolo_next == Not(cavolo_now)             # il cavolo cambia riva
        ),
        
        # SE NO: l'azione fallisce, nessuno si muove
        no_changes(lupo_now, lupo_next, capra_now, capra_next,
                   cavolo_now, cavolo_next, contadino_now, contadino_next)
    )



for i in range(Max_Step-1):
    
        # Lupo cannot stay with capra unless contadino is present
    # NON può succedere che lupo e capra siano insieme senza il contadino
    s.add(Not(And(lupo[i] == capra[i], lupo[i] != contadino[i])))    # Capra cannot stay with cavoli unless contadino is present

    s.add(Not(And(cavolo[i] == capra[i], cavolo[i] != contadino[i])))


    next_state = Or(
    And(action[i] == Action.move_lupo, 
        move_lupo(lupo[i], lupo[i+1], capra[i], capra[i+1], 
                  cavolo[i], cavolo[i+1], contadino[i], contadino[i+1])),
    
    And(action[i] == Action.move_capra, 
        move_capra(lupo[i], lupo[i+1], capra[i], capra[i+1], 
                   cavolo[i], cavolo[i+1], contadino[i], contadino[i+1])),
    
    And(action[i] == Action.move_cavolo, 
        move_cavoli(lupo[i], lupo[i+1], capra[i], capra[i+1], 
                    cavolo[i], cavolo[i+1], contadino[i], contadino[i+1])),
    
    And(action[i] == Action.move_contadino, 
        move_contadino(lupo[i], lupo[i+1], capra[i], capra[i+1], 
                       cavolo[i], cavolo[i+1], contadino[i], contadino[i+1]))
    )
    s.add(next_state)
    
    # Property to verify
    res = s.check(And(lupo[i+1], capra[i+1], cavolo[i+1], contadino[i+1]))     # lupo, capra, and cavoli are all on the other side
    if res == sat:
        model = s.model()
        printSolution(model, Max_Step)
        break
    else:
        print(f"Step {i}: Nessuna soluzione ancora...")