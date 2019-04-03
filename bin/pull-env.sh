#!/bin/bash

# Pull .env in production remote server to .env.production in local
scp lanparty_181670:~/registre.lanparty.iesebre.com/.env .env.production
