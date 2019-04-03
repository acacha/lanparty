#!/bin/bash

# Copy env.production to .env in remote production server
scp .env.production lanparty_181670:~/registre.lanparty.iesebre.com/.env
