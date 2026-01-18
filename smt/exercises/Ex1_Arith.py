from z3 import *


"""
Ex 1.1

Write a function that takes as input an integer n
and finds positive integers a, b such that a^2 - b = n.
"""

def diffOfSquares(n_input):
    s = Solver()
    n, a, b = Ints('n a b') # declare variables
    s.add(And(n == n_input,             # z3 variable equal to input variable   
              a > 0 ,                    # a positive
              b > 0 ,                    # b positive
              a**2 - b == n          # condition
              )
        )        
    if s.check() == sat:
        print("sat")
        print(s.model())
    else:
        print("unsat")
        
diffOfSquares(12345)


"""
Ex 1.2 

Write a function that takes as input an integer n
and finds distinct positive integers a, b, c such that a^2 + b^2 - c^2 = n.
"""

def sumDiffOfSquares(n_input):
    s= Solver()
    n,a,b,c = Ints('n a b c')
    s.add(And( n== n_input,
              a > 0,
              b > 0,
              c > 0,
              a**2 + b**2 - c**2 == n, ))
    if s.check() == sat:
        print("sat")
        print(s.model())
    else:
        print("unsat")

sumDiffOfSquares(12345)


"""
Ex 1.3

Write a function that takes as input a positive integer n
and checks whether n is a prime. 
If n is not a prime, the function should print some information 
that proves that n is not a prime.

"""

def isPrime(n_input):
    s = Solver()
    n,a,b = Ints('n a b')
    s.add(And( n== n_input,
              n > 1,
              Not(Exists([a,b], And(
                                a > 1,
                                b > 1,
                                a<n,
                                b<n,
                                n==a*b))))
)
    if s.check() == sat:
        print("sat")
        print(s.model())
    else:
        print("unsat")
    
isPrime(12345)



"""
Ex 1.4

Write a function that takes as input two positive integers n, m,
and checks whether a and b can be part of a Pythagorean triple.
"""

def arePartOfPythagorean(n_input, m_input):
    s = Solver()
    n,m,o = Ints('n m o')
    s.add(And( n== n_input,
              m== m_input,
              n > 0,
              m > 0,
              o > 0,
              Or(
                  n**2 + m**2 == o**2,
                  n**2 + o**2 == m**2,
                  m**2 + o**2 == n**2
              )
    ))
    if s.check() == sat:
        print("sat")
        print(s.model())
    else:
        print("unsat")
    

print ("Last one")
arePartOfPythagorean(12, 35) # expected: sat
arePartOfPythagorean(33, 65) # expected: sat
arePartOfPythagorean(89, 39) # expected: sat
arePartOfPythagorean(89, 139) # expected: unsat
arePartOfPythagorean(45, 824) # expected: unsat

