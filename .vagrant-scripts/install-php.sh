#!/usr/bin/env bash

exists()
{
  command -v "$1" >/dev/null 2>&1
}

install_php ()
{
  apt-get -y update >> /dev/null

  add-apt-repository ppa:ondrej/php -y >> /dev/null

  apt-get update >> /dev/null

  apt-get install -y php7.2 >> /dev/null

  apt-get install -y php7.2-curl php7.2-dev php7.2-gd php7.2-mbstring php7.2-zip php7.2-xml >> /dev/null
}

install_composer ()
{
  echo "Installing Composer"

  EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  ACTUAL_SIGNATURE="$(php -r "echo hash_file('SHA384', 'composer-setup.php');")"

  if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]
  then
      >&2 echo 'ERROR: Invalid installer signature'
      rm composer-setup.php
      exit 1
  fi

  php composer-setup.php
  RESULT=$?
  rm composer-setup.php

  mv composer.phar /usr/local/bin/composer
  echo "Moved composer.phar => /usr/local/bin/composer"

  exit $ESULT
}

if exists php; then
  echo "PHP exists"

  install_composer

  move_composer
else
  install_php

  install_composer

  echo "PHP installed"
fi


