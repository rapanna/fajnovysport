# Fajnovy sport

web in a monorepo.

## Structure

- `\_static`: static website template on Vite
- `wp`: Wordpress template PHP folder

## Dependencies

### Development

- Node.js v22
- NPM v11
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

## WP for dev

Run `task wp:start`

Open in browser: `http://localhost:8080/`

Stop `task wp:stop`

Open container for debug: `task wp:exec`

## Install composer plugins

Open container: `docker exec -it wordpress bash`

In folder `/var/www/html/wp-content/themes/fajnovysport-new/` run: `composer install`

## Export / import DB

Export: `docker exec -i db mariadb-dump -u root -ppassword wordpress > c:/Projects/ovanet/vite/wp-dev/dump/dumpDefault.sql`

Import: `docker exec -i db mariadb -u root -ppassword wordpress < c:/Projects/ovanet/vite/wp-dev/dump/sport.sql`

`docker cp db:/tmp/dump.sql $(pwd)/dump2.sql`

## Tip for local developing

Update npm version: `npx npm install -g npm`
