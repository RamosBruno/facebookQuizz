#! /bin/bash

mode="dev"
if [[ -n "$1" ]]
then
   mode=$1
fi

if [ $mode = "dev" ]
then
   php app/console doctrine:schema:drop --force
   php app/console doctrine:schema:update --force
   php app/console doctrine:fixtures:load -n --fixtures="src/AppBundle/DataFixtures/ORM/"
fi