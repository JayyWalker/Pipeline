#!/usr/bin/env bash

exists()
{
  command -v "$1" >/dev/null 2>&1
}

if exists zsh; then
  echo "Zsh exists"
else
  apt-get -y update >> /dev/null
  apt-get -y install zsh >> /dev/null
  echo "zsh installed"
fi
