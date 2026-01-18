from z3 import *

def printModel(m):
    m_sorted = sorted ([(d, m[d]) for d in m], key = lambda x: str(x[0]))
    print(*m_sorted,sep='\n')

#m = 3, 5, 4
#m = 2, 4, 3

Max_Step = 30

# True iff lupo is on the other side of the river
lupo = [Bool("lupo_%s" % (i)) for i in range(Max_Step)]
capra = [Bool("capra_%s" % (i)) for i in range(Max_Step)]
cavoli = [Bool("cavoli_%s" % (i)) for i in range(Max_Step)]
contadino = [Bool("contadino_%s" % (i)) for i in range(Max_Step)]

s = Solver()

Action = Datatype('Method')
Action.declare('move_lupo')
Action.declare('move_capra')
Action.declare('move_cavoli')
Action.declare('move_contadino')
Action = Action.create()

action = [Const("f_%s" % (i), Action) for i in range(Max_Step+1)]

initial_state = And(
    Not(lupo[0]),
    Not(capra[0]),
    Not(cavoli[0]),
    Not(contadino[0])
)

s.add(initial_state)

def no_changes(lupo_now, lupo_next, capra_now, capra_next, cavoli_now, cavoli_next, contadino_now, contadino_next):
    return And(     lupo_next == lupo_now, 
                    contadino_next == contadino_now,
                    capra_next == capra_now,
                    cavoli_next == cavoli_now
                    )

def move_lupo(lupo_now, lupo_next, capra_now, capra_next, cavoli_now, cavoli_next, contadino_now, contadino_next):
    return If(lupo_now == contadino_now,   # check lupo is on the same side of contadino
               # if yes, the lupo can be moved
               And( lupo_next == Not(lupo_now) , 
                    contadino_next == Not(contadino_now),
                    capra_next == capra_now,
                    cavoli_next == cavoli_now
                    ),
                # if no, the action fails and no-one moves 
                no_changes(lupo_now, lupo_next, capra_now, capra_next, cavoli_now, cavoli_next, contadino_now, contadino_next)
                )


def move_capra(lupo_now, lupo_next, capra_now, capra_next, cavoli_now, cavoli_next, contadino_now, contadino_next):
    return If(capra_now == contadino_now,   
               And( capra_next == Not(capra_now) , 
                    contadino_next == Not(contadino_now),
                    lupo_next == lupo_now,
                    cavoli_next == cavoli_now
                    ),
                no_changes(lupo_now, lupo_next, capra_now, capra_next, cavoli_now, cavoli_next, contadino_now, contadino_next)
                )



def move_cavoli(lupo_now, lupo_next, capra_now, capra_next, cavoli_now, cavoli_next, contadino_now, contadino_next):
    return If(cavoli_now == contadino_now,   
               And( cavoli_next == Not(cavoli_now) , 
                    contadino_next == Not(contadino_now),
                    lupo_next == lupo_now,
                    capra_next == capra_now
                    ),
                no_changes(lupo_now, lupo_next, capra_now, capra_next, cavoli_now, cavoli_next, contadino_now, contadino_next)
                )



def move_contadino(lupo_now, lupo_next, capra_now, capra_next, cavoli_now, cavoli_next, contadino_now, contadino_next):
    return And( contadino_next == Not(contadino_now) , 
                    cavoli_next == cavoli_now,
                    lupo_next == lupo_now,
                    capra_next == capra_now
                    )

for i in range(1, Max_Step-1):
    next_state = Or(
        And(action[i] == Action.move_lupo , move_lupo(lupo[i-1], lupo[i], capra[i-1], capra[i], cavoli[i-1], cavoli[i], contadino[i-1], contadino[i])),
        And(action[i] == Action.move_capra , move_capra(lupo[i-1], lupo[i], capra[i-1], capra[i], cavoli[i-1], cavoli[i], contadino[i-1], contadino[i])),
        And(action[i] == Action.move_cavoli , move_cavoli(lupo[i-1], lupo[i], capra[i-1], capra[i], cavoli[i-1], cavoli[i], contadino[i-1], contadino[i])),
        And(action[i] == Action.move_contadino , move_contadino(lupo[i-1], lupo[i], capra[i-1], capra[i], cavoli[i-1], cavoli[i], contadino[i-1], contadino[i])),
    )
    s.add(next_state)
    s.add(Implies(lupo[i] == capra[i], contadino[i] == lupo[i]))
    s.add(Implies(cavoli[i] == capra[i], contadino[i] == cavoli[i]))
    #s.add(Xor(cavoli[i], capra[i]))

    # Property to verify
    res = s.check(And(lupo[i], capra[i], cavoli[i]) )
    print(f"\nStep {i}: ",res)
    if res == sat:
        model = s.model()
        printModel(model)
        break