# Fajnovy sport

web in a monorepo.

## Structure

- \_static: static website template on Vite

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

## PHPStan analyze on local

Build docker run: `docker build -t phpstan .`
Run PHP test: `docker run --rm -it -v c:/Projects/ovanet/vite/wp:/app/wp phpstan` # need change your path
