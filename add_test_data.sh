#!/bin/bash

source config/environment.sh

echo "Lisätään testidata..."

ssh kauvo@users.cs.helsinki.fi "
cd htdocs/muistilista/sql
psql < add_test_data.sql
exit"

echo "Valmis!"
