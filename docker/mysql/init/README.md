# MySQL bootstrap scripts

Any `.sql` or `.sh` file in this directory runs automatically the first
time the MySQL container starts. The legacy schema dump lives here as
`bitzee.sql`, so the database is seeded on container boot. Drop extra
seed files alongside it if you need additional fixtures.

