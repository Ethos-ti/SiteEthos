#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
CDIR=$( pwd )
cd $DIR/../themes
zip -r ../zips/hacklab-theme.zip hacklab-theme -x "hacklab-theme/node_modules/*"
