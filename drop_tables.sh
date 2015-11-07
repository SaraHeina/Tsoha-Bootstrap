#!/bin/bash

source config/environment.sh

echo "Poistetaan tietokantataulut..."

ssh kauvo@users.cs.helsinki.fi "
cd htdocs/muistilista/sql
psql < drop_tables.sql
exit"

echo "Valmis!"
