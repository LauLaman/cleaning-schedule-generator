# Welcome!

This Project has been set up with DDD in mind: 
- All buisiness logic can be found in `<domain>/Domain`
- All Framework specific implementation can be found in `<domain>/Infrastructure`

### Getting started
1. Clone the repository
2. Configgure the `DATABASE_URL` in your `.env.local`
3. Run `make setup-fresh` to get started, this will install all dependencies, run database migrations,  load datafixtures and generate holidays for 2020
4. run `bin/console timetable:export` to export (currenty WIP)

If you want to generate holidays for a year simply run `bin/console generate:holidays --year=2021 --country=NLD` currently only NLD is supported


#### Remarks
- This Project works with the [symfony messenger component](https://symfony.com/doc/current/components/messenger.html). this might require you to run the worker: `bin/console messenger:consume async -vv`
- Migrations can be found in `database/Migrations`
- DataFixtures can be found in `database/DataFixtures`
