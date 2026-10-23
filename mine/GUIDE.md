# Keep receiving updates from Bitbucket but never push there

If you want to push your work to GitHub or your own Bitbucket repository, you can use a separate remote.

```
# Clone the original
git clone https://bitbucket.org/WORKSPACE/REPOSITORY.git
cd REPOSITORY

# Rename the original remote so it's clearly identified
git remote rename origin upstream

# Add your own repository
git remote add origin https://github.com/YOUR_USERNAME/REPOSITORY.git
```

Now check:

```
git remote -v
```

You'll see two remotes:

- `origin` → your own repository
- `upstream` → the original Bitbucket repository

You can push to your own repository with:

```
git push -u origin main
```

Replace `main` with your actual branch name if needed.

Important: Renaming the remote doesn't prevent you from accidentally pushing to `upstream`. If you want a stronger safeguard, remove its push URL:

```
git remote set-url --push upstream DISABLED
```

This prevents ordinary pushes through that remote, while retaining its fetch URL for pulling updates.

On VSCode, check the branch that appears on the bottom bar

---

git remote add upstream https://bitbucket.org/rgcenteno/ud3-26-27.git
git remote set-url --push upstream DISABLED
git remote -v

---

obtener cambios:
git merge upstream/main
and push the merged

--- 23 oct

git pull --no-rebase upstream main

Esto utiliza merge para integrar los cambios de bitbucket en tu rama local.

- Conserva tus commits locales.
- Incorpora los commits de upstream/main.
- Si hay conflictos, tendrás que resolverlos antes de terminar la integración.

Si quieres utilizar merge por defecto en este repositorio:
git config pull.rebase false

Después, podrás ejecutar normalmente:
git pull upstream main

Esta configuración solo afecta al repositorio actual.
