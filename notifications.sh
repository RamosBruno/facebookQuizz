#! /bin/bash

mode="dev"
if [[ -n "$1" ]]
then
   mode=$1
fi

if [ $mode = "prod" ]
then
   php app/console quizz:notification
fi