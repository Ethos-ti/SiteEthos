#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
bash ./producao.sh

cd $DIR/../plugins/ethos-associados/dev-scripts
bash ./zip.sh

cd $DIR/../plugins/EthosDynamics365IntegrationPlugin/dev-scripts
bash ./producao.sh
mv ../ethos-dynamics-365-integration.zip ../../../zips/ethos-dynamics-365-integration.zip

cd $DIR/../plugins/EthosMigrationPlugin/dev-scripts
bash ./zip.sh
