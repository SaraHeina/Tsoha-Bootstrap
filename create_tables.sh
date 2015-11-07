#!/bin/bash

source config/environment.sh

echo "Luodaan tietokantataulut..."

ssh kauvo@users.cs.helsinki.fi "
cd htdocs/muistilista/sql
cat drop_tables.sql create_tables.sql | psql -1 -f -
exit"

echo "Valmis!"
