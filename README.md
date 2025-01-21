# Fajnovy sport

web in a monorepo.

## Structure

- `\_static`: static website template on Vite
- `wp`: Wordpress template PHP folder

## Dependencies

### Development

- Node.js v22
- NPM v10
- Task (taskfile.dev)
- Git

### Build and deployment

- ZIP
- standard unixy tools (bsdtar, coreutils), "Git Bash" from Git for Windows should work

## Quick start static website

```sh
npm install -g @go-task/cli
task install
task static:run
```

Open http://localhost:5173/ in the browser.

More info in separate README.md files. Run `task -l` to see what commands are available.

## PHPStan analyze on local without PHP

Build docker run: `docker build -t phpstan .`

Run PHP test: `docker run --rm -it -v c:/Projects/ovanet/vite/wp:/app/wp phpstan` # need change your path

## First install new comp

- install NVM - https://www.freecodecamp.org/news/node-version-manager-nvm-install-guide/
- add a path to windows - start -> Edit system environment variables (upravit proměnné prostředí systému) -> click environment variables (Proměnné prostředí) -> add to system environment -> click new -> NVM_HOME | C:\Users\panna\AppData\Roaming\nvm (own path)
- restart vscode, terminal, git-bash
- install node

```sh
nvm install 22.13.0
nvm use 22.13.0
```

- edit .bashrc

```sh
nano ~/.bashrc

- Add
# Starts ssh-agent if it is not already running
if [ -z "$SSH_AUTH_SOCK" ]; then
    eval "$(ssh-agent -s)"
    ssh-add /c/Users/panna/.ssh/key_rsa
fi
```

Setup git to LF cmd: `git config --global core.eol lf`
