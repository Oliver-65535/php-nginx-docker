#!/bin/bash

SERVER_IP=$SERVER_IP
SERVER_FOLDER="dequity.io"

# npm install --force
# npm run build
apt-get update -y
apt-get -y install rsync

echo "Deploying to ${SERVER_FOLDER}"
ssh gitlab@${SERVER_IP} "rm -rf /var/www/${SERVER_FOLDER}/*"



 rsync -avzh ./ gitlab@${SERVER_IP}:/var/www/${SERVER_FOLDER}/

echo "Finished copying the build files"
