# Dev Experiments

Personal sandbox for experimenting with new technologies, frameworks, and programming concepts.

## Description

This repository is my practical learning space - a collection of projects and experiments built to explore different technologies, test new ideas, and learn by doing. You won't find production-ready projects or complete applications meant for real-world use here, but rather technical proofs, exercises, and prototypes created with the goal of understanding how things work under the hood.

Each project represents a learning opportunity: it could be a course I followed, a framework to explore, an algorithmic problem to solve, or simply a technical curiosity to satisfy.

**Note**: These projects are intentionally kept separate from my main portfolio. They are works-in-progress, experiments, and trials that document my continuous learning journey, not polished showcases of my skills.

## Projects

- **devops-capstone-project** - IBM DevOps capstone project with CI/CD pipeline, Kubernetes deployment, and Tekton workflows, done during my IBM DevOps and Software Engineering Professional Certificate on Coursera
- **distributed_algorithms_exercises** - University exercises on distributed algorithms: TCP socket programming and RMI
- **matrix-next-theme** - Experiment to create a Matrix-inspired visual theme using Next.js and Tailwind CSS
- **mcp-first-try** - First test with Model Context Protocol (MCP)
- **next-simple-blog** - Minimalist blog built with Next.js to learn routing, database integration, and authentication
- **quasar-demo** - Quasar framework demo to explore Vue.js and component-based development
- **react-app** - React playground to experiment with hooks, state management, and component patterns
- **smt** - Automated reasoning and SMT solving exercises with Z3 solver

## How did I manage to maintain all the history of each projects separated in each branch?

### Overview

This monorepo uses orphan branches and subfolder restructuring to import projects while preserving their complete Git history. Each project maintains its full commit history in a dedicated subfolder, with optional import branches serving as navigable historical archives.

### Quick Reference

For experienced users, here's the complete command sequence:

```bash
# Setup
git checkout --orphan import/PROJECT_NAME
git rm -rf .

# Import history
git remote add source-PROJECT ../PATH_TO_PROJECT
git pull source-PROJECT main --allow-unrelated-histories
git remote remove source-PROJECT

# Restructure
mkdir -p PROJECT_FOLDER
ls -A | grep -vE "^\.git$|^PROJECT_FOLDER$" | xargs -I {} git mv {} PROJECT_FOLDER/
git commit -m "refactor(PROJECT): move project to subfolder"

# Integrate
git checkout main
git merge import/PROJECT_NAME --allow-unrelated-histories -m "feat: import PROJECT_NAME"
git branch -d import/PROJECT_NAME  # Optional
git push origin --all
```

### Detailed Import Process

#### Phase 1: Branch Setup and Isolation

**Step 1:** Ensure you have a local copy of the project repository or its GitHub URL.

**Step 2:** Navigate to the root of the dev-experiments repository.

**Step 3:** Create a new orphan branch for the import.

```bash
git checkout --orphan import/old-project-alpha
```

> **Note:** An orphan branch has no parent commits and shares no history with other branches.

**Step 4:** Clean the staging area to start with an empty branch.

```bash
git rm -rf .
```

#### Phase 2: History Import

**Step 5:** Add the old project repository as a remote source.

```bash
git remote add source-alpha ../old-project-alpha
```

**Step 6:** Fetch all commits and history from the old project.

```bash
git pull source-alpha main --allow-unrelated-histories
```

> **Note:** The `--allow-unrelated-histories` flag is required because the repositories have no common ancestor.

**Step 7:** Remove the temporary remote link.

```bash
git remote remove source-alpha
```

At this point, the import branch contains all files and history from the old project at the repository root.

#### Phase 3: Restructuring

**Step 8:** Create the destination subfolder.

```bash
mkdir -p old-project-alpha-folder
```

**Step 9:** Move all files into the subfolder (excluding .git and the folder itself).

```bash
ls -A | grep -vE "^\.git$|^old-project-alpha-folder$" | xargs -I {} git mv {} old-project-alpha-folder/
```

**Step 10:** Verify the restructuring.

```bash
ls -A
```

**Step 11:** Commit the restructuring changes.

```bash
git commit -m "refactor(alpha): move project to subfolder"
```

#### Phase 4: Integration and Cleanup

**Step 12:** Merge the import branch into main.

```bash
git checkout main
git merge import/old-project-alpha --allow-unrelated-histories -m "feat: import old-project-alpha"
```

> **Note:** Again, `--allow-unrelated-histories` is required due to the orphan branch structure.

**Step 13:** Optionally delete the import branch.

```bash
git branch -d import/old-project-alpha
```

> **Warning:** Keep the import branch if you want it as a separate navigable historical archive. Delete it only if you don't need direct access to the pre-restructured history.

**Step 14:** Push all branches to remote.

```bash
git push origin --all
```

---

*Each project has its own README with specific details about objectives, technologies used, and setup.*
