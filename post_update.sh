#! /bin/bash

mode="dev"
if [[ -n "$1" ]]
then
   mode=$1
fi

if [ $mode = "prod" ]
then
  chmod a-x reset_db.sh
  php app/console assets:install --symlink
  php app/console cache:clear --env=prod
  php app/console assetic:dump --env=prod
elif [ $mode = "dev" ]
then
  php app/console assets:install --symlink
  php app/console cache:clear --env=dev
  php app/console assetic:dump --env=dev
fi
