# How to collaborate using Git and Github

## Prerequisite

Make sure you have `git` to run in the command line.

Download **Git** [here](https://git-scm.com/downloads), choose the correct version, and follow the instruction

## Join the team

1. Locate to the xampp installation directory

2. Open the command line at the `htdocs` directory

3. Run this command below

    ```bash
    git clone https://github.com/viethung7899/library-database
    ```

4. Open the newly `library-database` directory with your preferred IDE.

    [VS Code](https://code.visualstudio.com/) is my favorite IDE.

## Local git repository workflow

**Discalmer**

- The `main` branch is the most important branch and should be bug-free. Any changes to this branch must be reviewed before commiting. Do **NOT** commit any *code changes* to this branch without any review.
- Always saving changes to the branch before switching to another branch

### **Before making changes**

Get the newest update from the `main` branch remote repository by running.

```bash
git pull
```

### How to collaborate

1. Make new branches

    ```bash
    git checkout -b [your_branch_name]
    ```

2. Make changes to your branch (add/edit/remove files)

3. Adding changes

    ```bash
    git add .
    ```

4. Commiting (saving) changes

    ```bash
    git commit -m "[Your message here]"
    ```

5. Repeat step 2~4 until you're satisfied with your code

6. Push to the remote repository by running

    ```bash
    git push origin [your_branch_name]
    ```

7. Visit the repository and submit the pull request on Github

8. Review, discuss, and commit changes.

## Resources

- [Git for beginner](https://www.youtube.com/playlist?list=PL4cUxeGkcC9goXbgTDQ0n_4TBzOO0ocPR)

- [The Ultimate Github Collaboration Guide](https://medium.com/@jonathanmines/the-ultimate-github-collaboration-guide-df816e98fb67). View step 3 and 4.
