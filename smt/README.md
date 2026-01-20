# Automated Reasoning and SMT Solving

![Python](https://img.shields.io/badge/Python-3776AB?style=flat&logo=python&logoColor=white)
![Z3](https://img.shields.io/badge/Z3-Solver-blue)

Automated reasoning and SMT (Satisfiability Modulo Theories) solving exercises using Microsoft's Z3 solver.
I did this exercise as part of a seminar during my "Methodology for the cycle of software life" course at the University of Modena and Reggio Emilia.
## 🎯 Objective

Explore automated reasoning and SMT solvers to solve logical and verification problems:
- Understand the difference between symbolic and sub-symbolic AI
- Learn to model problems with logical constraints
- Use Z3 for theorem proving and model checking
- Compare algorithmic approaches, SMT solving, and LLMs

## 📖 Introduction

Symbolic AI is an approach to Artificial Intelligence that uses deductive reasoning to produce exact and explainable results to well-defined problems, compared to sub-symbolic methods (e.g. machine learning, deep NNs, LLMs, etc.), which use statistical learning to tackle a wide variety of tasks (possibly vaguely defined) to produce plausible answers (which can however be incorrect and that are usually not explainable). Integration between symbolic and sub-symbolic methods is a hot topic in AI (neuro-symbolic AI).

Automatic Theorem Provers and SMT solvers are tools that can be used to reason about and rigorously solve different kinds of problems, involving arithmetic, arrays, bit vectors, etc. They are used in industrial applications for several tasks, such as program verification, planning, and testing. 

In this lesson, we introduce z3, an efficient and user-friendly SMT solver developed by Microsoft. We will compare it to both user-written algorithms and LLMs on a simple task such as solving a Sudoku. We will also see how to use z3 to solve the Die Hard jug riddle (a model checking problem). 

Finally, we will give a few exercises to experiment with the tool.

## 🛠️ Tech Stack

- **Python 3.x** - Main language
- **Z3 Solver** - Microsoft's SMT solver
- **z3-solver (pip)** - Python bindings for Z3

## 💡 What I Learned

- Problem modeling with logical constraints
- SMT (Satisfiability Modulo Theories)
- Bounded Model Checking
- Difference between symbolic and sub-symbolic approaches
- Solving combinatorial problems (Sudoku)
- Model checking (Die Hard puzzle)
- Practical applications of theorem proving

## 🚀 Setup

### Prerequisites
- Python 3.8+
- pip

### Installation

```bash
# Install Z3 Python API
pip install z3-solver

# Or with requirements (if present)
pip install -r requirements.txt
```

### Running Examples

```bash
# Solve Sudoku with Z3
python sudoku.py

# Die Hard jug problem
python die_hard_problem.py

# Specific exercises
python exercises/Ex1_Arith.py
python exercises/Ex2_Fruit.py
python exercises/Ex3_Ferrando_case.py
python exercises/Ex4_River_crossing.py
```

## 📚 Useful Resources

- [z3Py Tutorial](https://ericpony.github.io/z3py-tutorial/guide-examples.htm)

## Content
- [Sudoku](sudoku.py)
- [Die hard problem](die_hard_problem.py)
- [Exercises](exercises/)
    - [Ex1 - Arithmetic](exercises/Ex1_Arith.py)
    - [Ex2 - Combinatorial](exercises/Ex2_Fruit.py)
    - [Ex3 - Deduction](exercises/Ex3_Pinna_case.py)
    - [Ex4 - Strategic](exercises/Ex4_River_crossing.py.py)

## References

- C. Barrett, R. Sebastiani, S. Seshia, C. Tinelli: [Satisfiability Modulo Theories](https://link.springer.com/chapter/10.1007/978-3-319-10575-8_11), 2018
- L. de Moura, N. Bjørner: [Z3: An Efficient SMT Solver](https://link.springer.com/chapter/10.1007/978-3-540-78800-3_24), 2008
- A. Biere, D. Kröning:  [SAT-Based Model Checking](https://link.springer.com/chapter/10.1007/978-3-319-10575-8_10), 2018
- A. Biere, M. Heule, H. Van Maaren, T. Walsh: [Handbook of Satisfiability](https://www.iospress.com/catalog/books/handbook-of-satisfiability-2), 2021
- J. Aldrich: [Lecture Notes on Satisfiability Modulo Theories](https://www.cs.cmu.edu/~aldrich/courses/17-355-19sp/notes/notes12-smt.pdf), 2019
- M. Fredrikson: [Lecture Notes on Bounded Model Checking](https://www.cs.cmu.edu/~15414/s22/lectures/17-bmc.pdf), 2022
