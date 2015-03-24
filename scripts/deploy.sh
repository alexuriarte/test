#!/bin/bash
set -o errexit
set -o nounset

DEFAULT_APP_REPO=https://github.com/scalr-tutorials/autoscaling.git
DEFAULT_APP_BRANCH=master

: ${APP_REPO:="$DEFAULT_APP_REPO"}
: ${APP_BRANCH:="$DEFAULT_APP_BRANCH"}

# Install all dependencies
if [ -f /etc/debian_version ]; then
  apt-get update
  apt-get install -y git stress apache2 libapache2-mod-php5
  service apache2 restart
elif [ -f /etc/redhat-release ]; then
  yum -y install git stress httpd php
  service httpd restart
else
  echo "Unsupported OS"
  exit 1
fi

if [ -d "/var/www/html" ]; then
  DEFAULT_DEPLOY_PATH="/var/www/html"
else
  DEFAULT_DEPLOY_PATH="/var/www"
fi
: ${APP_DEPLOY_PATH:="$DEFAULT_DEPLOY_PATH"}

# Install or Update

if [ ! -d "$APP_DEPLOY_PATH/.git" ]; then
  mkdir -p "$APP_DEPLOY_PATH"
  rm -r "$APP_DEPLOY_PATH"
  git clone --branch "$APP_BRANCH" "$APP_REPO" "$APP_DEPLOY_PATH"
else
  cd "$APP_DEPLOY_PATH"
  git pull --force
  git checkout --force "$APP_BRANCH"
fi
